@extends('adminlte::page')

@section('title', ' | Dashboard')

@section('content_header')
    <h1 class="m-0 text-dark">Inventio</h1>
@stop

@section('content')
    <div class="row">
        <div class="container-fluid">
            <div class="card-box head">
                <div class="row align-items-center">
                    <div class="col-md-2 text-center">
                        @if ($user->getFirstMediaUrl('userGallery'))
                            <img src="{{ $user->getFirstMediaUrl('userGallery') }}" alt="Foto de {{ $user->name }}">
                        @else
                            <img src="{{ asset('img/userDefault.png') }}">
                        @endif
                    </div>
                    <div class="col-md-8">
                        <h4 class="font-weight-bold text-capitalize welcome">Bienvenid@</h4>
                        <h1 class="font-weight-bold text-blue">{{ $user->name }} {{ $user->last_name }}</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalStock }}</h3>
                    <p>Artículos en Stock</p>
                </div>
                <div class="icon">
                    <i class="fas fa-box"></i>
                </div>
                <a href="{{ route('materials.index') }}" class="small-box-footer">
                    Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $totalLoaned }}</h3>
                    <p>Artículos Prestados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hand-holding"></i>
                </div>
                <a href="{{ route('loans.index') }}" class="small-box-footer">
                    Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $totalInventories }}</h3>
                    <p>Inventarios Creados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-box"></i>
                </div>
                <a href="{{ route('inventories.index') }}" class="small-box-footer">
                    Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $totalStudents }}</h3>
                    <p>Estudiantes Registrados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('students.index') }}" class="small-box-footer">
                    Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Gráfico de Inventario por Categoría</h3>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="inventoryCategoryChart"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Materiales Prestados Durante el Año</h3>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="loanedMaterialsChart"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Materiales Ingresados Durante el Año</h3>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="inventoriesChart"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Participación de Estudiantes en los Préstamos</h3>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="studentParticipationChart"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profiles/profile.css') }}">
@stop

@section('js')
    <script>
        var ctx = document.getElementById('inventoryCategoryChart').getContext('2d');
        var inventoryCategoryChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [
                    @foreach ($materialsByCategory as $category)
                        '{{ $category->category->name }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Cantidad de Materiales',
                    data: [
                        @foreach ($materialsByCategory as $category)
                            {{ $category->total }},
                        @endforeach
                    ],
                    backgroundColor: ['#28a745', '#ffc107', '#dc3545', '#007bff', '#17a2b8', '#ff9f40'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    }
                }
            }
        });
        var ctx = document.getElementById('loanedMaterialsChart').getContext('2d');
        var loanedMaterialsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre',
                    'Octubre', 'Noviembre', 'Diciembre'
                ],
                datasets: [{
                    label: 'Materiales Prestados',
                    data: [
                        {{ $loanedMaterialsByMonth[1] }},
                        {{ $loanedMaterialsByMonth[2] }},
                        {{ $loanedMaterialsByMonth[3] }},
                        {{ $loanedMaterialsByMonth[4] }},
                        {{ $loanedMaterialsByMonth[5] }},
                        {{ $loanedMaterialsByMonth[6] }},
                        {{ $loanedMaterialsByMonth[7] }},
                        {{ $loanedMaterialsByMonth[8] }},
                        {{ $loanedMaterialsByMonth[9] }},
                        {{ $loanedMaterialsByMonth[10] }},
                        {{ $loanedMaterialsByMonth[11] }},
                        {{ $loanedMaterialsByMonth[12] }}
                    ],
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                }
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('inventoriesChart').getContext('2d');
            var inventoriesChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
                        'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                    ],
                    datasets: [{
                        label: 'Cantidad de materiales',
                        data: @json(array_values($materialsByMonth)),
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
        document.addEventListener("DOMContentLoaded", function() {
            var ctx = document.getElementById('studentParticipationChart').getContext('2d');
            var participationRate = {{ $participationRate }};
            var totalStudents = {{ $totalStudents }};
            var activeStudents = {{ $activeStudents }};
            var chart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Estudiantes Activos en Préstamos', 'Estudiantes Sin Participación'],
                    datasets: [{
                        data: [activeStudents, totalStudents - activeStudents],
                        backgroundColor: ['#4CAF50', '#FF6384']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        });
    </script>
@stop
