@foreach ($users as $user)
    <div class="modal fade" id="edit{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="card-warning">
                    <div class="card-header">
                        <div class="d-sm-flex align-items-center justify-content-between">
                            <h4 class="card-title">Editar Usuario
                                <small>&nbsp;(*) Campos requeridos</small>
                            </h4>
                            <button type="button" class="close d-sm-inline-block text-white" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('users.update', $user->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="card">
                                <div class="card-header py-2 bg-secondary">
                                    <h3 class="card-title">Datos del Usuario</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="name">Nombre(*)</label>
                                                <input type="text" class="form-control" name="name"
                                                    value="{{ $user->name }}" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="last_name">Apellido(*)</label>
                                                <input type="text" class="form-control" name="last_name"
                                                    value="{{ $user->last_name }}" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="email">Correo Electrónico(*)</label>
                                                <input type="email" class="form-control" name="email"
                                                    value="{{ $user->email }}" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="role">Rol(*)</label>
                                                <select name="role" id="roleSelect{{ $user->id }}" class="form-control" required>
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->name }}"
                                                            {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                                            {{ $role->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12" id="departmentField{{ $user->id }}" style="display: none;">
                                            <div class="form-group">
                                                <label for="department_id">Departamento(*)</label>
                                                <select name="department_id" class="form-control" required>
                                                    <option value="" disabled selected>Seleccione un departamento</option>
                                                    @foreach ($departments as $department)
                                                        <option value="{{ $department->id }}"
                                                            {{ $user->department_id == $department->id ? 'selected' : '' }}>
                                                            {{ $department->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-warning">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var roleSelect = document.getElementById('roleSelect{{ $user->id }}');
            var departmentField = document.getElementById('departmentField{{ $user->id }}');

            function toggleDepartmentField() {
                if (roleSelect.value === 'supervisor') {
                    departmentField.style.display = 'block';
                } else {
                    departmentField.style.display = 'none';
                }
            }
            toggleDepartmentField();
            roleSelect.addEventListener('change', toggleDepartmentField);
        });
    </script>
@endforeach
