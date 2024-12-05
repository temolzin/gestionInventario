<div class="modal fade" id="loansModal{{ $student->id }}" tabindex="-1" role="dialog"
    aria-labelledby="loansModalLabel{{ $student->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card-info">
                <div class="card-header" style="background-color: #6f42c1; color: white;">
                    <h4 class="card-title">Préstamos de {{ $student->name }} {{ $student->last_name }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card mb-3">
                        <div class="card-header bg-secondary text-white">
                            <h3 class="card-title">Lista de Préstamos</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            @if ($student->loans->isEmpty())
                                <p>No hay préstamos registrados para este solicitante.</p>
                            @else
                                @foreach ($student->loans as $loan)
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <h6>Préstamo ID: {{ $loan->id }}</h6>
                                            <p>Estado: {{ $loan->status }}</p>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Fecha de Creacion Préstamo</label>
                                                        <input type="text" disabled class="form-control"
                                                            value="{{ \Carbon\Carbon::parse($loan->created_at)->format('d/m/Y g:i A') }}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Fecha de Devolución</label>
                                                        <input type="text" disabled class="form-control"
                                                            value="{{ \Carbon\Carbon::parse($loan->return_at)->format('d/m/Y g:i A') }}" />
                                                    </div>
                                                </div>
                                                @if ($loan->status === 'devuelto')
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Fecha en que se Entregó</label>
                                                            <input type="text" disabled class="form-control"
                                                                value="{{ \Carbon\Carbon::parse($loan->materialReturn->expected_return_date)->format('d/m/Y g:i A') }}" />
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            <h6>Materiales Prestados:</h6>
                                            <ul>
                                                @foreach ($loan->materials as $material)
                                                    <li>{{ $material->name }} - Cantidad:
                                                        {{ $material->pivot->quantity }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <a href="{{ route('loans.index') }}" class="btn btn-purple mr-2">Ir al Módulo de Préstamos</a>
                </div>
            </div>
        </div>
    </div>
</div>
