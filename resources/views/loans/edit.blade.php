<div class="modal fade" id="edit{{ $loan->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editModalLabel{{ $loan->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card-warning">
                <div class="card-header">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h4 class="card-title">Modificar Préstamo</h4>
                        <button type="button" class="close d-sm-inline-block text-white" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <form action="{{ route('loans.update', $loan->id) }}" method="post">
                    @csrf
                    @method('PUT')
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
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="student_id" class="form-label">Estudiante(*)</label>
                                            <select class="form-control" id="student_id" name="student_id" required>
                                                <option value="">Seleccione un estudiante</option>
                                                @foreach ($students as $student)
                                                    <option value="{{ $student->id }}"
                                                        {{ $loan->student_id == $student->id ? 'selected' : '' }}>
                                                        {{ $student->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="department_id" class="form-label">Departamento(*)</label>
                                            <select class="form-control" id="department_id" name="department_id"
                                                required>
                                                <option value="">Seleccione un departamento</option>
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}"
                                                        {{ $loan->department_id == $department->id ? 'selected' : '' }}>
                                                        {{ $department->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="status" class="form-label">Estado(*)</label>
                                            <input type="text" class="form-control" id="status" name="status"
                                                value="{{ old('status', $loan->status) }}" required />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="return_at" class="form-label">Fecha de Devolución(*)</label>
                                            <input type="date" class="form-control" id="return_at" name="return_at"
                                                value="{{ old('return_at', \Carbon\Carbon::parse($loan->return_at)->format('Y-m-d')) }}"
                                                required />
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="detail" class="form-label">Detalle(*)</label>
                                            <textarea class="form-control" id="detail" name="detail" required>{{ old('detail', $loan->detail) }}</textarea>
                                        </div>
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
