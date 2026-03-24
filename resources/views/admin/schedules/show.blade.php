@extends('layouts.admin')

@section('title', 'Detail Creneau')
@section('page-title', 'Detail Creneau')
@section('breadcrumb', 'Emploi du temps > Detail')

@section('content')
<div class="row">
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body text-center">

                {{-- Icone creneau --}}
                <div style="width:80px;height:80px;border-radius:50%;background:#6c5ce7;display:flex;align-items:center;justify-content:center;color:white;font-size:32px;margin:0 auto 16px;">
                    <i class="mdi mdi-clock-outline"></i>
                </div>

                <h4>{{ $schedule->day_of_week }}</h4>
                <p class="text-muted">
                    {{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }}
                </p>

                <span class="badge badge-info">{{ $schedule->schoolClass->class_name ?? 'N/A' }}</span>

                <div class="mt-4">
                    <a href="{{ route('admin.schedules.edit', $schedule) }}" class="btn btn-warning btn-sm me-2">
                        <i class="mdi mdi-pencil"></i> Modifier
                    </a>
                    <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary btn-sm">
                        <i class="mdi mdi-arrow-left"></i> Retour
                    </a>
                </div>

            </div>
        </div>
    </div>

    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-primary">
                    <i class="mdi mdi-clock-outline me-2"></i> Informations du creneau
                </h4>
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Jour</th>
                        <td><span class="badge badge-primary">{{ $schedule->day_of_week }}</span></td>
                    </tr>
                    <tr>
                        <th>Heure debut</th>
                        <td>{{ substr($schedule->start_time, 0, 5) }}</td>
                    </tr>
                    <tr>
                        <th>Heure fin</th>
                        <td>{{ substr($schedule->end_time, 0, 5) }}</td>
                    </tr>
                    <tr>
                        <th>Matiere</th>
                        <td>{{ $schedule->subject->subject_name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Classe</th>
                        <td><span class="badge badge-info">{{ $schedule->schoolClass->class_name ?? 'N/A' }}</span></td>
                    </tr>
                    <tr>
                        <th>Enseignant</th>
                        <td>
                            @if($schedule->teacher && $schedule->teacher->user)
                                {{ $schedule->teacher->user->first_name }} {{ $schedule->teacher->user->last_name }}
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Bouton supprimer --}}
<div class="row">
    <div class="col-md-12">
        <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST"
            onsubmit="return confirm('Supprimer ce creneau ?')" style="display:inline;">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="mdi mdi-trash-can"></i> Supprimer ce creneau
            </button>
        </form>
    </div>
</div>

@endsection