<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AgeGroup;

class AgeGroupController extends Controller
{
    public function index(Request $request)
    {
        $query = AgeGroup::query();

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        $ageGroups = $query->get();

        return view('age_groups', compact('ageGroups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'age_group_number' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) use ($request) {
                    $exists = \App\Models\AgeGroup::where('age_group_number', $value)
                        ->where('gender', $request->gender)
                        ->whereNull('deleted_at')
                        ->exists();

                    if ($exists) {
                        $fail('Ця вікова група вже існує для цієї статі');
                    }
                },
            ],
            'description' => 'required|string',
            'gender' => 'required|in:чоловік,жінка',
        ], [
            'age_group_number.required' => 'Вкажіть номер вікової групи.',
            'age_group_number.integer' => 'Номер вікової групи повинен бути числом.',
            'age_group_number.min' => 'Номер вікової групи повинен бути більшим за 0.',
            'gender.required' => 'Вкажіть стать.',
            'gender.in' => 'Стать може бути лише «чоловік» або «жінка».',
            'description.required' => 'Опис вікової групи обов’язковий.'
        ]);

        AgeGroup::create($request->only('age_group_number', 'description', 'gender'));

        return redirect()->route('age_groups.index')->with('success', 'Додано!');
    }

    public function destroy(AgeGroup $ageGroup)
    {
        $ageGroup->delete();
        return redirect()->route('age_groups.index')->with('success', 'Видалено!');
    }
}
