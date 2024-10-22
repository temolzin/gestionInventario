<div class="modal fade" id="editLogo{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> 
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar imagen del Departamento</h5>
                <button type="button" class="close d-sm-inline-block text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('departments.updatePhoto', $department->id) }}" enctype="multipart/form-data" method="POST">
                @csrf
                @method('POST')
                <div class="modal-body">
                    <div class=" mb-3">
                        <div class="image-preview-container" style="display: flex; justify-content: center; margin-bottom: 10px;">
                            <img id="photo-preview-edit-{{ $department->id }}"
                                 src="{{ ($department->getFirstMediaUrl('departmentGallery')) ? $department->getFirstMediaUrl('departmentGallery') : asset('img/logo.png') }}" alt="Foto Actual"
                                 style="width: 150px; height: 150px; border-radius: 50%; margin-bottom: 5px;">
                        </div>
                        <label for="profileImage">Seleccionar Imagen</label>
                        <small class="form-text text-muted" style="margin-top: 5px;">Los formatos de imagen permitidos son JPEG, PNG, GIF, SVG y WEBP, con un tamaño máximo de 10 MB.</small>
                        <input type="file" class="form-control" name="photo" id="photo-{{ $department->id }}" onchange="previewImageEdit(event, {{ $department->id }})">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImageEdit(event, DepartmentId) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('photo-preview-edit-' + DepartmentId);
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
