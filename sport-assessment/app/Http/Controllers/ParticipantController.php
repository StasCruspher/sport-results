<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participant;
use App\Models\MilRank;
use App\Models\Category;
use App\Models\AgeGroup;
use App\Models\Unit;
use Illuminate\Validation\Rule;

class ParticipantController extends Controller
{
    public function index(Request $request)
    {
        $query = Participant::with([
            'milRank' => fn($q) => $q->withTrashed(),
            'category' => fn($q) => $q->withTrashed(),
            'ageGroup' => fn($q) => $q->withTrashed(),
            'unit' => fn($q) => $q->withTrashed()
        ])->whereHas('unit');

        if ($request->filled('fullname')) {
            $query->where('fullname', 'LIKE', '%' . $request->fullname . '%');
        }

        if ($request->filled('badge_number')) {
            $query->where('badge_number', $request->badge_number);
        }

        if ($request->filled('mil_rank_id')) {
            $query->where('mil_rank_id', $request->mil_rank_id);
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('age_group_id')) {
            $query->where('age_group_id', $request->age_group_id);
        }

        if ($request->filled('unit_id')) {
            $query->where('unit_id', $request->unit_id);
        }

        $participants = $query->orderBy('fullname')->get();

        $milRanks = MilRank::orderBy('name')->get();
        $categories = Category::orderBy('category_number')->get();
        $ageGroups = AgeGroup::orderBy('age_group_number')->get();
        $units = Unit::orderBy('unit_name')->get();

        return view('participant.index', compact(
            'participants',
            'milRanks',
            'categories',
            'ageGroups',
            'units'
        ));
    }


    public function create()
    {
        $milRanks = MilRank::orderBy('name')->get();
        $categories = Category::orderBy('category_number')->get();
        $ageGroups = AgeGroup::orderBy('age_group_number')->get();
        $units = Unit::orderBy('unit_name')->get();

        return view('participant.create', compact('milRanks', 'categories', 'ageGroups', 'units'));
    }

    public function store(Request $request)
    {
            $request->validate([
                'fullname' => [
                    'required',
                    'string',
                    'max:200',
                    'regex:/^[A-Za-zА-Яа-яЁёІіЇїЄєҐґ\s\'’\-]+$/u',
                ],
                'mil_rank_id' => [
                    'required',
                    'integer',
                    'exists:mil_rank,id'
                ],
                'gender' => [
                    'required',
                    Rule::in(['чоловік', 'жінка']),
                ],
                'badge_number' => [
                    'nullable',
                    'integer',
                ],
                'category_id' => [
                    'required',
                    'integer'
                ],
                'age_group_id' => [
                    'required',
                    'integer'
                ],
                'unit_id' => [
                    'required',
                    'integer',
                    'exists:unit,id',
                ],
            ], [
                'fullname.required' => 'Вкажіть ПІБ учня.',
                'fullname.max' => 'Максимальна довжина ПІБ — 200 символів.',
                'fullname.regex' => 'ПІБ може містити лише літери, пробіли, дефіси та апострофи.',
                'mil_rank_id.required' => 'Вкажіть військове звання.',
                'mil_rank_id.exists' => 'Вказане військове звання не існує.',
                'gender.required' => 'Вкажіть стать.',
                'gender.in' => 'Стать може бути лише «чоловік» або «жінка».',
                'badge_number.integer' => 'Номер жетона повинен бути числом.',
                'category_id.required' => 'Вкажіть категорію.',
                'age_group_id.required' => 'Вкажіть вікову групу.',
                'unit_id.required' => 'Вкажіть підрозділ.',
                'unit_id.exists' => 'Вказаний підрозділ не існує.'
            ]);

        Participant::create($request->all());

        return redirect()->route('participants.index')->with('success', 'Учасника додано!');
    }

    public function destroy(Participant $participant)
    {
        $participant->delete();
        return redirect()->route('participants.index')->with('success', 'Учасника видалено!');
    }
    
    public function scores(Participant $participant)
    {
        return redirect()->route('scores.index', ['participant_id' => $participant->id]);
    }
}
