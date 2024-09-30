@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 class="m-0 text-dark">Inventio</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card bg-info">
                <div class="card-body">
                    <h5 class="card-title">¡Bienvenido a Inventio! 🌟</h5>
                    <p class="card-text">
                        Tu plataforma de gestión y control de inventario. Simplifica el manejo de materiales y recursos en un solo lugar, de forma eficiente y organizada. ¡Explora todas las funciones que hemos diseñado para facilitar tus tareas diarias!
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>150</h3>
                    <p>Artículos en Stock</p>
                </div>
                <div class="icon">
                    <i class="fas fa-box"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>53</h3>
                    <p>Artículos Prestados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hand-holding"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>20</h3>
                    <p>Artículos en Mantenimiento</p>
                </div>
                <div class="icon">
                    <i class="fas fa-tools"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>10</h3>
                    <p>Nuevas Solicitudes</p>
                </div>
                <div class="icon">
                    <i class="fas fa-bell"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Gráfico de Inventario</h3>
                </div>
                <div class="card-body">
                    <div class="chart">
                        
                        <canvas id="inventoryChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .small-box h3 {
            font-size: 2.2rem;
        }
        .card-title {
            font-size: 1.5rem;
        }
    </style>
@stop

@section('js')
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");

        var ctx = document.getElementById('inventoryChart').getContext('2d');
        var inventoryChart = new Chart(ctx, {
            type: 'bar', 
            data: {
                labels: ['Artículos en Stock', 'Artículos Prestados', 'En Mantenimiento', 'Nuevas Solicitudes'],
                datasets: [{
                    label: 'Cantidad',
                    data: [150, 53, 20, 10],
                    backgroundColor: ['#28a745', '#ffc107', '#dc3545', '#007bff'],
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@stop
