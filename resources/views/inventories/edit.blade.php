<div class="modal fade" id="edit{{ $inventory->id }}" role="dialog" aria-labelledby="editInventoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card-warning">
                <div class="card-header">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h4 class="card-title">Editar Inventario
                            <small>&nbsp;(*) Campos requeridos</small>
                        </h4>
                        <button type="button" class="close d-sm-inline-block text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <form action="{{ route('inventories.update', $inventory->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="card">
                            <div class="card-header py-2 bg-secondary">
                                <h3 class="card-title">Datos del Inventario</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="status" class="form-label">Estado(*)</label>
                                            <select class="form-control select2" id="status" name="status" required>
                                                <option value="disponible" {{ $inventory->status == 'disponible' ? 'selected' : '' }}>Disponible</option>
                                                <option value="no disponible" {{ $inventory->status == 'no disponible' ? 'selected' : '' }}>No disponible</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <table class="table table-bordered" id="materialTable_{{ $inventory->id }}">
                                            <thead>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Descripción</th>
                                                    <th>Cantidad</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($inventory->materials as $material)
                                                    <tr>
                                                        <td>{{ $material->name }}<input type="hidden" name="materials[]" value="{{ $material->id }}"></td>
                                                        <td>{{ $material->description }}</td>
                                                        <td><input type="number" class="form-control" name="quantities[]" min="1" value="{{ $material->pivot->quantity }}" readonly></td>
                                                        <td> <button type="button" class="btn btn-secondary btn-sm delete-row" disabled><i class="fas fa-trash-alt"></i></button></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="detail">Detalles(*)</label>
                                        <textarea class="form-control" id="detail" name="detail" placeholder="Ingrese detalles del préstamo" required>{{ $inventory->detail }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" id="save" class="btn btn-warning">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    #materialTable_{{ $inventory->id }} tbody tr:nth-child(odd) {
        background-color: #ffffff;
    }
    #materialTable_{{ $inventory->id }} tbody tr:nth-child(even) {
        background-color: #f2f2f2;
    }
</style>
