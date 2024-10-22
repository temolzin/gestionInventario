<div class="modal fade" id="createUser" tabindex="-1" role="dialog" aria-labelledby="createUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card-success">
                <div class="card-header">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h4 class="card-title">Registrar Usuario</h4>
                        <button type="button" class="close d-sm-inline-block" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-header py-2 bg-secondary">
                                <h3 class="card-title">Datos del Usuario</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <div class="image-preview-container"
                                            style="display: flex; justify-content: center; margin: 20px auto;">
                                            <img id="photo-preview" src="{{ asset('img/userDefault.png') }}"
                                                alt="Foto Actual"
                                                style="width: 120px; height: 120px; border-radius: 50%; display: none;">
                                        </div>
                                        <div class="form-group">
                                            <label for="photo">Foto (opcional)</label>
                                            <small class="form-text text-muted" style="margin-top: 5px;">Los formatos de imagen permitidos son JPEG, PNG, GIF, SVG y WEBP, con un tamaño máximo de 10 MB.</small>
                                            <input type="file" class="form-control" id="photo" name="photo"
                                                accept="*/*" onchange="previewImage(event)">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="name">Nombre(*)</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                required placeholder="Ingrese su nombre">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="last_name">Apellido(*)</label>
                                            <input type="text" class="form-control" id="last_name" name="last_name"
                                                required placeholder="Ingrese su apellido">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="email">Correo Electrónico(*)</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                required placeholder="Ingrese su correo electrónico">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="password">Contraseña(*)</label>
                                            <input type="password" class="form-control" id="password" name="password"
                                                required placeholder="Ingrese su contraseña">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="password_confirmation">Confirmar Contraseña(*)</label>
                                            <input type="password" class="form-control" id="password_confirmation"
                                                name="password_confirmation" required
                                                placeholder="Confirme su contraseña">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="role">Rol(*)</label>
                                            <select class="form-control" id="role" name="role" required>
                                                <option value="" disabled selected>Seleccione un rol</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6" id="department-field" style="display:none;">
                                        <div class="form-group">
                                            <label for="department_id">Departamento(*)</label>
                                            <select class="form-control" id="department_id" name="department_id">
                                                <option value="" disabled selected>Seleccione un departamento
                                                </option>
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}">{{ $department->name }}
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleField = document.getElementById('role');
        const departmentField = document.getElementById('department-field');

        roleField.addEventListener('change', function() {
            if (roleField.value === 'supervisor') {
                departmentField.style.display = 'block';
            } else {
                departmentField.style.display = 'none';
            }
        });
    });

    function previewImage(event) {
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function() {
            var dataURL = reader.result;
            var output = document.getElementById('photo-preview');
            output.src = dataURL;
            output.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
</script>
