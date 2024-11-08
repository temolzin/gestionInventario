<div class="modal fade" id="view{{ $inventory->id }}" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel{{ $inventory->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card-info">
                <div class="card-header">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h4 class="card-title">Información del Inventario</h4>
                        <button type="button" class="close d-sm-inline-block text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body">
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
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>ID</label>
                                        <input type="text" disabled class="form-control" value="{{ $inventory->id }}" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Estado</label>
                                        <input type="text" disabled class="form-control" value="{{ $inventory->status }}" />
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <h5>Materiales Asociados</h5>
                                    <table id="tableShow" class="table table-bordered table-striped">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Material</th>
                                                <th>Cantidad</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($inventory->materials as $material)
                                                <tr>
                                                    <td>{{ $material->name }}</td>
                                                    <td>{{ $material->pivot->quantity }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Detalles</label>
                                        <textarea disabled class="form-control" rows="4">{{ $inventory->detail }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    #tableShow tbody tr:nth-child(odd) {
        background-color: #ffffff;
    }
    #tableShow tbody tr:nth-child(even) {
        background-color: #f2f2f2;
    }
</style>
