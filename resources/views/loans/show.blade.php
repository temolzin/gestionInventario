<div class="modal fade" id="view{{ $loan->id }}" tabindex="-1" role="dialog"
    aria-labelledby="viewModalLabel{{ $loan->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card-info">
                <div class="card-header">
                    <h4 class="card-title">Información del Préstamo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="card mb-3">
                        <div class="card-header bg-secondary text-white">
                            <h3 class="card-title">Datos del Préstamo</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>ID del Préstamo</label>
                                        <input type="text" disabled class="form-control"
                                            value="{{ $loan->id }}" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Estudiante</label>
                                        <input type="text" disabled class="form-control"
                                            value="{{ $loan->student->name }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Departamento</label>
                                        <input type="text" disabled class="form-control"
                                            value="{{ $loan->department->name }}" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Estado</label>
                                        <input type="text" disabled class="form-control"
                                            value="{{ $loan->status }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Detalles</label>
                                        <textarea disabled class="form-control" rows="4">{{ $loan->detail }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Fecha de Devolución</label>
                                        <input type="text" disabled class="form-control"
                                            value="{{ \Carbon\Carbon::parse($loan->return_at)->format('d/m/Y g:i A') }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="card mt-3">
                                <div class="card-header bg-primary text-white">
                                    <h3 class="card-title">Materiales Prestados</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre del Material</th>
                                                <th>Cantidad</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($loan->materials->isEmpty())
                                                <tr>
                                                    <td colspan="3" class="text-center">No hay materiales prestados.
                                                    </td>
                                                </tr>
                                            @else
                                                @foreach ($loan->materials as $material)
                                                    <tr>
                                                        <td>{{ $material->id }}</td>
                                                        <td>{{ $material->name }}</td>
                                                        <td>{{ $material->pivot->quantity }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
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
