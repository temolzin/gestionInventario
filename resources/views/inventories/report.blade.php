<div class="modal fade" id="reportInventory" tabindex="-1" role="dialog" aria-labelledby="reportInventory" aria-hidden="true">
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

                        <label for="startDate" class="form-label">Fecha inicio(*)</label>
                        <input type="date" id="startDate" name="startDate" class="form-control" required placeholder="Ingrese fecha inicio"/>

                        <label for="endDate" class="form-label">Fecha fin(*)</label>
                        <input type="date" id="endDate" name="endDate" class="form-control" required placeholder="Ingrese fecha fin"/>
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

<style>
    .select2-container .select2-selection--single {
        height: 40px;
        display: flex;
        align-items: center;
    }
</style>

<script>
    document.getElementById('inventoryReportForm').onsubmit = function(event) {
        event.preventDefault();
        const form = event.target;
        const url = form.action;
        const inventoryStatus = document.getElementById('inventoryStatus').value;
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;

        const fullUrl = `${url}?inventoryStatus=${inventoryStatus}&startDate=${startDate}&endDate=${endDate}`;
        window.open(fullUrl, '_blank');
    };
</script>
