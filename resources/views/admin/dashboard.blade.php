@extends('layouts.admin')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')
@section('breadcrumb', 'Accueil')

@section('content')

{{-- Statistiques ligne 1 --}}
<div class="row">
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-danger card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('dist/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle">
                <h4 class="font-weight-normal mb-3">Eleves <i class="mdi mdi-account-multiple mdi-24px float-end"></i></h4>
                <h2 class="mb-5">{{ $totalStudents }}</h2>
                <h6 class="card-text">Eleves inscrits</h6>
            </div>
        </div>
    </div>
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-info card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('dist/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle">
                <h4 class="font-weight-normal mb-3">Enseignants <i class="mdi mdi-account-tie mdi-24px float-end"></i></h4>
                <h2 class="mb-5">{{ $totalTeachers }}</h2>
                <h6 class="card-text">Enseignants actifs</h6>
            </div>
        </div>
    </div>
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-success card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('dist/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle">
                <h4 class="font-weight-normal mb-3">Classes <i class="mdi mdi-domain mdi-24px float-end"></i></h4>
                <h2 class="mb-5">{{ $totalClasses }}</h2>
                <h6 class="card-text">Classes actives</h6>
            </div>
        </div>
    </div>
</div>

{{-- Statistiques ligne 2 --}}
<div class="row">
    <div class="col-md-3 stretch-card grid-margin">
        <div class="card bg-gradient-warning card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('dist/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle">
                <h4 class="font-weight-normal mb-3">Matieres <i class="mdi mdi-book-open-variant mdi-24px float-end"></i></h4>
                <h2 class="mb-5">{{ $totalSubjects }}</h2>
                <h6 class="card-text">Matieres enseignees</h6>
            </div>
        </div>
    </div>
    <div class="col-md-3 stretch-card grid-margin">
        <div class="card bg-gradient-danger card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('dist/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle">
                <h4 class="font-weight-normal mb-3">Inscriptions <i class="mdi mdi-card-account-details mdi-24px float-end"></i></h4>
                <h2 class="mb-5">{{ $totalEnrollments }}</h2>
                <h6 class="card-text">Eleves inscrits</h6>
            </div>
        </div>
    </div>
    <div class="col-md-3 stretch-card grid-margin">
        <div class="card bg-gradient-info card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('dist/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle">
                <h4 class="font-weight-normal mb-3">Parents <i class="mdi mdi-account-heart mdi-24px float-end"></i></h4>
                <h2 class="mb-5">{{ $totalParents }}</h2>
                <h6 class="card-text">Parents enregistres</h6>
            </div>
        </div>
    </div>
    <div class="col-md-3 stretch-card grid-margin">
        <div class="card bg-gradient-success card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('dist/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle">
                <h4 class="font-weight-normal mb-3">Paiements <i class="mdi mdi-cash mdi-24px float-end"></i></h4>
                <h2 class="mb-5">{{ number_format($totalPayments, 0, ',', ' ') }} F</h2>
                <h6 class="card-text">Total recu</h6>
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