<div class="modal fade" id="edit{{ $material->id }}" tabindex="-1" role="dialog" aria-labelledby="editMaterialLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card-warning">
                <div class="card-header">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h4 class="card-title">Editar Material 
                            <small>&nbsp;(*) Campos requeridos</small>
                        </h4>
                        <button type="button" class="close d-sm-inline-block text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <form action="{{ route('materials.update', $material->id) }}" method="post" id="edit-material-form-{{ $material->id }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="card">
                            <div class="card-header py-2 bg-secondary">
                                <h3 class="card-title">Datos del Material</h3>
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
                                            <label for="name" class="form-label">Nombre del Material(*)</label>
                                            <input type="text" class="form-control" name="name" id="name" value="{{ $material->name }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="category_id" class="form-label">Categoría(*)</label>
                                            <select class="form-control" name="category_id" id="category_id" required>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ $material->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="status" class="form-label">Estado(*)</label>
                                            <select class="form-control" id="status" name="status" required>
                                                <option value="disponible" {{ $material->status == 'disponible' ? 'selected' : '' }}>Disponible</option>
                                                <option value="no disponible" {{ $material->status == 'no disponible' ? 'selected' : '' }}>No disponible</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="amount" class="form-label">Cantidad(*)</label>
                                            <input type="number" class="form-control" name="amount" id="amount" value="{{ $material->amount }}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="description" class="form-label">Descripción(*)</label>
                                            <textarea type="text" class="form-control" name="description" id="description" required>{{ $material->description }}</textarea>
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
