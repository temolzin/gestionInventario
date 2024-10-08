<div class="modal fade" id="createLoan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card-success">
                <div class="card-header">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h4 class="card-title">Agregar Préstamo <small>&nbsp;(*) Campos requeridos</small></h4>
                        <button type="button" class="close d-sm-inline-block text-white" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>

                <form action="{{ route('loans.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="card">
                            <div class="card-header py-2 bg-secondary">
                                <h3 class="card-title">Ingrese los Datos del Préstamo</h3>
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
                                            <label for="student_id" class="form-label">Estudiante(*)</label>
                                            <select class="form-control" id="student_id" name="student_id" required>
                                                <option value="">Seleccione un estudiante</option>
                                                @foreach ($students as $student)
                                                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="department_id" class="form-label">Departamento(*)</label>
                                            <select class="form-control" id="department_id" name="department_id"
                                                required>
                                                <option value="">Seleccione un departamento</option>
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}">{{ $department->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="status" class="form-label">Estado(*)</label>
                                            <input type="text" class="form-control" id="status" name="status"
                                                placeholder="Ingrese el estado del préstamo" value="{{ old('status') }}"
                                                required />
                                        </div>

                                        <div class="form-group">
                                            <label for="detail" class="form-label">Detalles(*)</label>
                                            <textarea class="form-control" id="detail" name="detail" placeholder="Ingrese detalles del préstamo" required>{{ old('detail') }}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="return_at" class="form-label">Fecha de Devolución(*)</label>
                                            <input type="date" class="form-control" id="return_at" name="return_at"
                                                value="{{ old('return_at') }}" required />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" id="save" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
