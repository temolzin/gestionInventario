@extends('adminlte::page')

@section('title', ' | Estudiantes')

@section('content')
    <section class="content">
        <div class="right_col" role="main">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Estudiantes</h2>
                        <div class="row">
                            <div class="col-lg-12 text-right">
                                <div class="btn-group" role="group" aria-label="Acciones de Estudiante">
                                    <button class="btn btn-success mr-2" data-toggle='modal' data-target="#createStudent">
                                        <i class="fa fa-plus"></i> Registrar estudiante
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-lg-4">
                        <form method="GET" action="{{ route('students.index') }}" class="my-3">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Buscar por nombre, apellido, matrícula" value="{{ request('search') }}">
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
                                    <table id="students" class="table table-striped display responsive nowrap"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>MATRÍCULA</th>
                                                <th>FOTO</th>
                                                <th>NOMBRE</th>
                                                <th>APELLIDO</th>
                                                <th>OPCIONES</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($students) <= 0)
                                                <tr>
                                                    <td colspan="7">No hay resultados</td>
                                                </tr>
                                            @else
                                                @foreach ($students as $student)
                                                    <tr>
                                                        <td scope="row">{{ $student->id }}</td>
                                                        <td scope="row">{{ $student->enrollment }}</td>
                                                        <td>
                                                            @if ($student->getFirstMediaUrl('studentGallery'))
                                                                <img src="{{ $student->getFirstMediaUrl('studentGallery') }}"
                                                                    alt="Foto de {{ $student->name }}"
                                                                    style="width: 50px; height: 50px; border-radius: 50%;">
                                                            @else
                                                                <img src="{{ asset('img/userDefault.png') }}"
                                                                    style="width: 50px; height: 50px; border-radius: 50%;">
                                                            @endif
                                                        </td>
                                                        <td>{{ $student->name }}</td>
                                                        <td>{{ $student->last_name }}</td>
                                                        <td>
                                                            <div class="btn-group" role="group" aria-label="Opciones">
                                                                <button type="button" class="btn btn-info mr-2"
                                                                    data-toggle="modal" title="Ver Detalles"
                                                                    data-target="#view{{ $student->id }}">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-warning mr-2"
                                                                    data-toggle="modal" title="Editar Datos"
                                                                    data-target="#edit{{ $student->id }}">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-primary mr-2"
                                                                    data-toggle="modal" title="Actualizar Imagen"
                                                                    data-target="#editPhoto{{ $student->id }}">
                                                                    <i class="fas fa-image"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-primary mr-2"
                                                                    data-toggle="modal" title="Prestamos"
                                                                    data-target="#loansModal{{ $student->id }}">
                                                                    <i class="fas fa-list"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-danger mr-2"
                                                                    data-toggle="modal" title="Eliminar Registro"
                                                                    data-target="#delete{{ $student->id }}">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                        @include('students.edit')
                                                        @include('students.delete')
                                                        @include('students.show')
                                                        @include('students.editPhoto')
                                                        @include('students.showLoans')
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                    @include('students.create')
                                    <div class="d-flex justify-content-center">
                                        {!! $students->links('pagination::bootstrap-4') !!}
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
            $('#students').DataTable({
                responsive: true,
                paging: false,
                info: false,
                searching: false
            });

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
        });
    </script>
@endsection
