<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MilRank;

class MilRankController extends Controller
{
    public function index(Request $request)
    {
        $query = MilRank::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'LIKE', "%{$search}%");
        }

        $ranks = $query->orderBy('id')->get();

        return view('mil_rank', compact('ranks'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:250',
                'regex:/^[A-Za-zА-Яа-яЁёІіЇїЄєҐґ\s\'’\-]+$/u',
                function ($attribute, $value, $fail) {
                    $exists = \App\Models\MilRank::where('name', $value)
                        ->whereNull('deleted_at') // тільки активні записи
                        ->exists();

                    if ($exists) {
                        $fail('Таке військове звання вже існує.');
                    }
                },
            ],
        ], [
            'name.required' => 'Назва військового звання обов’язкова.',
            'name.max' => 'Максимальна довжина — 250 символів.',
            'name.regex' => 'Звання може містити лише літери, пробіли, дефіси та апострофи.',
        ]);

        MilRank::create($request->only('name'));

        return redirect()->route('mil-ranks.index')->with('success', 'Звання додано!');
    }

    public function destroy(MilRank $mil_rank)
    {
        $mil_rank->delete();
        return redirect()->route('mil-ranks.index')->with('success', 'Звання видалено!');
    }
}
