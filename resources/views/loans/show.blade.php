<div class="modal fade" id="view{{ $loan->id }}" tabindex="-1" role="dialog"
    aria-labelledby="viewModalLabel{{ $loan->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card-info">
                <div class="card-header">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h4 class="card-title">Información del Préstamo</h4>
                        <button type="button" class="close d-sm-inline-block text-white" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="card">
                        <div class="card-header py-2 bg-secondary">
                            <h3 class="card-title">Datos del Préstamo</h3>
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
                                        <label>ID del Préstamo</label>
                                        <input type="text" disabled class="form-control"
                                            value="{{ $loan->id }}" />
                                    </div>

                                    <div class="form-group">
                                        <label>Estudiante</label>
                                        <input type="text" disabled class="form-control"
                                            value="{{ $loan->student->name }}" />
                                    </div>

                                    <div class="form-group">
                                        <label>Departamento</label>
                                        <input type="text" disabled class="form-control"
                                            value="{{ $loan->department->name }}" />
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Estado</label>
                                        <input type="text" disabled class="form-control"
                                            value="{{ $loan->status }}" />
                                    </div>

                                    <div class="form-group">
                                        <label>Detalles</label>
                                        <textarea disabled class="form-control" rows="4">{{ $loan->detail }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Fecha de Devolución</label>
                                        <input type="text" disabled class="form-control"
                                            value="{{ \Carbon\Carbon::parse($loan->return_at)->format('d/m/Y') }}" />
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
