@extends('adminlte::page')

@section('title', ' | Préstamos')

@section('content')
    <section class="content">
        <div class="right_col" role="main">
            <div class="col-md-12 col-sm-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Préstamos</h2>
                        <div class="row">
                            <div class="col-lg-12 text-right">
                                <div class="btn-group" role="group" aria-label="Acciones de Usuario">
                                    <button class="btn btn-success mr-2" data-toggle='modal' data-target="#createLoan">
                                        <i class="fa fa-plus"></i> Registrar Préstamo
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="col-lg-4">
                        <form method="GET" action="{{ route('loans.index') }}" class="my-3">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Buscar por estudiante o estado" value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">Buscar</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="x_content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <table id="loans" class="table table-striped display responsive nowrap"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Estudiante</th>
                                                <th>Estado</th>
                                                <th>Fecha y Hora de creacion</th>
                                                <th>Fecha y Hora de Devolución</th>
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($loans) <= 0)
                                                <tr>
                                                    <td colspan="5">No hay resultados</td>
                                                </tr>
                                            @else
                                                @foreach ($loans as $loan)
                                                    <tr>
                                                        <td scope="row">{{ $loan->id }}</td>
                                                        <td>{{ $loan->student->name }} {{ $loan->student->last_name }}</td>
                                                        <td>{{ $loan->status }}</td>
                                                        <td>{{ $loan->created_at->format('d/m/Y g:i:A') }}</td>
                                                        <td>
                                                            {{ $loan->return_at ? \Carbon\Carbon::parse($loan->return_at)->format('d/m/Y g:i A') : 'N/A' }}
                                                        </td>
                                                        <td>
                                                            <div class="btn-group" role="group" aria-label="Opciones">
                                                                <button type="button" class="btn btn-info mr-2"
                                                                    data-toggle="modal" title="Ver Detalles"
                                                                    data-target="#view{{ $loan->id }}">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-warning mr-2"
                                                                    data-toggle="modal" title="Editar Préstamo"
                                                                    data-target="#edit{{ $loan->id }}">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-danger mr-2"
                                                                    data-toggle="modal" title="Eliminar Préstamo"
                                                                    data-target="#delete{{ $loan->id }}">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                                <a href="{{ route('loan.report.detail', $loan->id) }}"
                                                                    class="btn btn-primary mr-2" title="Generar Reporte">
                                                                    <i class="fas fa-file-pdf"></i>
                                                                </a>
                                                            </div>
                                                            @include('loans.edit')
                                                            @include('loans.delete')
                                                            @include('loans.show')
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                    @include('loans.create')
                                    <div class="d-flex justify-content-center">
                                        {!! $loans->links('pagination::bootstrap-4') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $('#loans').DataTable({
                responsive: true,
                paging: false,
                info: false,
                searching: false
            });

            $('.select2').select2();

            var successMessage = "{{ session('success') }}";
            var errorMessage = "{{ session('error') }}";

            if (successMessage) {
                Swal.fire({
                    title: 'Éxito',
                    text: successMessage,
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                });
            }
            if (errorMessage) {
                Swal.fire({
                    title: 'Error',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }

            $('#createLoan').on('shown.bs.modal', function() {
                $('.select2').select2({
                    dropdownParent: $(
                        '#createLoan') 
                });
            });

            $('#edit{{ $loan->id }}').on('shown.bs.modal', function() {
                $('.select2').select2({
                    dropdownParent: $('#edit{{ $loan->id }}')
                });
            });
        });
    </script>
@endsection
@section('css')
    <style>
        .select2-container {
            width: 100% !important; 
        }
        .select2-selection--single {
            height: 40px !important; 
            display: flex; 
            align-items: center; 
            margin-top: 0 !important; 
        }
        label {
            display: block; 
            margin-bottom: 5px; 
        }
    </style>
@endsection

