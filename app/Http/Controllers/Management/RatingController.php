<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index()
    {
        $ratings = Rating::all();
        return view('ratings.index', compact('ratings'));
    }

    public function create()
    {
        return view('ratings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'supervisor_id' => 'required|exists:users,id',
            'teacher_id' => 'required|exists:users,id',
            'molars_and_skills' => 'required|integer',
            'homework' => 'required|integer',
            'planning' => 'required|integer',
            'media_usage' => 'required|integer',
            'learning_strategy' => 'required|integer',
            'manage_class' => 'required|integer',
        ]);

        Rating::create($request->all());

        return redirect()->route('ratings.index')
            ->with('success', 'Rating created successfully.');
    }

    public function show(Rating $rating)
    {
        return view('ratings.show', compact('rating'));
    }

    public function edit(Rating $rating)
    {
        return view('ratings.edit', compact('rating'));
    }

    public function update(Request $request, Rating $rating)
    {
        $request->validate([
            'supervisor_id' => 'required|exists:users,id',
            'teacher_id' => 'required|exists:users,id',
            'molars_and_skills' => 'required|integer',
            'homework' => 'required|integer',
            'planning' => 'required|integer',
            'media_usage' => 'required|integer',
            'learning_strategy' => 'required|integer',
            'manage_class' => 'required|integer',
        ]);

        $rating->update($request->all());

        return redirect()->route('ratings.index')
            ->with('success', 'Rating updated successfully.');
    }

    public function destroy(Rating $rating)
    {
        $rating->delete();

        return redirect()->route('ratings.index')
            ->with('success', 'Rating deleted successfully.');
    }
}
