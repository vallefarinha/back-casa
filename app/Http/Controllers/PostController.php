<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;

use App\Models\Post;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

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
            'image' => 'required|string',

        ]);

        try {
            $post = Post::create([
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'category_id' => $request->input('category_id'),
                'author' => $request->input('author'),
                'image' => $request->input('image'),
            ]);

            return response()->json(['message' => 'Post creado', 'post' => $post], 201);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => 'Error al crear el post: ' . $e->getMessage()], 500);
        }
    }

    public function viewPost(string $id)
    {
        try {
            $post = Post::findOrFail($id);
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
                'author' => 'required|string|max:255',
                'image' => 'required|string',
            ]);

            $post = Post::findOrFail($id);
            $post->update($request->all());

            return response()->json(['message' => 'Post actualizado correctamente'], 200);
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar o post: ' . $e->getMessage());
            return response()->json(['error' => 'Post não pôde ser atualizado.'], 500);
        }
    }

    public function deletePost(string $id)
    {
        try {
            $post = Post::findOrFail($id);
            $post->delete();
            return response()->json(['message' => 'Post eliminado correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => 'Error al eliminar Post: ' . $e->getMessage()], 500);
        }
    }

}