<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function viewCategories()
    {
        try {
            $categories = Category::all();
            return response()->json(['categories' => $categories], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => 'Error al visualizar las categorias: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createCategory(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:categories',
            ]);

            $category = Category::create([
                'name' => $request->input('name'),
            ]);
            return response()->json(['message' => 'Categoria guardada correctamente', 'category' => $category], 201);
        } catch (\Exception $e) {

            return response()->json(['status' => 500, 'message' => 'Error al almacenar la categoria: ' . $e->getMessage()], 500);
        }
    }


    public function showCategory(string $id)
    {
        try {
            $category = Category::findOrFail($id);
            
            return response()->json(['category' => $category], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'La categoría no pudo ser encontrada.'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateCategory(Request $request, string $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:categories',
            ]);
            $category = Category::findOrFail($id);
            $category->update($request->all());
            return response()->json(['message' => 'Categoría actualizada correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'La categoría no pudo ser actualizada.'], 404);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyCategory(string $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return response()->json(['message' => 'Categoría eliminada correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => 'Error al eliminar Categoría: ' . $e->getMessage()], 500);
        }
    }
}
