<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Achievement;

class AchievementController extends Controller
{
    public function index() {
        $achievements = Achievement::all();
        return view('backend.achievements.index', compact('achievements'));
    }

    public function edit(Achievement $achievement) {
        return view('backend.achievements.edit', compact('achievement'));
    }

    public function update(Request $request, Achievement $achievement) {
        $request->validate([
            'title' => 'required|string|max:255',
            'count' => 'required|integer',
        ]);

        $achievement->update($request->all());

        return redirect()->route('achievements.index')->with('success', 'Achievement updated successfully.');
    }
}
