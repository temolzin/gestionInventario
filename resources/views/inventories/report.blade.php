<div class="modal fade" id="reportInventory" role="dialog" aria-labelledby="reportInventory" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header modal-header-custom bg-maroon">
                <h5 class="modal-title" id="reportInventory">Reporte de Inventarios</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="inventoryReportForm" method="GET" action="{{ route('report.inventory') }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inventoryStatus" class="form-label">Estado del Inventario(*)</label>
                        <select class="form-control select2" name="inventoryStatus" id="inventoryStatus" required>
                            <option value="">Selecciona un estado</option>
                            <option value="disponible">Disponible</option>
                            <option value="no disponible">No disponible</option>
                        </select>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="ignoreStatus" name="ignoreStatus">
                            <label class="form-check-label" for="ignoreStatus">Ignorar estado (solo por fechas)</label>
                        </div>
                        <label for="startDate" class="form-label">Fecha inicio(*)</label>
                        <input type="date" id="startDate" name="startDate" class="form-control" required
                            placeholder="Ingrese fecha inicio" />
                        <label for="endDate" class="form-label">Fecha fin(*)</label>
                        <input type="date" id="endDate" name="endDate" class="form-control" required
                            placeholder="Ingrese fecha fin" />
                        <span id="dateError" class="text-danger mt-2" style="display: none;">La fecha de inicio no puede
                            ser mayor o igual a la fecha fin.</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn bg-maroon">Generar Reporte</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('inventoryReportForm');
        const startDateInput = document.getElementById('startDate');
        const endDateInput = document.getElementById('endDate');
        const dateError = document.getElementById('dateError');

        const validateDates = () => {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);
            const isInvalid = startDate && endDate && startDate >= endDate;

            dateError.style.display = isInvalid ? 'block' : 'none';
            return !isInvalid;
        };

        const generateReportUrl = () => {
            const inventoryStatus = document.getElementById('inventoryStatus').value;
            const ignoreStatus = document.getElementById('ignoreStatus').checked ? 1 : 0;
            const startDate = startDateInput.value;
            const endDate = endDateInput.value;

            return `${form.action}?inventoryStatus=${encodeURIComponent(inventoryStatus)}&startDate=${encodeURIComponent(startDate)}&endDate=${encodeURIComponent(endDate)}&ignoreStatus=${ignoreStatus}`;
        };

        form.addEventListener('submit', (event) => {
            event.preventDefault();

            if (validateDates()) {
                window.open(generateReportUrl(), '_blank');
            }
        });

        startDateInput.addEventListener('change', validateDates);
        endDateInput.addEventListener('change', validateDates);
    });
</script>
