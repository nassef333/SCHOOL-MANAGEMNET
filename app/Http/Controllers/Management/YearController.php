<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Year;
use Illuminate\Http\Request;

class YearController extends Controller
{
    public function index()
    {
        $years = Year::all();
        return view('years.index', compact('years'));
    }

    public function create()
    {
        return view('years.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Year::create($request->all());

        return redirect()->route('years.index')->with('success', 'Year created successfully.');
    }

    public function show(Year $year)
    {
        return view('years.show', compact('year'));
    }

    public function edit(Year $year)
    {
        return view('years.edit', compact('year'));
    }

    public function update(Request $request, Year $year)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $year->update($request->all());

        return redirect()->route('years.index')->with('success', 'Year updated successfully.');
    }

    public function destroy(Year $year)
    {
        $year->delete();

        return redirect()->route('years.index')->with('success', 'Year deleted successfully.');
    }
}
