<div class="modal fade" id="edit{{ $loan->id }}" tabindex="-1" role="dialog" aria-labelledby="editLoanLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card-warning">
                <div class="card-header">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h4 class="card-title">Editar Préstamo <small>&nbsp;(*) Campos requeridos</small></h4>
                        <button type="button" class="close d-sm-inline-block text-white" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>

                <form id="loanEditForm{{ $loan->id }}" action="{{ route('loans.update', $loan->id) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="card">
                            <div class="card-header py-2 bg-secondary">
                                <h3 class="card-title">Detalles del Préstamo</h3>
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
                                            <label for="student_id">Estudiante(*)</label>
                                            <select class="form-control" id="student_id" name="student_id" required>
                                                @foreach ($students as $student)
                                                    <option value="{{ $student->id }}"
                                                        {{ $loan->student_id == $student->id ? 'selected' : '' }}>
                                                        {{ $student->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">Estado(*)</label>
                                            <input type="text" class="form-control" id="status" name="status"
                                                value="{{ $loan->status }}" placeholder="Ingrese el estado del préstamo"
                                                required />
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="detail">Detalles(*)</label>
                                            <textarea class="form-control" id="detail" name="detail" placeholder="Ingrese detalles del préstamo" required>{{ $loan->detail }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="return_at">Fecha de Devolución(*)</label>
                                            <input type="date" class="form-control" id="return_at" name="return_at"
                                                value="{{ $loan->return_at ? \Carbon\Carbon::parse($loan->return_at)->format('Y-m-d') : '' }}"
                                                required />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Materiales(*)</label>
                                    <div id="materialsContainer{{ $loan->id }}">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <select class="form-control" id="materialSelect{{ $loan->id }}">
                                                    <option value="">Seleccione un material</option>
                                                    @foreach ($materials as $material)
                                                        <option value="{{ $material->id }}">{{ $material->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-5">
                                                <input type="number" id="materialQuantity{{ $loan->id }}"
                                                    min="1" placeholder="Cantidad" class="form-control">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-warning"
                                                    id="addMaterialButton{{ $loan->id }}">Agregar</button>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="materials" id="materials{{ $loan->id }}"
                                        value='{{ json_encode($loan->materials) }}'>

                                    <div class="col-md-12 mt-4">
                                        <div class="card-header bg-warning text-white">
                                            <h5 class="card-title">Materiales Agregados</h5>
                                        </div>
                                        <table class="table table-bordered" id="materialsTable{{ $loan->id }}">
                                            <thead>
                                                <tr>
                                                    <th>Material</th>
                                                    <th>Cantidad</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id="materialsTableBody{{ $loan->id }}">
                                                @foreach ($loan->materials as $material)
                                                    <tr id="materialRow-{{ $material['id'] }}">
                                                        <td>{{ $material['name'] }}</td>
                                                        <td>
                                                            <input type="number" class="form-control"
                                                                name="materials[{{ $material['id'] }}][quantity]"
                                                                value="{{ $material->pivot->quantity }}" min="1"
                                                                onchange="updateMaterialQuantity('{{ $loan->id }}', '{{ $material['id'] }}', this.value)" />
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                onclick="removeMaterial(this, '{{ $loan->id }}', '{{ $material['id'] }}')">Eliminar</button>
                                                        </td>
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('addMaterialButton{{ $loan->id }}').addEventListener('click', function() {
        let materialSelect = document.getElementById('materialSelect{{ $loan->id }}');
        let materialQuantity = document.getElementById('materialQuantity{{ $loan->id }}').value;

        if (materialSelect.value && materialQuantity) {
            let materialRow = document.createElement('tr');
            materialRow.innerHTML = `
                <td>${materialSelect.options[materialSelect.selectedIndex].text}</td>
                <td>
                    <input type="number" class="form-control" name="materials[${materialSelect.value}][quantity]" value="${materialQuantity}" min="1" onchange="updateMaterialQuantity('{{ $loan->id }}', '${materialSelect.value}', this.value)" />
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeMaterial(this, '{{ $loan->id }}', '${materialSelect.value}')">Eliminar</button>
                </td>
            `;

            document.getElementById('materialsTableBody{{ $loan->id }}').appendChild(materialRow);
            document.getElementById('materialQuantity{{ $loan->id }}').value = '';
            materialSelect.value = '';
        } else {
            alert('Seleccione un material y una cantidad válida.');
        }
    });

    function removeMaterial(button, loanId, materialId) {
        button.closest('tr').remove();
    }

    function updateMaterialQuantity(loanId, materialId, quantity) {
        console.log(`Material ID: ${materialId}, Nueva cantidad: ${quantity}`);
    }
</script>
