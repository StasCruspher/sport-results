<?php

namespace App\Http\Controllers;

use App\Models\Score;
use App\Models\Unit;
use App\Models\Exercise;
use App\Models\ScoreExercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Result;
use App\Models\Participant;
use App\Models\ResultExercise;
use App\Models\Requirement;
use App\Models\PhysFitnessRequirement;


class ScoreController extends Controller
{
    public function index(Request $request)
    {
        $query = Score::with([
            'unit' => fn($q) => $q->withTrashed(),
            'results.participant'
        ]);

        if ($request->filled('participant_id')) {
            $query->whereIn('id', function($q) use ($request) {
                $q->select('score_id')
                  ->from('result')
                  ->where('participant_id', $request->participant_id);
            });
        }

        if ($request->filled('unit')) {
            $query->whereHas('unit', function ($q) use ($request) {
                $q->where('unit_name', 'like', '%' . $request->unit . '%');
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from . '-01');
        }
        if ($request->filled('date_to')) {
            $dateTo = date('Y-m-t', strtotime($request->date_to . '-01'));
            $query->whereDate('date', '<=', $dateTo);
        }

        if ($request->filled('exercise_count')) {
            $query->where('exercise_count', $request->exercise_count);
        }

        if ($request->filled('incomplete') && $request->incomplete) {
            $query->whereHas('results', function($q){
                $q->where('phys_fitness_point', 0);
            });
        }

        $sortDate = $request->filled('sort_date') && in_array($request->sort_date, ['asc', 'desc'])
            ? $request->sort_date
            : 'desc';

        $query->orderBy('date', $sortDate)
              ->orderBy(Unit::select('unit_name')
                     ->whereColumn('unit.id', 'score.unit_id'), 'asc');

        $scores = $query->paginate(10);

        // Для фільтру "кількість вправ"
        $exerciseCounts = Score::select('exercise_count')
            ->distinct()
            ->orderBy('exercise_count')
            ->pluck('exercise_count');

        return view('scores.index', compact('scores', 'exerciseCounts'));
    }


    public function create()
    {
        $units = Unit::all();
        $exercises = Exercise::all();

        return view('scores.create', compact('units', 'exercises'));
    }

public function store(Request $request)
{
    $request->validate([
        'unit_name' => 'required|string|exists:unit,unit_name',
        'exercises' => 'required|array|min:3|max:5',
        'date' => 'required|date',
    ], [
        'unit_name.required' => 'Вкажіть підрозділ.',
        'unit_name.exists' => 'Вказаний підрозділ не існує.',
        'exercises.required' => 'Вкажіть вправи.',
        'exercises.min' => 'Мінімум 3 вправи.',
        'exercises.max' => 'Максимум 5 вправ.',
        'date.required' => 'Вкажіть дату.',
        'date.date' => 'Невірний формат дати.',
    ]);

    // Знаходимо підрозділ по назві
    $unit = Unit::where('unit_name', $request->unit_name)->firstOrFail();

    $score = Score::create([
        'unit_id' => $unit->id,
        'date' => \Carbon\Carbon::createFromFormat('d.m.Y', $request->date)->format('Y-m-d'),
        'exercise_count' => count($request->exercises),
    ]);

    // Додаємо вибрані вправи
    foreach ($request->exercises as $exerciseId) {
        ScoreExercise::create([
            'score_id' => $score->id,
            'exercise_id' => $exerciseId,
        ]);
    }

    // Створюємо результати для всіх учасників підрозділу
    $participants = Participant::where('unit_id', $unit->id)->get();

    foreach ($participants as $participant) {
        $result = Result::create([
            'score_id' => $score->id,
            'participant_id' => $participant->id,
        ]);

        foreach ($request->exercises as $exerciseId) {
            ResultExercise::create([
                'result_id' => $result->id,
                'exercise_id' => $exerciseId,
            ]);
        }
    }

    return redirect()->route('scores.index')->with('success', 'Залік створено успішно!');
}

public function show($id)
{
    $score = Score::withTrashed()->findOrFail($id);

    $score->load(['unit' => fn($q) => $q->withTrashed()]);

    $results = Result::with([
        'participant' => fn($q) => $q->withTrashed()->with([
            'milRank'   => fn($q2) => $q2->withTrashed(),
            'ageGroup'  => fn($q2) => $q2->withTrashed(),
            'category'  => fn($q2) => $q2->withTrashed(),
        ]),
        'exercises.exercise' => fn($q) => $q->withTrashed(),
    ])
    ->where('score_id', $id)
    ->get();

    $exercises = $score->exercises()->withTrashed()->get();

    $participants = Participant::with([
        'milRank'  => fn($q) => $q->withTrashed(),
        'ageGroup' => fn($q) => $q->withTrashed(),
        'category' => fn($q) => $q->withTrashed(),
    ])->get();

    return view('scores.show', compact('participants', 'score', 'exercises', 'results'));
}



public function updateResult(Request $request)
{
    try {
        $participantId = $request->participant;
        $exerciseId = $request->exercise;
        $scoreId = $request->score;
        $inputResult = $request->result; // беремо як рядок, не float

        $participant = Participant::with(['ageGroup', 'category'])->findOrFail($participantId);
        $score = Score::with('scoreExercises')->findOrFail($scoreId);
        $exercise = Exercise::findOrFail($exerciseId);

        // Норматив 50 балів
        $req50 = Requirement::where('exercise_id', $exerciseId)
            ->where('gender', $participant->gender)
            ->where('point', 50)
            ->first();

        $isLowerBetter = false;
        if ($req50) {
            $anyOther = Requirement::where('exercise_id', $exerciseId)
                ->where('gender', $participant->gender)
                ->where('point', '<>', 50)
                ->orderBy('point', 'asc')
                ->first();

            if ($anyOther && bccomp($req50->result, $anyOther->result, 2) < 0) {
                $isLowerBetter = true; // менше = краще
            }
        }

        // Всі нормативи для цієї вправи
        $requirements = Requirement::where('exercise_id', $exerciseId)
            ->where('gender', $participant->gender)
            ->get();

        $isTimeBased = $this->isTimeBasedExercise($requirements);

        // Визначаємо норматив, що відповідає введеному результату
        if ($isLowerBetter) {
            $req = Requirement::where('exercise_id', $exerciseId)
                ->where('gender', $participant->gender)
                ->where('result', '>=', $inputResult)
                ->orderBy('result', 'asc')
                ->first();
        } else {
            $req = Requirement::where('exercise_id', $exerciseId)
                ->where('gender', $participant->gender)
                ->where('result', '<=', $inputResult)
                ->orderBy('result', 'desc')
                ->first();
        }

        $assignedPoint = $req ? $req->point : 0;

        // Розрахунок бонусу
        // Розрахунок бонусу
        $bonus = 0;

        if ($req50) {
            if ($isTimeBased) {
                // Часові нормативи (хвилини.секунди)
                $inputParts = explode('.', strval($inputResult));
                $inputMin = intval($inputParts[0]);
                $inputSec = isset($inputParts[1]) ? intval($inputParts[1]) : 0;

                $maxParts = explode('.', strval($req50->result));
                $maxMin = intval($maxParts[0]);
                $maxSec = isset($maxParts[1]) ? intval($maxParts[1]) : 0;

                $inputTotalSec = $inputMin * 60 + $inputSec;
                $maxTotalSec = $maxMin * 60 + $maxSec;

                if ($isLowerBetter && $inputTotalSec < $maxTotalSec) {
                    $bonus = $maxTotalSec - $inputTotalSec;
                } elseif (!$isLowerBetter && $inputTotalSec > $maxTotalSec) {
                    $bonus = $inputTotalSec - $maxTotalSec;
                }
            } else {
                // Десяткові нормативи (точність 2 знаки після коми)
                // Використовуємо BCMath, щоб уникнути помилок float
                if ($isLowerBetter) {
                    $diff = bcsub($req50->result, $inputResult, 2); // норматив - результат
                } else {
                    $diff = bcsub($inputResult, $req50->result, 2); // результат - норматив
                }

                // Конвертуємо у бонусні бали
                // Множимо на 10, щоб 0.1 = 1 бал
                $bonus = floor(bcmul($diff, '10', 2));
            }
        }

        $assignedPointWithBonus = ($assignedPoint >= 50) ? $assignedPoint + $bonus : $assignedPoint;


        // Збереження результату
        $result = Result::firstOrCreate([
            'participant_id' => $participantId,
            'score_id' => $scoreId
        ]);

        ResultExercise::updateOrCreate(
            [
                'result_id' => $result->id,
                'exercise_id' => $exerciseId,
            ],
            [
                'result' => $inputResult,
                'point' => $assignedPointWithBonus
            ]
        );

        // Підрахунок сумарних балів
        $pointSum = ResultExercise::where('result_id', $result->id)->sum('point');
        $result->point_sum = $pointSum;

        // Перевірка на фізпідготовку
        $totalExercises = $score->scoreExercises()->count();
        $completedExercises = ResultExercise::where('result_id', $result->id)->count();
        $physFitnessPoint = null;

        if ($completedExercises == $totalExercises) {
            $threshold = PhysFitnessRequirement::where('age_group_id', $participant->age_group_id)
                ->where('category_id', $participant->category_id)
                ->where('gender', $participant->gender)
                ->first();

            if ($threshold) {
                $allPassed = ResultExercise::where('result_id', $result->id)
                    ->where('point', '<', $threshold->exercise_threshold)
                    ->count() == 0;

                if ($allPassed) {
                    $grade = PhysFitnessRequirement::where('age_group_id', $participant->age_group_id)
                        ->where('category_id', $participant->category_id)
                        ->where('gender', $participant->gender)
                        ->where('exercise_count', $totalExercises)
                        ->where('total_points', '<=', $pointSum)
                        ->orderByDesc('total_points')
                        ->first();

                    $physFitnessPoint = $grade ? $grade->result : 0;
                } else {
                    $physFitnessPoint = 0;
                }
            }
        }

        $result->phys_fitness_point = $physFitnessPoint;
        $result->save();

        return response()->json([
            'assigned_point' => $assignedPointWithBonus,
            'point_sum' => $pointSum,
            'phys_fitness_point' => $physFitnessPoint ?? 0,
        ]);

    } catch (\Exception $e) {
        \Log::error('Помилка у updateResult: ' . $e->getMessage());
        return response()->json(['error' => 'Server error', 'message' => $e->getMessage()], 500);
    }
}

private function isTimeBasedExercise($requirements)
{
    foreach ($requirements as $req) {
        $parts = explode('.', strval($req->result));
        if (count($parts) == 2 && intval($parts[1]) > 59) {
            return false;
        }
    }
    return true;
}

private function determineStepByRequirementsCollection($requirements)
{
    $hasTwoDigits = false;
    $hasOneDigit = false;

    foreach ($requirements as $r) {
        $parts = explode('.', strval($r->result));
        if (count($parts) == 2) {
            $decimals = $parts[1];
            if (strlen($decimals) >= 2) {
                $hasTwoDigits = true;
                break;
            } elseif (strlen($decimals) == 1) {
                $hasOneDigit = true;
            }
        }
    }

    if ($hasTwoDigits) return 0.01;
    if ($hasOneDigit) return 0.1;
    return 1;
}

}
