<div class="modal fade" id="view{{ $department->id }}" tabindex="-1" role="dialog"
    aria-labelledby="viewModalLabel{{ $department->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card-info">
                <div class="card-header">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h4 class="card-title">Información del Departamento</h4>
                        <button type="button" class="close d-sm-inline-block text-white" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-header py-2 bg-secondary">
                            <h3 class="card-title">Datos del Departamento</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    @if ($department->getFirstMediaUrl('departmentGallery'))
                                        <img src="{{ $department->getFirstMediaUrl('departmentGallery') }}" alt="Foto de {{ $department->name }}" style="width: 120px; height: 120px; border-radius: 50%; margin-bottom: 5px;">
                                    @else
                                        <img src="{{ asset('img/logo.png') }}" style="width: 120px; height: 120px; border-radius: 50%; margin-bottom: 5px;">
                                    @endif
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>ID</label>
                                        <input type="text" disabled class="form-control"
                                            value="{{ $department->id }}" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Nombre</label>
                                        <input type="text" disabled class="form-control"
                                            value="{{ $department->name }}" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Supervisor</label>
                                        <input type="text" disabled class="form-control"
                                            value="{{ optional($department->supervisor)->name ?: 'No asignado' }}" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Creado por</label>
                                        <input type="text" disabled class="form-control"
                                            value="{{ optional($department->creator)->name ?: 'No asignado' }}" />
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Descripción</label>
                                        <textarea type="text" disabled class="form-control">{{ $department->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
