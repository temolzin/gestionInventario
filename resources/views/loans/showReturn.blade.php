<div class="modal fade" id="showReturn{{ $loan->id }}" tabindex="-1" role="dialog"
    aria-labelledby="showReturnModalLabel{{ $loan->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card-info">
                <div class="card-header">
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
                    </ul>
                    <div class="tab-content" id="tabContentBody{{ $loan->id }}">
                        <div class="tab-pane fade show active" id="loan-details-{{ $loan->id }}" role="tabpanel"
                            aria-labelledby="loan-details-tab-{{ $loan->id }}">
                            <div class="mt-3">
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
                                                    <label>Solicitante</label>
                                                    <input type="text" disabled class="form-control"
                                                        value="{{ $loan->student->name }} {{ $loan->student->last_name }}" />
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
                                                    <label>Fecha de Devolución</label>
                                                    <input type="text" disabled class="form-control"
                                                        value="{{ \Carbon\Carbon::parse($loan->return_at)->format('d/m/Y g:i A') }}" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card mt-3">
                                            <div class="card-header bg-info text-white">
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
                                                                <td colspan="3" class="text-center">No hay materiales
                                                                    prestados.</td>
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
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Detalles</label>
                                                    <textarea disabled class="form-control" rows="4">{{ $loan->detail }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="returns-{{ $loan->id }}" role="tabpanel"
                            aria-labelledby="returns-tab-{{ $loan->id }}">
                            <div class="mt-3">
                                @if ($loan->materialReturns->isNotEmpty())
                                    <ul class="list-group">
                                        @foreach ($loan->materialReturns as $return)
                                            <li class="list-group-item">
                                                <div class="card" style="border: 2px solid #00B0FF;">
                                                    <div class="card-header bg-info">
                                                        <h5 class="card-title">Devolución #{{ $return->id }}</h5>
                                                        <div class="card-tools">
                                                            <button type="button" class="btn btn-tool"
                                                                data-card-widget="collapse">
                                                                <i class="fa fa-minus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <label class="font-weight-bold">Fecha de
                                                                    Devolución</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ \Carbon\Carbon::parse($return->return_at)->format('d/m/Y g:i A') }}"
                                                                    disabled />
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="font-weight-bold">Estado de
                                                                    Devolución</label>
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
                                                        @if ($return->materialReturnMaterials->isNotEmpty())
                                                            <div class="mt-3">
                                                                <h5>Materiales Devueltos:</h5>
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>ID del Material</th>
                                                                            <th>Nombre del Material</th>
                                                                            <th>Cantidad Devuelta</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($return->materialReturnMaterials as $materialReturnMaterial)
                                                                            <tr>
                                                                                <td>{{ $materialReturnMaterial->material->id ?? 'N/A' }}
                                                                                </td>
                                                                                <td>{{ $materialReturnMaterial->material->name ?? 'Sin nombre' }}
                                                                                </td>
                                                                                <td>{{ $materialReturnMaterial->quantity_returned ?? '0' }}
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        @else
                                                            <p class="text-muted mt-2">No hay materiales devueltos para
                                                                esta devolución.</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>No se han registrado devoluciones para este préstamo.</p>
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
</div>
