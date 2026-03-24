@extends('layouts.admin')

@section('title', 'Emploi du Temps')
@section('page-title', 'Emploi du Temps')
@section('breadcrumb', 'Emploi du temps')

{{-- Bouton ajouter en haut a droite --}}
@section('topbar-actions')
    <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary">
        <i class="mdi mdi-plus"></i> Ajouter un creneau
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                {{-- En-tete avec compteur, recherche et filtre jour --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Planning des cours
                        <span class="badge badge-primary ms-2">{{ $schedules->count() }}</span>
                    </h4>
                    <div class="d-flex gap-2">
                        {{-- Filtre par jour --}}
                        <select id="dayFilter" class="form-control" style="width:160px;">
                            <option value="">Tous les jours</option>
                            <option value="lundi">Lundi</option>
                            <option value="mardi">Mardi</option>
                            <option value="mercredi">Mercredi</option>
                            <option value="jeudi">Jeudi</option>
                            <option value="vendredi">Vendredi</option>
                            <option value="samedi">Samedi</option>
                        </select>
                        {{-- Recherche --}}
                        <input type="text" id="searchInput" class="form-control" style="width:200px;" placeholder="Rechercher...">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Jour</th>
                                <th>Horaire</th>
                                <th>Matiere</th>
                                <th>Classe</th>
                                <th>Enseignant</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="scheduleTable">
                            @forelse($schedules as $schedule)
                            <tr>
                                {{-- Jour --}}
                                <td>
                                    <span class="badge badge-primary">
                                        {{ $schedule->day_of_week }}
                                    </span>
                                </td>

                                {{-- Horaire --}}
                                <td>
                                    <i class="mdi mdi-clock text-muted"></i>
                                    {{ substr($schedule->start_time, 0, 5) }} - {{ substr($schedule->end_time, 0, 5) }}
                                </td>

                                {{-- Matiere --}}
                                <td>{{ $schedule->subject->subject_name ?? 'N/A' }}</td>

                                {{-- Classe --}}
                                <td>
                                    <span class="badge badge-info">
                                        {{ $schedule->schoolClass->class_name ?? 'N/A' }}
                                    </span>
                                </td>

                                {{-- Enseignant --}}
                                <td>
                                    @if($schedule->teacher && $schedule->teacher->user)
                                        {{ $schedule->teacher->user->first_name }} {{ $schedule->teacher->user->last_name }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>

                            {{-- Actions : voir, modifier, supprimer --}}
                            <td>
                                {{-- Voir --}}
                                <a href="{{ route('admin.schedules.show', $schedule) }}" class="btn btn-sm btn-info">
                                    <i class="mdi mdi-eye"></i>
                                </a>
                                {{-- Modifier --}}
                                <a href="{{ route('admin.schedules.edit', $schedule) }}" class="btn btn-sm btn-warning">
                                    <i class="mdi mdi-pencil"></i>
                                </a>
                                {{-- Supprimer --}}
                                <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST" style="display:inline;" onsubmit="return confirm('Supprimer ce creneau ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="mdi mdi-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                            </tr>
                            @empty
                            {{-- Aucun creneau --}}
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="mdi mdi-clock-outline mdi-48px d-block mb-2"></i>
                                    Aucun creneau enregistre
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
{{-- Recherche et filtre jour combines en temps reel --}}
document.getElementById('searchInput').addEventListener('input', filterTable);
document.getElementById('dayFilter').addEventListener('change', filterTable);

function filterTable() {
    const q   = document.getElementById('searchInput').value.toLowerCase();
    const day = document.getElementById('dayFilter').value.toLowerCase();

    document.querySelectorAll('#scheduleTable tr').forEach(row => {
        const text     = row.textContent.toLowerCase();
        const matchQ   = text.includes(q);
        const matchDay = day === '' || text.includes(day);
        row.style.display = (matchQ && matchDay) ? '' : 'none';
    });
}
</script>
@endsection