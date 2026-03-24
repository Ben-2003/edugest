<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\Teacher;

class ScheduleController extends Controller
{
    /* Jours de la semaine dans l'ordre — utilisé dans create/edit/index */
    const JOURS = [
        'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'
    ];

    /**
     * Affiche l'emploi du temps sous forme de grille par jour
     */
    public function index()
    {
        // Chargement de tous les créneaux avec leurs relations
        $schedules = Schedule::with(['schoolClass', 'subject', 'teacher'])
                             ->orderByRaw("FIELD(day_of_week, 'Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi')")
                             ->orderBy('start_time')
                             ->get();

        // Groupement par jour pour l'affichage en grille
        $byDay = $schedules->groupBy('day_of_week');

        $classes  = Classes::orderBy('class_name')->get();

        return view('admin.schedules.index', compact('schedules', 'byDay', 'classes'));
    }

    /**
     * Affiche le formulaire d'ajout d'un créneau
     */
    public function create()
    {
        $classes  = Classes::orderBy('class_name')->get();
        $subjects = Subject::orderBy('subject_name')->get();
        $teachers = Teacher::orderBy('last_name')->get();
        $jours    = self::JOURS;

        return view('admin.schedules.create', compact(
            'classes', 'subjects', 'teachers', 'jours'
        ));
    }

    /**
     * Enregistre un nouveau créneau
     */
    public function store(Request $request)
    {
        $request->validate([
            'class_id'   => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'day_of_week'=> 'required|in:Lundi,Mardi,Mercredi,Jeudi,Vendredi,Samedi',
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i|after:start_time',
        ]);

        // Vérifier qu'il n'y a pas de conflit de créneau pour cette classe
        $conflit = Schedule::where('class_id', $request->class_id)
                           ->where('day_of_week', $request->day_of_week)
                           ->where(function($q) use ($request) {
                               $q->whereBetween('start_time', [$request->start_time, $request->end_time])
                                 ->orWhereBetween('end_time', [$request->start_time, $request->end_time]);
                           })->exists();

        if ($conflit) {
            return back()->withErrors([
                'start_time' => 'Ce créneau horaire est déjà occupé pour cette classe !'
            ])->withInput();
        }

        Schedule::create($request->all());

        return redirect()->route('admin.schedules.index')
                         ->with('success', 'Créneau ajouté avec succès !');
    }

    /**
     * Affiche le formulaire de modification
     */
    public function edit(Schedule $schedule)
    {
        $classes  = Classes::orderBy('class_name')->get();
        $subjects = Subject::orderBy('subject_name')->get();
        $teachers = Teacher::orderBy('last_name')->get();
        $jours    = self::JOURS;

        return view('admin.schedules.edit', compact(
            'schedule', 'classes', 'subjects', 'teachers', 'jours'
        ));
    }

    /**
 * Affiche le detail d'un creneau
 */
public function show(Schedule $schedule)
{
    $schedule->load(['schoolClass', 'subject', 'teacher.user']);
    return view('admin.schedules.show', compact('schedule'));
}

    /**
     * Met à jour un créneau existant
     */
    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'class_id'   => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'day_of_week'=> 'required|in:Lundi,Mardi,Mercredi,Jeudi,Vendredi,Samedi',
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i|after:start_time',
        ]);

        $schedule->update($request->all());

        return redirect()->route('admin.schedules.index')
                         ->with('success', 'Créneau modifié avec succès !');
    }

    /**
     * Supprime un créneau
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('admin.schedules.index')
                         ->with('success', 'Créneau supprimé avec succès !');
    }
}