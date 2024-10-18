<div class="modal fade" id="createStudent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card-success">
                <div class="card-header">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h4 class="card-title">Agregar Estudiante
                            <small>&nbsp;(*) Campos requeridos</small>
                        </h4>
                        <button type="button" class="close d-sm-inline-block text-white" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <form action="{{ route('students.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-header py-2 bg-secondary">
                                <h3 class="card-title">Ingrese los Datos del Estudiante</h3>
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
                                            <img id="photo-preview" src="{{ asset('img/studentDefault.png') }}"
                                                alt="Foto Actual"
                                                style="width: 120px; height: 120px; border-radius: 50%; display: none;">
                                        </div>
                                        <div class="form-group">
                                            <label for="photo">Foto (opcional)</label>
                                            <input type="file" class="form-control" id="photo" name="photo"
                                                accept="image/*" onchange="previewImage(event)">
                                            <small class="form-text text-muted" style="margin-top: 5px;">
                                                📸 Puedes subir cualquier formato de imagen. ¡Elige la que más te guste!
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="enrollment" class="form-label">Matrícula(*)</label>
                                            <input type="text" class="form-control" id="enrollment" name="enrollment"
                                                placeholder="Ingresa la matrícula" required />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="name" class="form-label">Nombre(*)</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="Ingresa el nombre" required />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="last_name" class="form-label">Apellidos(*)</label>
                                            <input type="text" class="form-control" id="last_name" name="last_name"
                                                placeholder="Ingresa los apellidos" required />
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
