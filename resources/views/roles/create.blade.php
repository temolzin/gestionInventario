<div class="modal fade" id="createRoleModal" tabindex="-1" role="dialog" aria-labelledby="createRoleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card card-success">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Crear nuevo rol <small>&nbsp;(*) Campos requeridos</small></h4>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="card">
                            <div class="card-header bg-secondary py-2">
                                <h3 class="card-title">Datos del rol</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Nombre del rol <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Ingrese el nombre del rol" value="{{ old('name') }}" required>
                                </div>
                                <h3>Permisos <span class="text-danger">*</span></h3>
                                <p>Selecciona los permisos que deseas asignar a este rol:</p>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th style="width: 100px;">Seleccionar</th>
                                                <th>Descripción del Permiso</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($permissions as $permission)
                                                <tr>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" name="permissions[]"
                                                                value="{{ $permission->id }}"
                                                                class="custom-control-input"
                                                                id="permission{{ $permission->id }}">
                                                            <label class="custom-control-label"
                                                                for="permission{{ $permission->id }}"></label>
                                                        </div>
                                                    </td>
                                                    <td>{{ $permission->description }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
