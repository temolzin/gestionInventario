@extends('adminlte::page')

@section('title', ' | Materiales')

@section('content')
    <section class="content">
        <div class="right_col" role="main">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Materiales</h2>
                        <div class="row">
                            <div class="col-lg-12 text-right">
                                <div class="btn-group" role="group" aria-label="Acciones de Material">
                                    <button class="btn btn-success mr-2" data-toggle='modal' data-target="#createMaterial">
                                        <i class="fa fa-plus"></i> Registrar material
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-lg-6">
                        <form method="GET" action="{{ route('materials.index') }}" class="my-3">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Buscar por nombre, estado" value="{{ request('search') }}">
                                <select name="category_id" class="form-control ml-2">
                                    <option value="">Busqueda por Categoría</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
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
                                    <table id="materials" class="table table-striped display responsive nowrap"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Foto</th>
                                                <th>Nombre</th>
                                                <th>Categoría</th>
                                                <th>Estado</th>
                                                <th>Cantidad</th>
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($materials) <= 0)
                                                <tr>
                                                    <td colspan="7">No hay resultados</td>
                                                </tr>
                                            @else
                                                @foreach ($materials as $material)
                                                    <tr>
                                                        <td scope="row">{{ $material->id }}</td>
                                                        <td>
                                                            @if ($material->getFirstMediaUrl('materialGallery'))
                                                                <img src="{{ $material->getFirstMediaUrl('materialGallery') }}"
                                                                    alt="Foto de {{ $material->name }}"
                                                                    style="width: 50px; height: 50px; border-radius: 50%;">
                                                            @else
                                                                <img src="{{ asset('img/logo.png') }}"
                                                                    style="width: 50px; height: 50px; border-radius: 50%;">
                                                            @endif
                                                        </td>
                                                        <td>{{ $material->name }}</td>
                                                        <td>{{ $material->category->name }}</td>
                                                        <td>{{ $material->status }}</td>
                                                        <td>{{ $material->amount }}</td>
                                                        <td>
                                                            <div class="btn-group" role="group" aria-label="Opciones">
                                                                <button type="button" class="btn btn-info mr-2"
                                                                    data-toggle="modal" title="Ver Detalles"
                                                                    data-target="#view{{ $material->id }}">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-warning mr-2"
                                                                    data-toggle="modal" title="Editar Datos"
                                                                    data-target="#edit{{ $material->id }}">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-primary mr-2"
                                                                    data-toggle="modal" title="Actualizar Imagen"
                                                                    data-target="#editPhoto{{ $material->id }}">
                                                                    <i class="fas fa-image"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-danger mr-2"
                                                                    data-toggle="modal" title="Eliminar Registro"
                                                                    data-target="#delete{{ $material->id }}">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                        @include('materials.edit')
                                                        @include('materials.delete')
                                                        @include('materials.show')
                                                        @include('materials.editPhoto')
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                    @include('materials.create')
                                    <div class="d-flex justify-content-center">
                                        {!! $materials->links('pagination::bootstrap-4') !!}
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
            $('#materials').DataTable({
                responsive: true,
                paging: false,
                info: false,
                searching: false,
                order: [[1, 'desc']]
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
