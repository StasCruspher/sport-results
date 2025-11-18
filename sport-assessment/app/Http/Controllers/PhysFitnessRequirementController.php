<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PhysFitnessRequirement;
use App\Models\AgeGroup;
use App\Models\Category;
use Illuminate\Validation\Rule;

class PhysFitnessRequirementController extends Controller
{
    public function index(Request $request)
    {
        $ageGroups = AgeGroup::all();
        $categories = Category::all();

        $query = PhysFitnessRequirement::with(['ageGroup', 'category'])
            ->join('age_group', 'phys_fitness_requirement.age_group_id', '=', 'age_group.id')
            ->join('category', 'phys_fitness_requirement.category_id', '=', 'category.id')
            ->select('phys_fitness_requirement.*');

        if ($request->filled('gender')) {
            $query->where('phys_fitness_requirement.gender', $request->gender);
        }

        if ($request->filled('age_group_id')) {
            $query->where('phys_fitness_requirement.age_group_id', $request->age_group_id);
        }

        if ($request->filled('category_id')) {
            $query->where('phys_fitness_requirement.category_id', $request->category_id);
        }

        $query->orderBy('age_group.age_group_number', 'asc')
              ->orderBy('category.category_number', 'asc')
              ->orderBy('phys_fitness_requirement.exercise_threshold', 'desc')
              ->orderBy('phys_fitness_requirement.exercise_count', 'asc')
              ->orderBy('phys_fitness_requirement.total_points', 'asc')
              ->orderBy('phys_fitness_requirement.result', 'asc');

        $requirements = $query->get();

        return view('phys_fitness_requirement', compact('ageGroups', 'categories', 'requirements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'age_group_id' => [
                'required',
                'integer'
            ],
            'category_id' => [
                'required',
                'integer',
                'exists:category,id',
            ],
            'gender' => [
                'required',
                Rule::in(['чоловік', 'жінка']),
            ],
            'exercise_threshold' => [
                'required',
                'integer',
                'min:0',
            ],
            'exercise_count' => [
                'required',
                'integer',
                'min:3',
                'max:5'
            ],
            'total_points' => [
                'required',
                'integer',
                'min:0',
            ],
            'result' => [
                'required',
                'integer',
                'min:0',
            ],
        ], [
            'age_group_id.required' => 'Вікова група є обов’язковою.',
                           
            'category_id.required' => 'Категорія є обов’язковою.',

            'gender.required' => 'Стать є обов’язковою.',
            'gender.in' => 'Стать має бути "чоловік" або "жінка".',

            'exercise_threshold.required' => 'Порогове значення вправи є обов’язковим.',
            'exercise_threshold.integer' => 'Порогове значення вправи має бути числом.',
            'exercise_threshold.min' => 'Порогове значення вправи не може бути менше 0.',

            'exercise_count.required' => 'Кількість вправ є обов’язковою.',
            'exercise_count.integer' => 'Кількість вправ має бути числом.',
            'exercise_count.min' => 'Кількість вправ не може бути менше 3.',
            'exercise_count.max' => 'Кількість вправ не може бути більше 5.',

            'total_points.required' => 'Загальна кількість балів є обов’язковою.',
            'total_points.integer' => 'Загальна кількість балів має бути числом.',
            'total_points.min' => 'Загальна кількість балів не може бути менше 0.',

            'result.required' => 'Результат є обов’язковим.',
            'result.integer' => 'Результат має бути числом.',
            'result.min' => 'Результат не може бути менше 0.',
        ]);

        
        PhysFitnessRequirement::create($request->all());

        return redirect()->route('phys_fitness_requirement.index')->with('success', 'Вимогу успішно додано');
    }

    public function destroy($id)
    {
        $requirement = PhysFitnessRequirement::findOrFail($id);
        $requirement->delete();

        return redirect()->route('phys_fitness_requirement.index')->with('success', 'Вимогу успішно видалено');
    }
}
