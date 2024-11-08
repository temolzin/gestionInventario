@extends('adminlte::page')

@section('title', ' | Usuarios')

@section('content')
    <section class="content">
        <div class="right_col" role="main">
            <div class="col-md-12 col-sm-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Usuarios</h2>
                        <div class="row">
                            <div class="col-lg-12 text-right">
                                <div class="btn-group" role="group" aria-label="Acciones de Usuario">
                                    <button class="btn btn-success mr-2" data-toggle='modal' data-target="#createUser">
                                        <i class="fa fa-plus"></i> Registrar usuario
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-lg-4">
                        <form method="GET" action="{{ route('users.index') }}" class="my-3">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Buscar por nombre, apellido, email" value="{{ request('search') }}">
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
                                    <table id="users" class="table table-striped display responsive nowrap"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>FOTO</th>
                                                <th>NOMBRE</th>
                                                <th>APELLIDO</th>
                                                <th>EMAIL</th>
                                                <th>ROL</th>
                                                <th>OPCIONES</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($users->isEmpty())
                                                <tr>
                                                    <td colspan="7">No hay resultados</td>
                                                </tr>
                                            @else
                                                @foreach ($users as $user)
                                                    <tr>
                                                        <td scope="row">{{ $user->id }}</td>
                                                        <td>
                                                            @if ($user->getFirstMediaUrl('userGallery'))
                                                                <img src="{{ $user->getFirstMediaUrl('userGallery') }}"
                                                                    alt="Foto de {{ $user->name }}"
                                                                    style="width: 50px; height: 50px; border-radius: 50%;">
                                                            @else
                                                                <img src="{{ asset('img/userDefault.png') }}"
                                                                    style="width: 50px; height: 50px; border-radius: 50%;">
                                                            @endif
                                                        </td>
                                                        <td>{{ $user->name }}</td>
                                                        <td>{{ $user->last_name }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>{{ $user->getRoleNames()->implode(', ') }}</td>
                                                        <td>
                                                            <div class="btn-group" role="group" aria-label="Opciones">
                                                                <button type="button" class="btn btn-info mr-2"
                                                                    data-toggle="modal" title="Ver Detalles"
                                                                    data-target="#view{{ $user->id }}">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-warning mr-2"
                                                                    data-toggle="modal" title="Editar Datos"
                                                                    data-target="#edit{{ $user->id }}">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-primary mr-2"
                                                                    data-toggle="modal" title="Actualizar Imagen"
                                                                    data-target="#editPhoto{{ $user->id }}">
                                                                    <i class="fas fa-image"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-primary mr-2"
                                                                    data-toggle="modal" title="Editar Contraseña"
                                                                    data-target="#editPassword{{ $user->id }}">
                                                                    <i class="fas fa-lock"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-danger mr-2"
                                                                    data-toggle="modal" title="Eliminar Registro"
                                                                    data-target="#delete{{ $user->id }}">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                        @include('users.edit')
                                                        @include('users.delete')
                                                        @include('users.show')
                                                        @include('users.editPhoto')
                                                        @include('users.editPassword')
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                    @include('users.create')
                                    <div class="d-flex justify-content-center">
                                        {!! $users->links('pagination::bootstrap-4') !!}
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
            $('#users').DataTable({
                responsive: true,
                paging: false,
                info: false,
                searching: false,
                order: [[1, 'desc']],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Reporte de Usuarios'
                    },
                    {
                        extend: 'csvHtml5',
                        title: 'Reporte de Usuarios'
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Reporte de Usuarios'
                    },
                    {
                        extend: 'print',
                        title: 'Reporte de Usuarios'
                    }
                ]
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
