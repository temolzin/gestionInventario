@extends('adminlte::page')

@section('title', 'Inventarios')

@section('content')
<section class="content">
    <div class="right_col" role="main">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Inventarios</h2>
                    <div class="row">
                        <div class="col-lg-12 text-right">
                            <div class="btn-group" role="group" aria-label="Acciones de Inventario">
                                <button class="btn btn-success mr-2" data-toggle='modal' data-target="#createInventory">
                                    <i class="fa fa-plus"></i> Registrar inventario
                                </button>
                            </div>
                        </div>
                    </div>                    
                    <div class="clearfix"></div>
                </div>
                <div class="col-lg-6">
                    <form method="GET" action="{{ route('inventories.index') }}" class="my-3">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Buscar por material, estado" value="{{ request('search') }}">
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
                                <table id="inventories" class="table table-striped display responsive nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Material</th>
                                            <th>Cantidad</th>
                                            <th>Estado</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($inventories) <= 0)
                                        <tr>
                                            <td colspan="6">No hay resultados</td>
                                        </tr>
                                        @else
                                        @foreach($inventories as $inventory)
                                        <tr>
                                            <td scope="row">{{ $inventory->id }}</td>
                                            <td>{{ $inventory->material->name }}</td>
                                            <td>{{ $inventory->quantity }}</td>
                                            <td>{{ $inventory->status }}</td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Opciones">
                                                    <button type="button" class="btn btn-info mr-2" data-toggle="modal" title="Ver Detalles" data-target="#view{{ $inventory->id }}">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-warning mr-2" data-toggle="modal" title="Editar Datos" data-target="#edit{{ $inventory->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger mr-2" data-toggle="modal" title="Eliminar Registro" data-target="#delete{{ $inventory->id }}">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            @include('inventories.edit')
                                            @include('inventories.delete')
                                            @include('inventories.show')
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                @include('inventories.create')
                                <div class="d-flex justify-content-center">
                                    {!! $inventories->links('pagination::bootstrap-4') !!}
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
        $('#inventories').DataTable({
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
                window.location.href = "{{ route('inventories.index') }}";
            });
        }
        if (errorMessage) {
            Swal.fire({
                title: 'Error',
                text: errorMessage,
                icon: 'error',
                confirmButtonText: 'Aceptar'
            }).then((result) => {
                window.location.href = "{{ route('inventories.index') }}";
            });
        }
    });
</script>
@endsection
