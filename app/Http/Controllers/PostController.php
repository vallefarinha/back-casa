<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{

    public function viewPosts()
    {
        try {
            $posts = Post::all();
            return response()->json(['posts' => $posts], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => 'Error al visualizar los posts: ' . $e->getMessage()], 500);
        }
    }

    public function createPost(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:5000',
            'category_id' => 'required|exists:categories,id',
            'author' => 'required|string|max:255',
            'image' => 'required|image',
        ]);
    
        try {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
    
            $post = Post::create([
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'category_id' => $request->input('category_id'),
                'author' => $request->input('author'),
                'image' => $imageName,
            ]);
    
            return response()->json(['message' => 'Post creado', 'post' => $post], 201);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => 'Error al crear el post: ' . $e->getMessage()], 500);
        }
    }
    

    public function viewPost(string $id)
    {
        try {
            $post = Post::with('comments')->findOrFail($id);
            $post->content = nl2br($post->content);
            return response()->json(['post' => $post], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 500, 'message' => 'Post no encontrado.' . $e->getMessage()], 404);
        }
    }

    public function updatePost(Request $request, string $id)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string|max:5000',
                'category_id' => 'required|exists:categories,id',
                'author' => 'required|string',
                'image' => $request->hasFile('image') ? 'required|image' : '', 
            ]);
    
            $post = Post::findOrFail($id);
            $post->title = $request->input('title');
            $post->content = $request->input('content');
            $post->category_id = $request->input('category_id');
            $post->author = $request->input('author');
    
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = $image->getClientOriginalName();
    
                if ($post->image && file_exists(public_path('images/' . $post->image))) {
                    unlink(public_path('images/' . $post->image));
                }
    
                $image->move(public_path('images'), $imageName);
                $post->image = $imageName;
            }
    
            $post->save();
            return response()->json(['message' => 'Post actualizado correctamente'], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'El post no pudo ser actualizado.'], 500);
        }
    }
    


public function deletePost(string $id)
{
    try {
        $post = Post::findOrFail($id);
        $imagePath = public_path('images/') . $post->image;
        
        if (file_exists($imagePath)) {
            unlink($imagePath); 
        }

        $post->delete();

        return response()->json(['message' => 'Post eliminado correctamente'], 200);
    } catch (\Exception $e) {
        return response()->json(['status' => 500, 'message' => 'Error al eliminar Post: ' . $e->getMessage()], 500);
    }
}

}
