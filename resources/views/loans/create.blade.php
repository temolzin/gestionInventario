<div class="modal fade" id="createLoan" tabindex="-1" role="dialog" aria-labelledby="createLoanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card-success">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Crear Préstamo</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <form action="{{ route('loans.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-header bg-secondary py-2">
                                <h3 class="card-title mb-0">Ingrese los Datos del Préstamo</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="student_id" class="form-label">Estudiante:</label>
                                            <select name="student_id" id="student_id" class="form-control" required>
                                                <option value="">Seleccione un estudiante</option>
                                                @foreach ($students as $student)
                                                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status" class="form-label">Estado:</label>
                                            <input type="text" name="status" class="form-control" placeholder="Estado" required>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="detail" class="form-label">Detalles:</label>
                                            <textarea name="detail" class="form-control" placeholder="Detalles" required></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="return_at" class="form-label">Fecha de devolución:</label>
                                            <input type="date" name="return_at" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <h5>Seleccionar Material</h5>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="materialSelect">Material:</label>
                                            <select name="material_id" id="materialSelect" class="form-control" required>
                                                <option value="">Seleccione un material</option>
                                                @foreach ($materials as $material)
                                                    <option value="{{ $material->id }}" data-available="{{ $material->available_quantity }}">
                                                        {{ $material->name }} (Disponible: {{ $material->available_quantity }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="materialQuantity">Cantidad:</label>
                                            <input type="number" id="materialQuantity" class="form-control" placeholder="Cantidad" min="1" required>
                                        </div>
                                    </div>

                                    <div class="col-md-2 d-flex align-items-end justify-content-center">
                                        <button type="button" id="addMaterialBtn" class="btn btn-success w-100">Agregar Material</button>
                                    </div>

                                    <div class="col-md-12 mt-4">
                                        <div class="card-header bg-success text-white">
                                            <h5 class="card-title">Materiales Agregados</h5>
                                        </div>
                                        <table id="materialsTable" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Material</th>
                                                    <th>Cantidad</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success">Crear Préstamo</button>
                    </div>
                </form>

                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    let materialIndex = 0;

    document.getElementById('addMaterialBtn').addEventListener('click', function () {
        const materialSelect = document.getElementById('materialSelect');
        const materialId = materialSelect.value;
        const materialQuantity = document.getElementById('materialQuantity').value;
        const selectedOption = materialSelect.options[materialSelect.selectedIndex];
        const availableQuantity = selectedOption.getAttribute('data-available');
        const materialsTableBody = document.querySelector('#materialsTable tbody');

        if (materialId && materialQuantity > 0) {
            if (parseInt(materialQuantity) > parseInt(availableQuantity)) {
                alert("La cantidad solicitada excede la cantidad disponible en el inventario.");
                return;
            }

            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>
                    <input type="hidden" name="materials[${materialIndex}][id]" value="${materialId}">
                    <input type="text" class="form-control" value="${selectedOption.text}" disabled>
                </td>
                <td>
                    <input type="number" name="materials[${materialIndex}][quantity]" class="form-control" value="${materialQuantity}" min="1" required>
                </td>
                <td>
                    <button type="button" class="btn btn-danger removeMaterialBtn">Eliminar</button>
                </td>
            `;

            materialsTableBody.appendChild(newRow);
            materialIndex++;

            materialSelect.value = ''; 
            document.getElementById('materialQuantity').value = '';
        } else {
            alert("Por favor seleccione un material y una cantidad válida.");
        }
    });

    document.querySelector('#materialsTable tbody').addEventListener('click', function(e) {
        if (e.target.classList.contains('removeMaterialBtn')) {
            const row = e.target.closest('tr');
            const materialName = row.cells[0].innerText;

            const materialSelect = document.getElementById('materialSelect');
            for (let option of materialSelect.options) {
                if (option.text === materialName) {
                    option.disabled = false;
                }
            }

            row.remove();
        }
    });
</script>
