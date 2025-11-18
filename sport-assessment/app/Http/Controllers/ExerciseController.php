<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exercise;

class ExerciseController extends Controller
{
    public function index(Request $request)
    {
        $query = Exercise::query();

        if ($request->filled('name')) {
            $query->where('exercise_name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('description')) {
            $query->where('exercise_desc', 'like', '%' . $request->description . '%');
        }

        $exercises = $query->get()->sort(function($a, $b) {
            return strnatcmp($a->exercise_name, $b->exercise_name);
        });

        return view('exercises', compact('exercises'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'exercise_name' => [
                'required',
                'string',
                'max:6',
                function ($attribute, $value, $fail) {
                    $exists = \App\Models\Exercise::where('exercise_name', $value)
                        ->whereNull('deleted_at')
                        ->exists();

                    if ($exists) {
                        $fail('Така вправа вже існує.');
                    }
                },
            ],
            'exercise_desc' => [
                'required',
                'string',
            ],
        ], [
            'exercise_name.required' => 'Вкажіть назву вправи.',
            'exercise_name.max' => 'Максимальна довжина назви — 6 символів.',
            'exercise_desc.required' => 'Опис вправи обов’язковий.',
        ]);


        Exercise::create($request->only('exercise_name', 'exercise_desc'));

        return redirect()->route('exercises.index')->with('success', 'Вправу додано!');
    }

    public function destroy(Exercise $exercise)
    {
        $exercise->delete();
        return redirect()->route('exercises.index')->with('success', 'Вправу видалено!');
    }
}
