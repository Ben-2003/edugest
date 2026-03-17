@extends('layouts.admin')

@section('title', 'Modifier Bulletin')
@section('page-title', 'Modifier Bulletin')
@section('breadcrumb', 'Bulletins > Modifier')

@section('styles')
<style>
    {{-- Barre de progression de la moyenne --}}
    .avg-preview { display:flex; align-items:center; gap:12px; margin-top:8px; }
    .avg-bar { flex:1; height:8px; background:#e9ecef; border-radius:4px; overflow:hidden; }
    .avg-bar-fill { height:100%; border-radius:4px; transition:width 0.3s, background 0.3s; }
    .avg-label { font-size:12px; font-weight:700; width:60px; text-align:right; }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <i class="mdi mdi-file-document text-warning me-2"></i> Modifier le bulletin
                    <small class="text-muted d-block mt-1" style="font-size:13px;">
                        {{ $reportCard->student->first_name ?? '' }} {{ $reportCard->student->last_name ?? '' }}
                        — {{ $reportCard->schoolClass->class_name ?? '' }}
                        — {{ $reportCard->term }}
                    </small>
                </h4>

                <form action="{{ route('admin.report_cards.update', $reportCard) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="row">

                        {{-- Eleve --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Eleve <span class="text-danger">*</span></label>
                                <select name="student_id" class="form-control {{ $errors->has('student_id') ? 'is-invalid' : '' }}" required>
                                    <option value="">-- Choisir un eleve --</option>
                                    @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id', $reportCard->student_id) == $student->id ? 'selected' : '' }}>
                                        {{ $student->last_name }} {{ $student->first_name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('student_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Classe --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Classe <span class="text-danger">*</span></label>
                                <select name="class_id" class="form-control {{ $errors->has('class_id') ? 'is-invalid' : '' }}" required>
                                    <option value="">-- Choisir une classe --</option>
                                    @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id', $reportCard->class_id) == $class->id ? 'selected' : '' }}>
                                        {{ $class->class_name }}
                                        @if(isset($class->level)) — {{ $class->level }} @endif
                                    </option>
                                    @endforeach
                                </select>
                                @error('class_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Annee scolaire --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Annee scolaire <span class="text-danger">*</span></label>
                                <select name="school_year_id" class="form-control {{ $errors->has('school_year_id') ? 'is-invalid' : '' }}" required>
                                    <option value="">-- Choisir une annee --</option>
                                    @foreach($schoolYears as $year)
                                    <option value="{{ $year->id }}" {{ old('school_year_id', $reportCard->school_year_id) == $year->id ? 'selected' : '' }}>
                                        {{ $year->year_name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('school_year_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Trimestre --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Trimestre <span class="text-danger">*</span></label>
                                <select name="term" class="form-control {{ $errors->has('term') ? 'is-invalid' : '' }}" required>
                                    <option value="">-- Choisir --</option>
                                    <option value="Trimestre 1" {{ old('term', $reportCard->term) == 'Trimestre 1' ? 'selected' : '' }}>Trimestre 1</option>
                                    <option value="Trimestre 2" {{ old('term', $reportCard->term) == 'Trimestre 2' ? 'selected' : '' }}>Trimestre 2</option>
                                    <option value="Trimestre 3" {{ old('term', $reportCard->term) == 'Trimestre 3' ? 'selected' : '' }}>Trimestre 3</option>
                                </select>
                                @error('term')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Moyenne avec barre de progression --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Moyenne generale <span class="text-danger">*</span> <small class="text-muted">(sur 20)</small></label>
                                <input type="number" name="average" id="avgInput" step="0.01" min="0" max="20"
                                    class="form-control {{ $errors->has('average') ? 'is-invalid' : '' }}"
                                    value="{{ old('average', $reportCard->average) }}" required>
                                {{-- Barre de progression visuelle --}}
                                <div class="avg-preview">
                                    <div class="avg-bar">
                                        <div class="avg-bar-fill" id="avgBarFill" style="width:0%;"></div>
                                    </div>
                                    <span class="avg-label" id="avgLabel">— /20</span>
                                </div>
                                @error('average')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Rang --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Rang dans la classe</label>
                                <input type="number" name="rank" min="1" class="form-control"
                                    value="{{ old('rank', $reportCard->rank) }}" placeholder="Ex: 3">
                            </div>
                        </div>

                        {{-- Appreciation --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Appreciation du conseil de classe</label>
                                <input type="text" name="appreciation" class="form-control"
                                    value="{{ old('appreciation', $reportCard->appreciation) }}"
                                    placeholder="Ex: Bon trimestre, continuez vos efforts...">
                            </div>
                        </div>

                        {{-- Remarques --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Remarques</label>
                                <textarea name="remarks" class="form-control" rows="3"
                                    placeholder="Observations complementaires...">{{ old('remarks', $reportCard->remarks) }}</textarea>
                            </div>
                        </div>

                    </div>

                    {{-- Boutons --}}
                    <div class="text-right mt-4 border-top pt-3">
                        <a href="{{ route('admin.report_cards.index') }}" class="btn btn-secondary me-2">
                            <i class="mdi mdi-close"></i> Annuler
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="mdi mdi-check"></i> Enregistrer les modifications
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
{{-- Initialisation et mise a jour de la barre de moyenne --}}
function updateAvgBar(avg) {
    const fill = document.getElementById('avgBarFill');
    const lbl  = document.getElementById('avgLabel');
    if (isNaN(avg)) { fill.style.width = '0%'; lbl.textContent = '— /20'; return; }
    fill.style.width = Math.min(100, (avg / 20) * 100) + '%';
    lbl.textContent  = avg + '/20';
    {{-- Couleur selon la note --}}
    if (avg >= 16)      { fill.style.background = '#00b894'; lbl.style.color = '#00b894'; }
    else if (avg >= 12) { fill.style.background = '#6c5ce7'; lbl.style.color = '#6c5ce7'; }
    else if (avg >= 10) { fill.style.background = '#f59e0b'; lbl.style.color = '#f59e0b'; }
    else                { fill.style.background = '#e74c3c'; lbl.style.color = '#e74c3c'; }
}
{{-- Initialisation au chargement --}}
updateAvgBar(parseFloat(document.getElementById('avgInput').value));
document.getElementById('avgInput').addEventListener('input', function() {
    updateAvgBar(parseFloat(this.value));
});
</script>
@endsection