<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function createComment(Request $request)
    {
        try {
            $request->validate([
                'content' => 'required|string|max:1000',
                'author' => 'required|string',
                'email' => 'required|email',
                'post_id' => 'required|exists:posts,id',
            ]);
    
            $comment = Comment::create($request->all());
    
            return response()->json(['message' => 'Comentario guardado correctamente', 'comment' => $comment], 201);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => 'Error al crear el post: ' . $e->getMessage()], 500);
        }
    }
}
