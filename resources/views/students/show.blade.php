<div class="modal fade" id="view{{ $student->id }}" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel{{ $student->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card-info">
                <div class="card-header">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h4 class="card-title">Información del Estudiante</h4>
                        <button type="button" class="close d-sm-inline-block text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-header py-2 bg-secondary">
                            <h3 class="card-title">Datos del Estudiante</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    @if ($student->getFirstMediaUrl('studentGallery'))
                                        <img src="{{ $student->getFirstMediaUrl('studentGallery') }}" alt="Foto del estudiante" class="img-fluid" 
                                         style="width: 120px; height: 120px; border-radius: 50%; margin-bottom: 5px;">
                                    @else
                                        <img src="{{ asset('img/userDefault.png') }}" alt="Foto del estudiante" class="img-fluid" 
                                        style="width: 120px; height: 120px; border-radius: 50%; margin-bottom: 5px;">
                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>ID</label>
                                        <input type="text" disabled class="form-control " value="{{ $student->id }}" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Matrícula</label>
                                        <input type="text" disabled class="form-control" value="{{ $student->enrollment }}" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Apellido</label>
                                        <input type="text" disabled class="form-control" value="{{ $student->last_name }}" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Nombre</label>
                                        <input type="text" disabled class="form-control" value="{{ $student->name }}" />
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
