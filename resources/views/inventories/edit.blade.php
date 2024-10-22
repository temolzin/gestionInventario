<div class="modal fade" id="edit{{ $inventory->id }}" role="dialog" aria-labelledby="editInventoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card-warning">
                <div class="card-header">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h4 class="card-title">Editar Inventario
                            <small>&nbsp;(*) Campos requeridos</small>
                        </h4>
                        <button type="button" class="close d-sm-inline-block text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <form action="{{ route('inventories.update', $inventory->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="card">
                            <div class="card-header py-2 bg-secondary">
                                <h3 class="card-title">Datos del Inventario</h3>
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
                                            <label for="material_id" class="form-label">Material(*)</label>
                                            <select class="form-control select2" id="material_id_{{ $inventory->id }}">
                                                <option value="">Seleccione un material</option>
                                                @foreach($materials as $material)
                                                    <option value="{{ $material->id }}" data-description="{{ $material->description }}">{{ $material->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="status" class="form-label">Estado(*)</label>
                                            <select class="form-control select2" id="status" name="status" required>
                                                <option value="disponible" {{ $inventory->status == 'disponible' ? 'selected' : '' }}>Disponible</option>
                                                <option value="no disponible" {{ $inventory->status == 'no disponible' ? 'selected' : '' }}>No disponible</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <button type="button" id="addMaterialBtn_{{ $inventory->id }}" class="btn btn-primary">Agregar Material</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <table class="table table-bordered" id="materialTable_{{ $inventory->id }}">
                                            <thead>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Descripción</th>
                                                    <th>Cantidad</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($inventory->materials as $material)
                                                    <tr>
                                                        <td>{{ $material->name }}<input type="hidden" name="materials[]" value="{{ $material->id }}"></td>
                                                        <td>{{ $material->description }}</td>
                                                        <td><input type="number" class="form-control" name="quantities[]" min="1" value="{{ $material->pivot->quantity }}"></td>
                                                        <td><button type="button" class="btn btn-danger btn-sm delete-row">Eliminar</button></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" id="save" class="btn btn-warning">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@section('js')
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            $('#createInventory').on('shown.bs.modal', function () {
                $('.select2').select2({
                    tags: true
                });
            });
            $('#edit{{ $inventory->id }}').on('shown.bs.modal', function () {
                $('.select2').select2({
                    tags: true
                });
            });

            document.querySelector('#materialTable_{{ $inventory->id }}').addEventListener('click', function(e) {
                    if (e.target.classList.contains('delete-row')) {
                        e.target.closest('tr').remove();
                    }
            });

            document.getElementById('addMaterialBtn_{{ $inventory->id }}').addEventListener('click', function() {
                const materialId = document.getElementById('material_id_{{ $inventory->id }}').value;

                if (materialId !== "") {
                    const materialName = document.getElementById('material_id_{{ $inventory->id }}').selectedOptions[0].text;
                    const materialDescription = document.getElementById('material_id_{{ $inventory->id }}').selectedOptions[0].getAttribute('data-description');
                    const tableBody = document.querySelector('#materialTable_{{ $inventory->id }} tbody');
                    let existingRow = null;

                    tableBody.querySelectorAll('tr').forEach(row => {
                        const existingMaterialId = row.querySelector('input[name="materials[]"]').value;
                        if (existingMaterialId === materialId) {
                            existingRow = row;
                        }
                    });

                    if (existingRow) {
                        const quantityInput = existingRow.querySelector('input[name="quantities[]"]');
                        quantityInput.value = parseInt(quantityInput.value) + 1;
                    } else {
                        const newRow = document.createElement('tr');
                        newRow.innerHTML = `
                            <td>${materialName}<input type="hidden" name="materials[]" value="${materialId}"></td>
                            <td>${materialDescription}</td>
                            <td><input type="number" class="form-control" name="quantities[]" min="1" value="1"></td>
                            <td><button type="button" class="btn btn-danger btn-sm delete-row"><i class="fas fa-trash-alt"></i></button></td>
                        `;
                        tableBody.appendChild(newRow);

                        newRow.querySelector('.delete-row').addEventListener('click', function() {
                            newRow.remove();
                        });
                    }

                    document.getElementById('material_id_{{ $inventory->id }}').value = '';
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'Por favor seleccione un material.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            });
        });
    </script>
@endsection

<style>
    #materialTable_{{ $inventory->id }} tbody tr:nth-child(odd) {
        background-color: #ffffff;
    }
    #materialTable_{{ $inventory->id }} tbody tr:nth-child(even) {
        background-color: #f2f2f2;
    }
</style>
