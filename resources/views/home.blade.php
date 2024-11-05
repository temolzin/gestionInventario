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

        @if ($user->hasRole('admin'))
            <div class="col-lg-12">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="department_id" class="form-label select2">Seleccionar Departamento</label>
                        <select id="departmentSelect" class="form-control select2" name="department_id" required>
                            <option value="">Seleccione un Departamento</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}"
                                    {{ $department->id == $departmentId ? 'selected' : '' }}>{{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        @endif

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalStock }}</h3>
                    <p>Artículos en Stock</p>
                </div>
                <div class="icon">
                    <i class="fas fa-box"></i>
                </div>
                @if ($user->hasRole('supervisor'))
                    <a href="{{ route('materials.index') }}" class="small-box-footer">
                        Más información <i class="fas fa-arrow-circle-right"></i>
                    </a>
                @endif
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
                @if ($user->hasRole('supervisor'))
                    <a href="{{ route('loans.index') }}" class="small-box-footer">
                        Más información <i class="fas fa-arrow-circle-right"></i>
                    </a>
                @endif
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
                @if ($user->hasRole('supervisor'))
                    <a href="{{ route('inventories.index') }}" class="small-box-footer">
                        Más información <i class="fas fa-arrow-circle-right"></i>
                    </a>
                @endif
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $totalStudents }}</h3>
                    <p>Solicitantes  Registrados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                @if ($user->hasRole('supervisor'))
                    <a href="{{ route('students.index') }}" class="small-box-footer">
                        Más información <i class="fas fa-arrow-circle-right"></i>
                    </a>
                @endif
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title inventoryCategoryChart-title">Gráfico de Inventario por Categoría</h3>
                    <button class="btn btn-primary btn-sm download-btn" onclick="downloadChart('inventoryCategoryChart', 'InventarioCategoria.png')">Descargar</button>
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
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title loanedMaterialsChart-title">Materiales Prestados Durante el Año</h3>
                    <button class="btn btn-primary btn-sm download-btn" onclick="downloadChart('loanedMaterialsChart', 'MaterialesPrestados.png')">Descargar</button>
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
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title inventoriesChart-title">Materiales Ingresados Durante el Año</h3>
                    <button class="btn btn-primary btn-sm download-btn" onclick="downloadChart('inventoriesChart', 'MaterialesIngresados.png')">Descargar</button>
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
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title studentParticipationChart-title">Participación de Solicitantes </h3>
                    <button class="btn btn-primary btn-sm download-btn" onclick="downloadChart('studentParticipationChart', 'ParticipacionSolicitantes .png')">Descargar</button>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="studentParticipationChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profiles/profile.css') }}">
    <style>
        .select2-container .select2-selection--single {
            height: 40px;
            display: flex;
            align-items: center;
        }
        .download-btn {
            padding: 8px 16px;
            font-size: 14px;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            height: 30px;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $('#departmentSelect').select2();

        $('#departmentSelect').on('change', function() {
            var departmentId = $(this).val();
            updateChartsAndBoxes(departmentId);
        });

        function updateChartsAndBoxes(departmentId) {
            if (departmentId) {
                $.ajax({
                    url: '{{ route('getDepartmentData') }}',
                    method: 'GET',
                    data: { department_id: departmentId },
                    success: function(data) {
                        setChartTitles(data.departmentName);
                        setBoxValues(data.totalStock, data.totalLoaned, data.totalInventories, data.totalStudents);
                        setChartData(data.materialsByCategory, data.loanedMaterialsByMonth, data.materialsByMonth, [data.activeStudents, data.inactiveStudents]);
                    },
                    error: function(xhr) {
                        console.error('Error en la solicitud AJAX:', xhr.responseText);
                        alert('Hubo un error al cargar los datos del departamento. Por favor, intente nuevamente.');
                    }
                });
            } else {
                setChartTitles();
                setBoxValues(0, 0, 0, 0);
                setChartData(Array(5).fill(0), Array(12).fill(0), Array(12).fill(0), [0, 0]);
            }
        }

        function setChartTitles(departmentName = '') {
            $('.inventoryCategoryChart-title').text(`Inventario por Categoría${departmentName ? ' - ' + departmentName : ''}`);
            $('.loanedMaterialsChart-title').text(`Materiales Prestados${departmentName ? ' - ' + departmentName : ''}`);
            $('.inventoriesChart-title').text(`Materiales Ingresados${departmentName ? ' - ' + departmentName : ''}`);
            $('.studentParticipationChart-title').text(`Participación de Solicitantes ${departmentName ? ' - ' + departmentName : ''}`);
        }

        function setBoxValues(stock, loaned, inventories, students) {
            $('.small-box.bg-success .inner h3').text(stock);
            $('.small-box.bg-warning .inner h3').text(loaned);
            $('.small-box.bg-danger .inner h3').text(inventories);
            $('.small-box.bg-primary .inner h3').text(students);
        }

        function setChartData(materialsByCategory, loanedMaterialsByMonth, materialsByMonth, studentParticipation) {
            inventoryCategoryChart.data.datasets[0].data = materialsByCategory;
            inventoryCategoryChart.update();

            loanedMaterialsChart.data.datasets[0].data = loanedMaterialsByMonth;
            loanedMaterialsChart.update();

            inventoriesChart.data.datasets[0].data = materialsByMonth;
            inventoriesChart.update();

            studentParticipationChart.data.datasets[0].data = studentParticipation;
            studentParticipationChart.update();
        }

        function downloadChart(chartId, fileName) {
            var canvas = document.getElementById(chartId);
            var link = document.createElement('a');
            link.href = canvas.toDataURL('image/png');
            link.download = fileName;
            link.click();
        }

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

        var ctx = document.getElementById('studentParticipationChart').getContext('2d');
        var totalStudents = {{ $totalStudents }};
        var activeStudents = {{ $activeStudents }};
        var inactiveStudents ={{$inactiveStudents}};
        var studentParticipationChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [
                    `Solicitantes  Activos en Préstamos`,
                    `Solicitantes  Sin Participación`
                ],
                datasets: [{
                    data: [activeStudents, inactiveStudents],
                    backgroundColor: ['#4CAF50', '#FF6384'],
                    hoverBackgroundColor: ['#66BB6A', '#FF8397'],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: {
                                size: 14
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.raw;
                                return `${label}: ${value} Solicitantes `;
                            }
                        }
                    }
                }
            }
        });
    </script>
@stop
