@extends('layouts.teacher')

@section('title', 'Tableau de bord Enseignant')
@section('page-title', 'Tableau de bord')
@section('breadcrumb', 'Accueil')

@section('content')

{{-- Infos classe --}}
@if($teacher && $class)
<div class="row column1">
    <div class="col-md-6 col-lg-3">
        <div class="full counter_section margin_bottom_30">
            <div class="couter_icon">
                <div><i class="fa fa-building yellow_color"></i></div>
            </div>
            <div class="counter_no">
                <div>
                    <p class="total_no">{{ $class->class_name }}</p>
                    <p class="head_couter">Ma classe</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="full counter_section margin_bottom_30">
            <div class="couter_icon">
                <div><i class="fa fa-users orange_color"></i></div>
            </div>
            <div class="counter_no">
                <div>
                    <p class="total_no">{{ $totalStudents }}</p>
                    <p class="head_couter">Eleves</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="full counter_section margin_bottom_30">
            <div class="couter_icon">
                <div><i class="fa fa-star green_color"></i></div>
            </div>
            <div class="counter_no">
                <div>
                    <p class="total_no">{{ $totalGrades }}</p>
                    <p class="head_couter">Notes saisies</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="full counter_section margin_bottom_30">
            <div class="couter_icon">
                <div><i class="fa fa-calendar red_color"></i></div>
            </div>
            <div class="counter_no">
                <div>
                    <p class="total_no">{{ $totalAbsences }}</p>
                    <p class="head_couter">Absences</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- Derniers eleves + EDT --}}
<div class="row">
    <div class="col-md-6">
        <div class="full graph_head">
            <div class="graph_head_tit"><h5>Mes eleves</h5></div>
            <div class="graph_head_opt">
                <a href="{{ route('teacher.grades.index') }}" class="btn btn-sm btn-primary">Notes</a>
                <a href="{{ route('teacher.attendances.index') }}" class="btn btn-sm btn-warning">Absences</a>
            </div>
        </div>
        @forelse($students as $student)
        <div class="full user_status_sec">
            <div class="user_status_icon">
                <div style="width:40px;height:40px;border-radius:50%;background:#6c5ce7;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;">
                    {{ strtoupper(substr($student->first_name, 0, 1)) }}
                </div>
            </div>
            <div class="user_stat_name">
                <h6>{{ $student->first_name }} {{ $student->last_name }}</h6>
                <p>{{ $student->registration_number }}</p>
            </div>
        </div>
        @empty
        <p class="text-muted">Aucun eleve dans votre classe.</p>
        @endforelse
    </div>

    <div class="col-md-6">
        <div class="full graph_head">
            <div class="graph_head_tit"><h5>Emploi du temps du jour</h5></div>
            <div class="graph_head_opt">
                <a href="{{ route('teacher.schedules') }}" class="btn btn-sm btn-info">Voir tout</a>
            </div>
        </div>
        @forelse($todaySchedules as $schedule)
        <div class="full user_status_sec">
            <div class="user_status_icon">
                <div style="width:40px;height:40px;border-radius:50%;background:#00b894;display:flex;align-items:center;justify-content:center;color:white;font-size:12px;font-weight:700;">
                    {{ substr($schedule->start_time, 0, 5) }}
                </div>
            </div>
            <div class="user_stat_name">
                <h6>{{ $schedule->subject->subject_name ?? 'Matiere' }}</h6>
                <p>{{ $schedule->start_time }} - {{ $schedule->end_time }}</p>
            </div>
        </div>
        @empty
        <p class="text-muted">Aucun cours aujourd'hui.</p>
        @endforelse
    </div>
</div>

@endsection