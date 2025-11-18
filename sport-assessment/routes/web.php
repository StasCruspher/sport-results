<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgeGroupController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\MilRankController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\PhysFitnessRequirementController;
use App\Http\Controllers\RequirementController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Login & Logout
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// All protected routes
Route::middleware('auth')->group(function () {

    // Home redirect
    Route::get('/', fn() => redirect()->route('scores.index'));

    // Age Groups
    Route::get('/age-groups', [AgeGroupController::class, 'index'])->name('age_groups.index');
    Route::post('/age-groups', [AgeGroupController::class, 'store'])->name('age_groups.store');
    Route::delete('/age-groups/{ageGroup}', [AgeGroupController::class, 'destroy'])->name('age_groups.destroy');

    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Exercises
    Route::get('/exercises', [ExerciseController::class, 'index'])->name('exercises.index');
    Route::post('/exercises', [ExerciseController::class, 'store'])->name('exercises.store');
    Route::delete('/exercises/{exercise}', [ExerciseController::class, 'destroy'])->name('exercises.destroy');

    // Military Ranks
    Route::get('/mil-ranks', [MilRankController::class, 'index'])->name('mil-ranks.index');
    Route::post('/mil-ranks', [MilRankController::class, 'store'])->name('mil-ranks.store');
    Route::delete('/mil-ranks/{mil_rank}', [MilRankController::class, 'destroy'])->name('mil-ranks.destroy');

    // Participants
    Route::get('/participants', [ParticipantController::class, 'index'])->name('participants.index');
    Route::get('/participants/create', [ParticipantController::class, 'create'])->name('participants.create');
    Route::post('/participants', [ParticipantController::class, 'store'])->name('participants.store');
    Route::delete('/participants/{participant}', [ParticipantController::class, 'destroy'])->name('participants.destroy');
    Route::get('/participants/{participant}/scores', [ParticipantController::class, 'scores'])->name('participants.scores');

    // Physical Fitness Requirements
    Route::get('/phys-fitness-requirements', [PhysFitnessRequirementController::class, 'index'])->name('phys_fitness_requirement.index');
    Route::post('/phys-fitness-requirements', [PhysFitnessRequirementController::class, 'store'])->name('phys_fitness_requirement.store');
    Route::delete('/phys-fitness-requirements/{id}', [PhysFitnessRequirementController::class, 'destroy'])->name('phys_fitness_requirement.destroy');

    // Requirements for Exercises
    Route::get('/requirements/exercises', [RequirementController::class, 'exercises'])->name('requirements.exercises');
    Route::get('/requirements/{exercise}', [RequirementController::class, 'index'])->name('requirements.index');
    Route::post('/requirements/{exercise}', [RequirementController::class, 'store'])->name('requirements.store');
    Route::delete('/requirements/{requirement}', [RequirementController::class, 'destroy'])->name('requirements.destroy');

    // Scores
    Route::get('/scores', [ScoreController::class, 'index'])->name('scores.index');
    Route::get('/scores/create', [ScoreController::class, 'create'])->name('scores.create');
    Route::post('/scores', [ScoreController::class, 'store'])->name('scores.store');
    Route::get('/scores/{id}', [ScoreController::class, 'show'])->name('scores.show');
    Route::post('/score/update-result', [\App\Http\Controllers\ScoreController::class, 'updateResult'])
                                     ->name('score.update-result');

    // Units
    Route::get('/units', [UnitController::class, 'index'])->name('units.index');
    Route::post('/units', [UnitController::class, 'store'])->name('units.store');
    Route::delete('/units/{unit}', [UnitController::class, 'destroy'])->name('units.destroy');
});
