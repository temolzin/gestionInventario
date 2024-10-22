<div class="modal fade" id="createDepartment" tabindex="-1" role="dialog" aria-labelledby="createDepartmentLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card-success">
                <div class="card-header">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h4 class="card-title">Agregar Departamento</h4>
                        <button type="button" class="close d-sm-inline-block" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <form action="{{ route('departments.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-header py-2 bg-secondary">
                                <h3 class="card-title">Ingrese los Datos del Departamento</h3>
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
                                            <img id="photo-preview" src="{{ asset('img/departmentDefault.png') }}"
                                                alt="Foto Actual"
                                                style="width: 120px; height: 120px; border-radius: 50%; display: none;">
                                        </div>
                                        <div class="form-group">
                                            <label for="photo">Foto del Departamento (opcional)</label>
                                            <small class="form-text text-muted" style="margin-top: 5px;">Los formatos de imagen permitidos son JPEG, PNG, GIF, SVG y WEBP, con un tamaño máximo de 10 MB.</small>
                                            <input type="file" class="form-control" id="photo" name="photo"
                                                onchange="previewImage(event)">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="name" class="form-label">Nombre(*)</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="Ingresa el nombre del departamento" required />
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="description" class="form-label">Descripción(*)</label>
                                            <textarea class="form-control" id="description" name="description"
                                                placeholder="Ingresa una descripción del departamento" required></textarea>
                                        </div>
                                    </div>
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

<script>
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
