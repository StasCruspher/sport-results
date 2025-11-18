<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('category_number')->get();
        return view('categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_number' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) {
                    $exists = \App\Models\Category::where('category_number', $value)
                        ->whereNull('deleted_at')
                        ->exists();

                    if ($exists) {
                        $fail('Такий номер категорії вже існує.');
                    }
                },
            ],
        ], [
            'category_number.required' => 'Вкажіть номер категорії.',
            'category_number.integer' => 'Номер категорії повинен бути числом.',
            'category_number.min' => 'Номер категорії повинен бути більшим за 0.',
        ]);

        Category::create($request->only('category_number', 'description'));

        return redirect()->route('categories.index')->with('success', 'Категорію додано!');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Категорію видалено!');
    }
}
