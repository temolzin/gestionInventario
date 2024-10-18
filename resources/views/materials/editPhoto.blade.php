<div class="modal fade" id="editPhoto{{ $material->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card-warning">
                <div class="card-header">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h4 class="card-title">Editar Foto del Material
                            <small>&nbsp;(*) Campos requeridos</small>
                        </h4>
                        <button type="button" class="close d-sm-inline-block text-white" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <form action="{{ route('materials.updatePhoto', $material->id) }}" enctype="multipart/form-data"
                    method="POST" id="edit-material-form-{{ $material->id }}">
                    @csrf
                    <div class="card-body">
                        <div class="card">
                            <div class="card-header py-2 bg-secondary">
                                <h3 class="card-title">Foto del Material</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-8 offset-lg-2">
                                        <div class="form-group text-center">
                                            <label for="photo-{{ $material->id }}" class="form-label"></label>
                                            <div class="image-preview-container"
                                                style="display: flex; justify-content: center; margin-bottom: 10px;">
                                                <img id="photo-preview-edit-{{ $material->id }}"
                                                    src="{{ $material->getFirstMediaUrl('materialGallery') ? $material->getFirstMediaUrl('materialGallery') : asset('img/logo.png') }}"
                                                    alt="Foto Actual"
                                                    style="width: 120px; height: 120px; border-radius: 50%; margin-bottom: 5px;">
                                            </div>
                                            <input type="file" class="form-control" name="photo"
                                                id="photo-{{ $material->id }}"
                                                onchange="previewImageEdit(event, {{ $material->id }})">
                                            <small class="form-text text-muted" style="margin-top: 5px;">📷 Puede
                                                actualizar su imagen en cualquier formato. Seleccione la fotografía que
                                                desea modificar.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImageEdit(event, id) {
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function() {
            var dataURL = reader.result;
            var output = document.getElementById('photo-preview-edit-' + id);
            output.src = dataURL;
            output.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
</script>
