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
            // Busca la categoría por su ID en la base de datos
            $category = Category::findOrFail($id);
            
            // Devuelve la categoría encontrada en formato JSON
            return response()->json(['category' => $category], 200);
        } catch (\Exception $e) {
            // Maneja cualquier error que ocurra durante la búsqueda de la categoría
            return response()->json(['error' => 'La categoría no pudo ser encontrada.'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
