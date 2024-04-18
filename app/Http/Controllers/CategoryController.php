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
    public function categories()
    {
        //
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
