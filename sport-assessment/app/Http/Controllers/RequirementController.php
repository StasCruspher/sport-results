<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Requirement;
use Illuminate\Http\Request;

class RequirementController extends Controller
{
    // Вивід списку вправ
    public function exercises()
    {
        $exercises = Exercise::orderBy('exercise_name')->get();
        return view('exercises', compact('exercises'));
    }

    // Вивід нормативів для конкретної вправи
    public function index(Exercise $exercise)
    {
        $requirements = Requirement::where('exercise_id', $exercise->id)->orderBy('result')->get();
        return view('requirements', compact('exercise', 'requirements'));
    }

    // Додавання нормативу
    public function store(Request $request, Exercise $exercise)
    {
        $request->validate([
              'exercise_id' => [
                  'required',
                  'integer'
                ],
              'result' => [
                  'required',
                  'numeric',
                  'between:0,99999.99', // максимальне значення відповідно до decimal(5,2)
              ],
              'point' => [
                  'required',
                  'integer',
                  'min:0',
              ],
              'gender' => [
                  'required',
                  Rule::in(['чоловік', 'жінка']),
              ],
          ], [
              'result.required' => 'Вкажіть результат.',
              'result.numeric' => 'Результат повинен бути числом.',
              'result.between' => 'Результат повинен бути від 0 до 99999.99.',
              'point.required' => 'Вкажіть кількість балів.',
              'point.integer' => 'Бали повинні бути цілим числом.',
              'point.min' => 'Бали не можуть бути від’ємними.',
              'gender.required' => 'Вкажіть стать.',
              'gender.in' => 'Стать може бути лише «чоловік» або «жінка».',
          ]);

        Requirement::create([
            'exercise_id' => $exercise->id,
            'result' => $request->result,
            'point' => $request->point,
            'gender' => $request->gender,
        ]);

        return redirect()->route('requirements.index', $exercise)->with('success', 'Норматив додано!');
    }

    // Видалення нормативу
    public function destroy(Requirement $requirement)
    {
        $exercise = $requirement->exercise;
        $requirement->delete();

        return redirect()->route('requirements.index', $exercise)->with('success', 'Норматив видалено!');
    }
}
