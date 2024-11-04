<div class="modal fade" id="return{{ $loan->id }}" tabindex="-1" role="dialog"
    aria-labelledby="returnModalLabel{{ $loan->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card-warning">
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
                                            <input type="datetime-local" name="expected_return_date"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Estado del Préstamo</label>
                                            <select name="status" class="form-control" required>
                                                <option value="pendiente"
                                                    {{ $loan->status == 'pendiente' ? 'selected' : '' }}>Pendiente
                                                </option>
                                                <option value="devuelto"
                                                    {{ $loan->status == 'devuelto' ? 'selected' : '' }}>Devuelto
                                                </option>
                                                <option value="devuelto parcialmente"
                                                    {{ $loan->status == 'devuelto parcialmente' ? 'selected' : '' }}>
                                                    Devuelto Parcialmente</option>
                                                <option value="rechazado"
                                                    {{ $loan->status == 'rechazado' ? 'selected' : '' }}>Rechazado
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-header bg-warning text-white">
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
                                        @foreach ($loan->materials as $material)
                                            <tr>
                                                <td>{{ $material->id }}</td>
                                                <td>{{ $material->name }}</td>
                                                <td>
                                                    {{ $material->pivot->returned_quantity ?? 0 }}
                                                </td>
                                                <td>
                                                    <input type="number"
                                                        name="materials[{{ $material->id }}][quantity]"
                                                        class="form-control" min="0"
                                                        max="{{ $material->pivot->quantity - ($material->pivot->returned_quantity ?? 0) }}"
                                                        placeholder="Restante: {{ $material->pivot->quantity - ($material->pivot->returned_quantity ?? 0) }}">
                                                    <input type="hidden" name="materials[{{ $material->id }}][id]"
                                                        value="{{ $material->id }}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card mt-3">
                            <div class="card-header bg-warning text-white">
                                <h3 class="card-title">Datos del Prestamo</h3>
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
                                    <label>Notas de Devolución</label>
                                    <textarea name="detail" class="form-control" rows="4" placeholder="Añadir notas sobre la devolución" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-warning">Registrar Devolución</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
