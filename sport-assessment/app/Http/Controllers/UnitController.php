<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;

class UnitController extends Controller
{
    public function index(Request $request)
    {
        $query = Unit::query();

        if ($request->filled('name')) {
            $query->where('unit_name', 'like', '%' . $request->name . '%');
        }

        $units = $query->orderBy('unit_name', 'asc')->get();

        return view('unit', compact('units'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'unit_name' => [
                'required',
                'string',
                'max:200',
                function ($attribute, $value, $fail) {
                    $exists = \App\Models\Unit::where('unit_name', $value)
                        ->whereNull('deleted_at')
                        ->exists();

                    if ($exists) {
                        $fail('Такий підрозділ вже існує.');
                    }
                },
            ],
        ], [
            'unit_name.required' => 'Назва підрозділу є обов’язковою.',
            'unit_name.max' => 'Максимальна довжина — 200 символів.',
        ]);


        Unit::create($request->only('unit_name'));

        return redirect()->route('units.index')->with('success', 'Підрозділ додано!');
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();
        return redirect()->route('units.index')->with('success', 'Підрозділ видалено!');
    }
}
