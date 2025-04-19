<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        return view('admin.category', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:categories',
            'price' => 'nullable|string',
        ]);

        $category = new Category();
        $category->title = $request->title;
        $category->price = $request->price;
        $category->save();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }


    // public function show(Category $category)
    // {
    //     $category->load('tickets.game.homeTeam', 'tickets.game.awayTeam', 'tickets.user');
    //     return view('admin.categories.show', compact('category'));
    // }



    public function update(Request $request, $categoryId)
    {
        $category = Category::find($categoryId);
        $request->validate([
            'title' => 'required|string|max:255|unique:categories,title,' . $category->id,
            'price' => 'nullable|string',
        ]);

        $category->title = $request->title;
        $category->price = $request->price;
        $category->save();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

   
    public function destroy($categoryId)
    {
        $category = Category::find($categoryId);
        // Check if category has tickets
        if ($category->tickets()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Cannot delete category with associated tickets.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
