@extends('layouts.admin')

@section('title', 'Gestion des Absences')
@section('page-title', 'Gestion des Absences')
@section('breadcrumb', 'Absences')

{{-- Bouton ajouter en haut a droite --}}
@section('topbar-actions')
    <a href="{{ route('admin.attendances.create') }}" class="btn btn-primary">
        <i class="mdi mdi-plus"></i> Enregistrer une presence
    </a>
@endsection

@section('content')

{{-- Mini statistiques : presents, absents, retards --}}
<div class="row mb-4">
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-success card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('dist/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle">
                <h4 class="font-weight-normal mb-3">
                    Presences <i class="mdi mdi-check-circle mdi-24px float-end"></i>
                </h4>
                <h2 class="mb-5">{{ $totalPresent }}</h2>
                <h6 class="card-text">Total presences</h6>
            </div>
        </div>
    </div>
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-danger card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('dist/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle">
                <h4 class="font-weight-normal mb-3">
                    Absences <i class="mdi mdi-close-circle mdi-24px float-end"></i>
                </h4>
                <h2 class="mb-5">{{ $totalAbsent }}</h2>
                <h6 class="card-text">Total absences</h6>
            </div>
        </div>
    </div>
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-warning card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('dist/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle">
                <h4 class="font-weight-normal mb-3">
                    Retards <i class="mdi mdi-clock mdi-24px float-end"></i>
                </h4>
                <h2 class="mb-5">{{ $totalLate }}</h2>
                <h6 class="card-text">Total retards</h6>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                {{-- En-tete avec compteur, recherche et filtre statut --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Registre des presences
                        <span class="badge badge-primary ms-2">{{ $attendances->total() }}</span>
                    </h4>
                    <div class="d-flex gap-2">
                        {{-- Filtre par statut --}}
                        <select id="statusFilter" class="form-control" style="width:180px;">
                            <option value="">Tous les statuts</option>
                            <option value="present">Present</option>
                            <option value="absent">Absent</option>
                            <option value="late">Retard</option>
                        </select>
                        {{-- Recherche --}}
                        <input type="text" id="searchInput" class="form-control" style="width:200px;" placeholder="Rechercher...">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Eleve</th>
                                <th>Classe</th>
                                <th>Date</th>
                                <th>Statut</th>
                                <th>Motif</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="attendanceTable">
                            @forelse($attendances as $attendance)
                            <tr>
                                {{-- Eleve --}}
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div style="width:38px;height:38px;border-radius:50%;background:#e74c3c;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:14px;flex-shrink:0;">
                                            {{ strtoupper(substr($attendance->student->first_name ?? 'E', 0, 1)) }}
                                        </div>
                                        <div class="ms-3">
                                            <strong>{{ $attendance->student->first_name ?? 'N/A' }} {{ $attendance->student->last_name ?? '' }}</strong>
                                        </div>
                                    </div>
                                </td>

                                {{-- Classe --}}
                                <td>
                                    <span class="badge badge-info">
                                        {{ $attendance->schoolClass->class_name ?? 'N/A' }}
                                    </span>
                                </td>

                                {{-- Date --}}
                                <td>{{ \Carbon\Carbon::parse($attendance->attendance_date)->format('d/m/Y') }}</td>

                                {{-- Statut avec badge colore --}}
                                <td>
                                    @if($attendance->status == 'present')
                                        <span class="badge badge-success">
                                            <i class="mdi mdi-check-circle"></i> Present
                                        </span>
                                    @elseif($attendance->status == 'absent')
                                        <span class="badge badge-danger">
                                            <i class="mdi mdi-close-circle"></i> Absent
                                        </span>
                                    @else
                                        <span class="badge badge-warning">
                                            <i class="mdi mdi-clock"></i> Retard
                                        </span>
                                    @endif
                                </td>

                                {{-- Motif --}}
                                <td>{{ $attendance->reason ?? 'Sans motif' }}</td>

                                {{-- Actions : modifier, supprimer --}}
                                <td>
                                    {{-- Modifier --}}
                                    <a href="{{ route('admin.attendances.edit', $attendance) }}" class="btn btn-sm btn-warning">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    {{-- Supprimer --}}
                                    <form action="{{ route('admin.attendances.destroy', $attendance) }}" method="POST" style="display:inline;" onsubmit="return confirm('Supprimer cet enregistrement ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="mdi mdi-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            {{-- Aucune presence --}}
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="mdi mdi-calendar-check mdi-48px d-block mb-2"></i>
                                    Aucune presence enregistree
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-3">
                    {{ $attendances->links() }}
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
{{-- Recherche et filtre combines en temps reel --}}
document.getElementById('searchInput').addEventListener('input', filterTable);
document.getElementById('statusFilter').addEventListener('change', filterTable);

function filterTable() {
    const q      = document.getElementById('searchInput').value.toLowerCase();
    const status = document.getElementById('statusFilter').value.toLowerCase();

    document.querySelectorAll('#attendanceTable tr').forEach(row => {
        const text        = row.textContent.toLowerCase();
        const matchQ      = text.includes(q);
        const matchStatus = status === '' || text.includes(status);
        row.style.display = (matchQ && matchStatus) ? '' : 'none';
    });
}
</script>
@endsection