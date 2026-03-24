@extends('layouts.admin')

@section('title', 'Modifier Creneau')
@section('page-title', 'Modifier Creneau')
@section('breadcrumb', 'Emploi du temps > Modifier')

@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <i class="mdi mdi-clock-outline text-warning me-2"></i> Modifier le creneau
                    <small class="text-muted d-block mt-1" style="font-size:13px;">
                        {{ $schedule->day_of_week }} —
                        {{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }}
                    </small>
                </h4>

                <form action="{{ route('admin.schedules.update', $schedule) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="row">

                        {{-- Jour de la semaine --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jour <span class="text-danger">*</span></label>
                                <select name="day_of_week" class="form-control {{ $errors->has('day_of_week') ? 'is-invalid' : '' }}" required>
                                    <option value="">-- Choisir un jour --</option>
                                    @foreach($jours as $jour)
                                    <option value="{{ $jour }}" {{ old('day_of_week', $schedule->day_of_week) == $jour ? 'selected' : '' }}>
                                        {{ $jour }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('day_of_week')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Classe --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Classe <span class="text-danger">*</span></label>
                                <select name="class_id" class="form-control {{ $errors->has('class_id') ? 'is-invalid' : '' }}" required>
                                    <option value="">-- Choisir une classe --</option>
                                    @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id', $schedule->class_id) == $class->id ? 'selected' : '' }}>
                                        {{ $class->class_name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('class_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Matiere --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Matiere <span class="text-danger">*</span></label>
                                <select name="subject_id" class="form-control {{ $errors->has('subject_id') ? 'is-invalid' : '' }}" required>
                                    <option value="">-- Choisir une matiere --</option>
                                    @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ old('subject_id', $schedule->subject_id) == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->subject_name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('subject_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Enseignant --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Enseignant <span class="text-danger">*</span></label>
                                <select name="teacher_id" class="form-control {{ $errors->has('teacher_id') ? 'is-invalid' : '' }}" required>
                                    <option value="">-- Choisir un enseignant --</option>
                                    @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ old('teacher_id', $schedule->teacher_id) == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->user->first_name ?? '' }} {{ $teacher->user->last_name ?? '' }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('teacher_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Heure de debut --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Heure de debut <span class="text-danger">*</span></label>
                                <input type="time" name="start_time"
                                    class="form-control {{ $errors->has('start_time') ? 'is-invalid' : '' }}"
                                    value="{{ old('start_time', substr($schedule->start_time, 0, 5)) }}" required>
                                @error('start_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Heure de fin --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Heure de fin <span class="text-danger">*</span></label>
                                <input type="time" name="end_time"
                                    class="form-control {{ $errors->has('end_time') ? 'is-invalid' : '' }}"
                                    value="{{ old('end_time', substr($schedule->end_time, 0, 5)) }}" required>
                                @error('end_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                    </div>

                    {{-- Boutons --}}
                    <div class="text-right mt-4 border-top pt-3">
                        <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary me-2">
                            <i class="mdi mdi-close"></i> Annuler
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="mdi mdi-check"></i> Mettre a jour
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection