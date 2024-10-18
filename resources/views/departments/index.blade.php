@extends('adminlte::page')

@section('title', ' | Departamentos')

@section('content')
<section class="content">
    <div class="right_col" role="main">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Departamentos</h2>
                    <div class="row">
                        <div class="col-lg-12 text-right">
                            <div class="btn-group" role="group" aria-label="Acciones de Departamento">
                                <button class="btn btn-success mr-2" data-toggle='modal' data-target="#createDepartment">
                                    <i class="fa fa-plus"></i> Registrar departamento
                                </button>
                            </div>
                        </div>
                    </div>                    
                    <div class="clearfix"></div>
                </div>
                <div class="col-lg-4">
                    <form method="GET" action="{{ route('departments.index') }}" class="my-3">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Buscar por nombre" value="{{ request('search') }}">
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
                                <table id="departments" class="table table-striped display responsive nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Foto</th>
                                            <th>Nombre</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($departments) <= 0)
                                        <tr>
                                            <td colspan="5">No hay resultados</td>
                                        </tr>
                                        @else
                                        @foreach($departments as $department)
                                        <tr>
                                            <td scope="row">{{ $department->id }}</td>
                                            <td>
                                                @if ($department->getFirstMediaUrl('departmentGallery'))
                                                    <img src="{{ $department->getFirstMediaUrl('departmentGallery') }}" alt="Foto de {{ $department->name }}" style="width: 50px; height: 50px; border-radius: 50%;">
                                                @else
                                                    <img src="{{ asset('img/logo.png') }}" style="width: 50px; height: 50px; border-radius: 50%;">
                                                @endif
                                            </td>
                                            <td>{{ $department->name }}</td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Opciones">
                                                    <button type="button" class="btn btn-info mr-2" data-toggle="modal" title="Ver Detalles" data-target="#view{{ $department->id }}">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-warning mr-2" data-toggle="modal" title="Editar Datos" data-target="#edit{{ $department->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-primary mr-2" data-toggle="modal" title="Actualizar Imagen" data-target="#editPhoto{{ $department->id }}">
                                                        <i class="fas fa-image"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger mr-2" data-toggle="modal" title="Eliminar Registro" data-target="#delete{{ $department->id }}">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            @include('departments.edit')
                                            @include('departments.delete')
                                            @include('departments.show')
                                            @include('departments.editPhoto')
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                @include('departments.create')
                                <div class="d-flex justify-content-center">
                                    {!! $departments->links('pagination::bootstrap-4') !!}
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
        $('#departments').DataTable({
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
            }).then((result) => {
                window.location.href = "{{ route('departments.index') }}";
            });
        }
        if (errorMessage) {
            Swal.fire({
                title: 'Error',
                text: errorMessage,
                icon: 'error',
                confirmButtonText: 'Aceptar'
            }).then((result) => {
                window.location.href = "{{ route('departments.index') }}";
            });
        }
    });
</script>
@endsection
