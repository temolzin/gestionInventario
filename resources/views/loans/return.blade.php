<div class="modal fade" id="return{{ $loan->id }}" tabindex="-1" role="dialog"
    aria-labelledby="returnModalLabel{{ $loan->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card-purple">
                <div class="card-header">
                    <h4 class="card-title">Devolución de Materiales</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('loans.return', $loan->id) }}" method="POST">
                        @csrf
                        <div class="card mb-3">
                            <div class="card-header bg-secondary text-white">
                                <h3 class="card-title">Detalles del Préstamo</h3>
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
                                            <input type="hidden" name="loan_id" value="{{ $loan->id }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Estudiante</label>
                                            <input type="text" disabled class="form-control"
                                                value="{{ $loan->student->name }} {{ $loan->student->last_name }}" />
                                            <input type="hidden" name="student_id" value="{{ $loan->student_id }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Fecha de Devolución Esperada</label>
                                            <input type="text" disabled class="form-control"
                                                value="{{ \Carbon\Carbon::parse($loan->return_at)->format('d/m/Y g:i A') }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Fecha de la Devolución</label>
                                            <input type="datetime-local" name="return_at" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Estado de Devolución</label>
                                            <select name="status" class="form-control">
                                                <option value="pendiente">Pendiente</option>
                                                <option value="devuelto">Devuelto</option>
                                                <option value="devuelto parcialmente">Devuelto Parcialmente</option>
                                                <option value="rechazado">Rechazado</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-header bg-purple text-white">
                                <h3 class="card-title">Materiales a Devolver</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre del Material</th>
                                            <th>Cantidad Devuelta</th>
                                            <th>Cantidad a Devolver</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $hayMateriales = false;
                                        @endphp                                    
                                        @foreach ($loan->materials as $material)
                                            @php
                                                $cantidadRestante = $material->pivot->quantity - ($material->pivot->returned_quantity ?? 0);
                                            @endphp
                                            @if ($cantidadRestante > 0)
                                                @php
                                                    $hayMateriales = true;
                                                @endphp
                                                <tr>
                                                    <td>{{ $material->id }}</td>
                                                    <td>{{ $material->name }}</td>
                                                    <td>{{ $material->pivot->returned_quantity ?? 0 }}</td>
                                                    <td>
                                                        <input type="number"
                                                            name="materials[{{ $material->id }}][quantity]"
                                                            class="form-control" min="0"
                                                            max="{{ $cantidadRestante }}"
                                                            placeholder="Restante: {{ $cantidadRestante }}">
                                                        <input type="hidden" name="materials[{{ $material->id }}][id]" value="{{ $material->id }}">
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        @if (!$hayMateriales)
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">No hay materiales pendientes de devolución.</td>
                                            </tr>
                                        @endif
                                    </tbody>                                    
                                </table>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-header bg-purple text-white">
                                <h3 class="card-title">Datos del Préstamo</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre del Material</th>
                                            <th>Cantidad Prestada</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($loan->materials as $material)
                                            <tr>
                                                <td>{{ $material->id }}</td>
                                                <td>{{ $material->name }}</td>
                                                <td>{{ $material->pivot->quantity }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Detalles de Devolución</label>
                                    <textarea name="detail" class="form-control" rows="4" placeholder="Añadir notas sobre la devolución"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-purple">Registrar Devolución</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-purple {
        background-color: #6f42c1;
        color: #ffffff;
        border-color: #6f42c1;
    }

    .btn-purple:hover {
        background-color: #5a3393;
        border-color: #5a3393;
    }

    .bg-purple {
        background-color: #6f42c1;
        color: white;
    }

    .card-purple .card-header {
        background-color: #6f42c1;
        color: #ffffff;
    }
</style>
