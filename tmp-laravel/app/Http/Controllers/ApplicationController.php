<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Mobility;
use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    public function create(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if ($user->role !== 'zak') {
            abort(403, 'Přihlášku může podat jen žák.');
        }

        $student = $user->student;

        if (! $student) {
            abort(403, 'K tomuto účtu není přiřazený profil žáka.');
        }

        $existing = $student->applications()->latest()->first();

        return view('applications.create', [
            'mobilities' => Mobility::where('status', 'active')->get(),
            'teachers' => Teacher::orderBy('last_name')->get(),
            'existing' => $existing,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->role !== 'zak' || ! $user->student) {
            abort(403);
        }

        $student = $user->student;

        $validated = $request->validate([
            'mobility_id' => ['required', 'exists:mobilities,id'],
            'class_teacher_id' => ['required', 'exists:teachers,id'],
            'english_teacher_id' => ['required', 'exists:teachers,id', 'different:class_teacher_id'],
            'preferred_type' => ['required', 'in:kratkodoba,dlouhodoba'],
            'gdpr_consent' => ['accepted'],
        ]);

        $already = $student->applications()
            ->where('mobility_id', $validated['mobility_id'])
            ->exists();

        if ($already) {
            return back()->withErrors([
                'mobility_id' => 'Na tuto stáž už máš podanou přihlášku.',
            ]);
        }

        Application::create([
            'student_id' => $student->id,
            'mobility_id' => $validated['mobility_id'],
            'class_teacher_id' => $validated['class_teacher_id'],
            'english_teacher_id' => $validated['english_teacher_id'],
            'preferred_type' => $validated['preferred_type'],
            'status' => 'draft',
            'gdpr_consent' => true,
            'submitted_at' => now(),
        ]);

        return redirect()->route('dashboard')->with('status', 'Přihláška byla uložena.');
    }
}