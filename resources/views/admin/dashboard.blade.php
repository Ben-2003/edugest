@extends('layouts.admin')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')
@section('breadcrumb', 'Accueil')

@section('content')

{{-- Statistiques ligne 1 --}}
{{-- Statistiques ligne 1 --}}
<div class="row">
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card text-white" style="background:linear-gradient(135deg,#f093fb,#f5576c);min-height:unset;">
            <div class="card-body py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1" style="color:rgba(255,255,255,0.85);">Eleves inscrits</h6>
                        <h3 class="mb-0 font-weight-bold">{{ $totalStudents }}</h3>
                    </div>
                    <i class="mdi mdi-account-multiple mdi-36px" style="opacity:0.4;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card text-white" style="background:linear-gradient(135deg,#4facfe,#00f2fe);min-height:unset;">
            <div class="card-body py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1" style="color:rgba(255,255,255,0.85);">Enseignants</h6>
                        <h3 class="mb-0 font-weight-bold">{{ $totalTeachers }}</h3>
                    </div>
                    <i class="mdi mdi-account-tie mdi-36px" style="opacity:0.4;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card text-white" style="background:linear-gradient(135deg,#43e97b,#38f9d7);min-height:unset;">
            <div class="card-body py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1" style="color:rgba(255,255,255,0.85);">Classes actives</h6>
                        <h3 class="mb-0 font-weight-bold">{{ $totalClasses }}</h3>
                    </div>
                    <i class="mdi mdi-domain mdi-36px" style="opacity:0.4;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3 stretch-card grid-margin">
        <div class="card text-white" style="background:linear-gradient(135deg,#fa8231,#f7b731);min-height:unset;">
            <div class="card-body py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1" style="color:rgba(255,255,255,0.85);">Matieres</h6>
                        <h3 class="mb-0 font-weight-bold">{{ $totalSubjects }}</h3>
                    </div>
                    <i class="mdi mdi-book-open-variant mdi-36px" style="opacity:0.4;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 stretch-card grid-margin">
        <div class="card text-white" style="background:linear-gradient(135deg,#fd79a8,#e84393);min-height:unset;">
            <div class="card-body py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1" style="color:rgba(255,255,255,0.85);">Inscriptions</h6>
                        <h3 class="mb-0 font-weight-bold">{{ $totalEnrollments }}</h3>
                    </div>
                    <i class="mdi mdi-card-account-details mdi-36px" style="opacity:0.4;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 stretch-card grid-margin">
        <div class="card text-white" style="background:linear-gradient(135deg,#a29bfe,#6c5ce7);min-height:unset;">
            <div class="card-body py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1" style="color:rgba(255,255,255,0.85);">Parents</h6>
                        <h3 class="mb-0 font-weight-bold">{{ $totalParents }}</h3>
                    </div>
                    <i class="mdi mdi-account-heart mdi-36px" style="opacity:0.4;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 stretch-card grid-margin">
        <div class="card text-white" style="background:linear-gradient(135deg,#00b894,#00cec9);min-height:unset;">
            <div class="card-body py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1" style="color:rgba(255,255,255,0.85);">Paiements</h6>
                        <h3 class="mb-0 font-weight-bold">{{ number_format($totalPayments, 0, ',', ' ') }} F</h3>
                    </div>
                    <i class="mdi mdi-cash mdi-36px" style="opacity:0.4;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Graphique + Derniers eleves --}}
<div class="row">
    <div class="col-md-7 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Eleves par classe
                    <span class="badge badge-secondary float-end">{{ $currentYear->year_name ?? date('Y') }}</span>
                </h4>
                <canvas id="chartClasses" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-5 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Derniers eleves ajoutes</h4>
                @foreach($recentStudents as $student)
                <div class="d-flex align-items-center mb-3">
                    <div style="width:40px;height:40px;border-radius:50%;background:#6c5ce7;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:16px;flex-shrink:0;">
                        {{ strtoupper(substr($student->first_name, 0, 1)) }}
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0">{{ $student->first_name }} {{ $student->last_name }}</h6>
                        <small class="text-muted">{{ $student->registration_number }} — {{ $student->created_at->diffForHumans() }}</small>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- Liste classes --}}
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Liste des classes
                    <a href="{{ route('admin.classes.index') }}" class="btn btn-sm btn-primary float-end">Voir tout</a>
                </h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Classe</th>
                                <th>Enseignant</th>
                                <th>Eleves</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($classes as $class)
                            <tr>
                                <td>{{ $class->class_name }}</td>
                                <td>
                                    @if($class->teacher && $class->teacher->user)
                                        {{ $class->teacher->user->first_name }} {{ $class->teacher->user->last_name }}
                                    @else
                                        <span class="badge badge-warning">Non assigne</span>
                                    @endif
                                </td>
                                <td><span class="badge badge-success">{{ $class->enrollments->count() }}</span></td>
                                <td>
                                    <a href="{{ route('admin.classes.show', $class->id) }}" class="btn btn-sm btn-info">
                                        <i class="mdi mdi-eye"></i>
                                     </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('dist/assets/vendors/chart.js/Chart.min.js') }}"></script>
<script>
var ctx = document.getElementById('chartClasses').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($chartLabels) !!},
        datasets: [{
            label: 'Nombre d\'eleves',
            data: {!! json_encode($chartData) !!},
            backgroundColor: [
                'rgba(255, 99, 132, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)',
                'rgba(153, 102, 255, 0.6)',
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
scales: {
    yAxes: [{ ticks: { beginAtZero: true } }]
}
    }
});
</script>
@endsection