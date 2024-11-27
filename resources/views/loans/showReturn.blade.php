<div class="modal fade" id="showReturn{{ $loan->id }}" tabindex="-1" role="dialog"
    aria-labelledby="showReturnModalLabel{{ $loan->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card-header" style="background: #00B0FF; color: white;">
                <h4 class="card-title">Detalles de la Devolución</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="tabContent{{ $loan->id }}" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="loan-details-tab-{{ $loan->id }}" data-toggle="tab"
                            href="#loan-details-{{ $loan->id }}" role="tab"
                            aria-controls="loan-details-{{ $loan->id }}" aria-selected="true">
                            <i class="fas fa-file-alt"></i> Detalles del Préstamo
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="returns-tab-{{ $loan->id }}" data-toggle="tab"
                            href="#returns-{{ $loan->id }}" role="tab"
                            aria-controls="returns-{{ $loan->id }}" aria-selected="false">
                            <i class="fas fa-undo"></i> Devoluciones Registradas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="materials-tab-{{ $loan->id }}" data-toggle="tab"
                            href="#materials-{{ $loan->id }}" role="tab"
                            aria-controls="materials-{{ $loan->id }}" aria-selected="false">
                            <i class="fas fa-box-open"></i> Materiales Devueltos
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="tabContentBody{{ $loan->id }}">
                    <div class="tab-pane fade show active" id="loan-details-{{ $loan->id }}" role="tabpanel"
                        aria-labelledby="loan-details-tab-{{ $loan->id }}">
                        <div class="mt-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="font-weight-bold">ID del Préstamo</label>
                                    <input type="text" disabled class="form-control" value="{{ $loan->id }}" />
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold">Estudiante</label>
                                    <input type="text" disabled class="form-control"
                                        value="{{ $loan->student->name }} {{ $loan->student->last_name }}" />
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label class="font-weight-bold">Fecha de Devolución Esperada</label>
                                    <input type="text" disabled class="form-control"
                                        value="{{ \Carbon\Carbon::parse($loan->return_at)->format('d/m/Y g:i A') }}" />
                                </div>
                                <div class="col-md-6">
                                    <label class="font-weight-bold">Estado de Devolución</label>
                                    <input type="text" disabled class="form-control"
                                        value="{{ ucfirst($loan->status) }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="returns-{{ $loan->id }}" role="tabpanel"
                        aria-labelledby="returns-tab-{{ $loan->id }}">
                        <div class="mt-3">
                            @if ($loan->materialReturns->isEmpty())
                                <p class="text-muted">No se han registrado devoluciones para este préstamo.</p>
                            @else
                                <ul class="list-group">
                                    @foreach ($loan->materialReturns as $return)
                                        <li class="list-group-item">
                                            <div class="card" style="border: 2px solid #00B0FF;">
                                                <div class="card-header"
                                                    style="background-color: #0069d9; color: white;">
                                                    <h5 class="card-title">Devolución #{{ $return->id }}</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label class="font-weight-bold">Fecha de Devolución</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ \Carbon\Carbon::parse($return->return_at)->format('d/m/Y g:i A') }}"
                                                                disabled />
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="font-weight-bold">Estado de Devolución</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ ucfirst($return->status) }}" disabled />
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label class="font-weight-bold">Detalle de
                                                                Devolución</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ $return->detail ?: 'No hay detalles' }}"
                                                                disabled />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane fade" id="materials-{{ $loan->id }}" role="tabpanel"
                        aria-labelledby="materials-tab-{{ $loan->id }}">
                        <div class="mt-3">
                            @if ($loan->materialReturns->isEmpty())
                                <p class="text-muted">No hay materiales devueltos.</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover" style="border: 2px solid #00B0FF;">
                                        <thead style="background-color: #0069d9; color: white;">
                                            <tr>
                                                <th>ID del Material</th>
                                                <th>Nombre del Material</th>
                                                <th>Cantidad Devuelta</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($loan->materialReturns as $return)
                                                <tr>
                                                    <td>{{ $return->material->id ?? 'N/A' }}</td>
                                                    <td>{{ $return->material->name ?? 'No asignado' }}</td>
                                                    <td>{{ $return->quantity_returned }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
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
