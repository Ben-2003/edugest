@extends('layouts.admin')

{{-- Titre de la page --}}
@section('title', 'Ajouter une Note')
@section('page-title', 'Ajouter une Note')

{{-- Fil d'ariane --}}
@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Accueil</a> ›
    <a href="{{ route('admin.grades.index') }}">Notes</a> ›
    <span style="color:var(--text);">Ajouter</span>
@endsection

@section('styles')
<style>
    .form-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; overflow:hidden; max-width:700px; animation:fadeUp 0.3s ease both; }
    .form-header { padding:24px 28px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:12px; }
    .form-icon { width:42px; height:42px; border-radius:12px; background:linear-gradient(135deg,var(--accent),#5a52d5); display:flex; align-items:center; justify-content:center; font-size:18px; color:white; }
    .form-title { font-size:16px; font-weight:600; }
    .form-subtitle { font-size:12px; color:var(--muted); margin-top:2px; }
    .form-body { padding:28px; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px; }
    .form-group { display:flex; flex-direction:column; gap:8px; margin-bottom:20px; }
    label { font-size:13px; font-weight:600; }
    label span { color:var(--accent3); }
    input, select { background:var(--surface2); border:1px solid var(--border); border-radius:10px; padding:11px 16px; color:var(--text); font-size:14px; font-family:'DM Sans',sans-serif; transition:all 0.2s; outline:none; width:100%; }
    input:focus, select:focus { border-color:var(--accent); box-shadow:0 0 0 3px rgba(108,99,255,0.1); }
    input::placeholder { color:var(--muted); }
    select option { background:var(--surface2); }
    .error-msg { font-size:12px; color:var(--accent3); margin-top:4px; }

    /* Indicateur visuel de la note en temps réel */
    .score-preview { display:flex; align-items:center; gap:12px; margin-top:8px; }
    .score-bar { flex:1; height:8px; background:var(--surface2); border-radius:4px; overflow:hidden; }
    .score-bar-fill { height:100%; border-radius:4px; transition:width 0.3s, background 0.3s; }
    .score-label { font-size:12px; font-weight:700; width:60px; text-align:right; }

    .form-actions { display:flex; gap:12px; margin-top:28px; padding-top:24px; border-top:1px solid var(--border); }
    .btn-submit { display:flex; align-items:center; gap:8px; background:linear-gradient(135deg,var(--accent),#5a52d5); color:white; border:none; border-radius:10px; padding:11px 24px; font-size:14px; font-weight:600; cursor:pointer; transition:all 0.2s; }
    .btn-submit:hover { transform:translateY(-1px); box-shadow:0 8px 20px rgba(108,99,255,0.3); }
    .btn-cancel { display:flex; align-items:center; gap:8px; background:var(--surface2); color:var(--muted); border:1px solid var(--border); border-radius:10px; padding:11px 24px; font-size:14px; font-weight:600; text-decoration:none; transition:all 0.2s; }
    .btn-cancel:hover { color:var(--text); }
</style>
@endsection

@section('content')
<div class="form-card">
    <div class="form-header">
        <div class="form-icon"><i class="fas fa-star"></i></div>
        <div>
            <div class="form-title">Nouvelle note</div>
            <div class="form-subtitle">Saisir la note d'un élève pour une matière</div>
        </div>
    </div>
    <div class="form-body">
        <form action="{{ route('admin.grades.store') }}" method="POST">
            @csrf

            {{-- Sélection de l'élève et de la matière --}}
            <div class="form-row">
                <div class="form-group">
                    <label>Élève <span>*</span></label>
                    <select name="student_id">
                        <option value="">-- Choisir un élève --</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->last_name }} {{ $student->first_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('student_id') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Matière <span>*</span></label>
                    <select name="subject_id">
                        <option value="">-- Choisir une matière --</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->subject_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('subject_id') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Sélection de la classe et de l'année scolaire --}}
            <div class="form-row">
                <div class="form-group">
                    <label>Classe <span>*</span></label>
                    <select name="class_id">
                        <option value="">-- Choisir une classe --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->class_name }} — {{ $class->level }}
                            </option>
                        @endforeach
                    </select>
                    @error('class_id') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Année scolaire <span>*</span></label>
                    <select name="school_year_id">
                        <option value="">-- Choisir une année --</option>
                        @foreach($schoolYears as $year)
                            <option value="{{ $year->id }}" {{ old('school_year_id') == $year->id ? 'selected' : '' }}>
                                {{ $year->year_label }}
                            </option>
                        @endforeach
                    </select>
                    @error('school_year_id') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Trimestre et note --}}
            <div class="form-row">
                <div class="form-group">
                    <label>Trimestre <span>*</span></label>
                    <select name="term">
                        <option value="">-- Choisir le trimestre --</option>
                        <option value="Trimestre 1" {{ old('term') == 'Trimestre 1' ? 'selected' : '' }}>Trimestre 1</option>
                        <option value="Trimestre 2" {{ old('term') == 'Trimestre 2' ? 'selected' : '' }}>Trimestre 2</option>
                        <option value="Trimestre 3" {{ old('term') == 'Trimestre 3' ? 'selected' : '' }}>Trimestre 3</option>
                    </select>
                    @error('term') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Note <span>*</span> <small style="color:var(--muted); font-weight:400;">(sur 20)</small></label>
                    <input type="number" name="score" id="scoreInput"
                           value="{{ old('score') }}" min="0" max="20" step="0.25"
                           placeholder="Ex: 14.50">
                    {{-- Barre de progression visuelle de la note --}}
                    <div class="score-preview">
                        <div class="score-bar">
                            <div class="score-bar-fill" id="scoreBarFill" style="width:0%; background:var(--accent3);"></div>
                        </div>
                        <span class="score-label" id="scoreLabel" style="color:var(--muted);">— /20</span>
                    </div>
                    @error('score') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Enregistrer la note</button>
                <a href="{{ route('admin.grades.index') }}" class="btn-cancel"><i class="fas fa-times"></i> Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    /* ── Mise à jour visuelle de la barre de note en temps réel ──
       Couleur rouge < 10 | orange 10-12 | violet 12-16 | vert >= 16 */
    document.getElementById('scoreInput').addEventListener('input', function() {
        const score = parseFloat(this.value);
        const fill  = document.getElementById('scoreBarFill');
        const label = document.getElementById('scoreLabel');

        if (isNaN(score)) {
            fill.style.width = '0%';
            label.textContent = '— /20';
            label.style.color = 'var(--muted)';
            return;
        }

        const pct = Math.min(100, (score / 20) * 100);
        fill.style.width = pct + '%';
        label.textContent = score + '/20';

        /* Couleur selon la note */
        if (score >= 16) {
            fill.style.background = 'var(--accent2)';
            label.style.color = 'var(--accent2)';
        } else if (score >= 12) {
            fill.style.background = 'var(--accent)';
            label.style.color = 'var(--accent)';
        } else if (score >= 10) {
            fill.style.background = '#f59e0b';
            label.style.color = '#f59e0b';
        } else {
            fill.style.background = 'var(--accent3)';
            label.style.color = 'var(--accent3)';
        }
    });
</script>
@endsection