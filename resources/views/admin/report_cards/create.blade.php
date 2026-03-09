@extends('layouts.admin')

@section('title', 'Nouveau Bulletin')
@section('page-title', 'Nouveau Bulletin')

@section('breadcrumb')
    <a href="{{ route('admin.dashboard') }}">Accueil</a> ›
    <a href="{{ route('admin.report_cards.index') }}">Bulletins</a> ›
    <span style="color:var(--text);">Créer</span>
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
    input, select, textarea { background:var(--surface2); border:1px solid var(--border); border-radius:10px; padding:11px 16px; color:var(--text); font-size:14px; font-family:'DM Sans',sans-serif; transition:all 0.2s; outline:none; width:100%; }
    input:focus, select:focus, textarea:focus { border-color:var(--accent); box-shadow:0 0 0 3px rgba(108,99,255,0.1); }
    input::placeholder { color:var(--muted); }
    select option { background:var(--surface2); }
    textarea { resize:vertical; min-height:100px; }
    .error-msg { font-size:12px; color:var(--accent3); margin-top:4px; }

    /* Barre de progression de la moyenne */
    .avg-preview { display:flex; align-items:center; gap:12px; margin-top:8px; }
    .avg-bar { flex:1; height:8px; background:var(--surface2); border-radius:4px; overflow:hidden; }
    .avg-bar-fill { height:100%; border-radius:4px; transition:width 0.3s, background 0.3s; }
    .avg-label { font-size:12px; font-weight:700; width:60px; text-align:right; }

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
        <div class="form-icon"><i class="fas fa-file-alt"></i></div>
        <div>
            <div class="form-title">Nouveau bulletin</div>
            <div class="form-subtitle">Créer le bulletin scolaire d'un élève</div>
        </div>
    </div>
    <div class="form-body">
        <form action="{{ route('admin.report_cards.store') }}" method="POST">
            @csrf

            {{-- Élève et classe --}}
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
            </div>

            {{-- Année scolaire et trimestre --}}
            <div class="form-row">
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
            </div>

            {{-- Moyenne générale --}}
            <div class="form-group">
                <label>Moyenne générale <span>*</span> <small style="color:var(--muted); font-weight:400;">(sur 20)</small></label>
                <input type="number" name="average" id="avgInput"
                       value="{{ old('average') }}" min="0" max="20" step="0.01"
                       placeholder="Ex: 13.50">
                {{-- Barre de progression visuelle --}}
                <div class="avg-preview">
                    <div class="avg-bar">
                        <div class="avg-bar-fill" id="avgBarFill" style="width:0%; background:var(--accent3);"></div>
                    </div>
                    <span class="avg-label" id="avgLabel" style="color:var(--muted);">— /20</span>
                </div>
                @error('average') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            {{-- Appréciation du professeur --}}
            <div class="form-group">
                <label>Appréciation <small style="color:var(--muted); font-weight:400;">(optionnel)</small></label>
                <textarea name="remarks" placeholder="Ex: Élève sérieux, des efforts à fournir en mathématiques...">{{ old('remarks') }}</textarea>
                @error('remarks') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Créer le bulletin</button>
                <a href="{{ route('admin.report_cards.index') }}" class="btn-cancel"><i class="fas fa-times"></i> Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    /* Barre de progression de la moyenne en temps réel */
    document.getElementById('avgInput').addEventListener('input', function() {
        const avg  = parseFloat(this.value);
        const fill = document.getElementById('avgBarFill');
        const lbl  = document.getElementById('avgLabel');

        if (isNaN(avg)) {
            fill.style.width = '0%';
            lbl.textContent  = '— /20';
            lbl.style.color  = 'var(--muted)';
            return;
        }

        fill.style.width = Math.min(100, (avg / 20) * 100) + '%';
        lbl.textContent  = avg + '/20';

        if (avg >= 16)      { fill.style.background = 'var(--accent2)'; lbl.style.color = 'var(--accent2)'; }
        else if (avg >= 12) { fill.style.background = 'var(--accent)';  lbl.style.color = 'var(--accent)'; }
        else if (avg >= 10) { fill.style.background = '#f59e0b';         lbl.style.color = '#f59e0b'; }
        else                { fill.style.background = 'var(--accent3)'; lbl.style.color = 'var(--accent3)'; }
    });
</script>
@endsection