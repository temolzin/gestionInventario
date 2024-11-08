<div class="modal fade" id="createInventory" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card-success">
                <div class="card-header">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h4 class="card-title">Agregar Inventario
                            <small>&nbsp;(*) Campos requeridos</small>
                        </h4>
                        <button type="button" class="close d-sm-inline-block text-white" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <form action="{{ route('inventories.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="card">
                            <div class="card-header py-2 bg-secondary">
                                <h3 class="card-title">Ingrese los Datos del Inventario</h3>
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
                                            <label for="labelMaterial" class="form-label">Material(*)</label>
                                            <select class="form-control select2" id="material_id">
                                                <option value="">Seleccione un material</option>
                                                @foreach ($materials as $material)
                                                    <option value="{{ $material->id }}"
                                                        data-description="{{ $material->description }}">
                                                        {{ $material->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="status" class="form-label">Estado(*)</label>
                                            <select class="form-control" id="status" name="status" required>
                                                <option value="disponible">Disponible</option>
                                                <option value="no disponible">No disponible</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <button type="button" id="addMaterialBtn" class="btn btn-primary">Agregar
                                                Material</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <table class="table table-bordered" id="materialTable">
                                            <thead>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Descripción</th>
                                                    <th>Cantidad</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="detail" class="form-label">Detalles:</label>
                                        <textarea name="detail" class="form-control" placeholder="Detalles de Préstamo" required></textarea>
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
    document.getElementById('addMaterialBtn').addEventListener('click', function() {
        const materialId = document.getElementById('material_id').value;
        if (materialId !== "") {
            const materialName = document.getElementById('material_id').selectedOptions[0].text;
            const materialDescription = document.getElementById('material_id').selectedOptions[0].getAttribute('data-description');
            const tableBody = document.querySelector('#materialTable tbody');
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

            $('#material_id').val(null).trigger('change');
        } else {
            Swal.fire({
                title: 'Error',
                text: 'Por favor seleccione un material.',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        }
    });
</script>

<style>
    #materialTable tbody tr:nth-child(odd) {
        background-color: #f2f2f2;
    }

    #materialTable tbody tr:nth-child(even) {
        background-color: #ffffff;
    }
</style>
