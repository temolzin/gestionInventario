@extends('adminlte::page')

@section('title', 'Edit')

@section('content_header')
    <h1>Editar Rol</h1>
@stop

@section('content')
    <div class="card card-warning" style="max-width: 800px; margin: auto;">
        <div class="card-header bg-warning text-white">
            <div class="d-flex align-items-center justify-content-between">
                <h4 class="card-title">Editar Rol</h4>
                <button type="button" class="close text-white" aria-label="Close" id="close-button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="card-header bg-secondary text-white mb-3">
                <h3 class="card-title d-inline">Datos del Rol</h3>
                <button type="button" id="toggle-permissions" class="btn btn-link text-white float-right"
                    aria-label="Toggle Permissions">
                    <span id="toggle-icon">-</span>
                </button>
            </div>
            <form action="{{ route('roles.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Nombre del Rol <span class="text-danger"
                            style="font-size: 1.5rem;">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $role->name) }}"
                        placeholder="Ingrese el nombre del rol" required>
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div id="permissions-section">
                    <h2 class="h5">Permisos <span class="text-danger" style="font-size: 1.5rem;">*</span></h2>
                    <p>Selecciona los permisos que deseas asignar a este rol.</p>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="header-row">
                                    <th style="width: 100px;">Seleccionar</th>
                                    <th>Descripción del Permiso</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $permission)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                                    {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}
                                                    class="form-check-input" id="permission{{ $permission->id }}">
                                                <label class="form-check-label"
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

                <div class="button-group">
                    <button type="button" class="btn btn-secondary" id="close-form-button">Cerrar</button>
                    <button type="submit" class="btn btn-warning">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/roles/editRol.css') }}">
@stop

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('close-button').addEventListener('click', function() {
                window.location.href = "{{ route('roles.index') }}";
            });
            document.getElementById('close-form-button').addEventListener('click', function() {
                window.location.href = "{{ route('roles.index') }}";
            });

            document.getElementById('toggle-permissions').addEventListener('click', function() {
                var permissionsSection = document.getElementById('permissions-section');
                permissionsSection.style.display = (permissionsSection.style.display === 'none') ? 'block' :
                    'none';
                document.getElementById('toggle-icon').innerText = (permissionsSection.style.display ===
                    'none') ? '+' : '-';
            });
        });

        var errorMessage = "{{ session('error') }}";
        if (errorMessage) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: errorMessage,
                confirmButtonText: 'Aceptar'
            });
        }
    </script>
@stop
