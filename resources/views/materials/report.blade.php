<div class="modal fade" id="reportMaterial" role="dialog" aria-labelledby="reportMaterial" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header modal-header-custom bg-maroon">
                <h5 class="modal-title" id="reportMaterial">Reporte de Materiales</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="materialReportForm" method="GET" action="{{ route('materials.report.byLimit') }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="reportType" class="form-label">Tipo de Reporte(*)</label>
                        <select class="form-control" name="reportType" id="reportType" required>
                            <option value="">Selecciona tipo de reporte</option>
                            <option value="alta">Alta Existencia</option>
                            <option value="baja">Baja Existencia</option>
                        </select>
                        <label for="stockLimit" class="form-label">Límite de Existencia(*)</label>
                        <input type="number" id="stockLimit" name="stockLimit" class="form-control" required
                            placeholder="Ingrese límite de existencia" min="0" />
                        <div id="reportDescription" class="text-danger small mt-2"></div>
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
    document.getElementById('materialReportForm').onsubmit = function(event) {
        event.preventDefault();
        const form = event.target;
        const url = form.action;
        const reportType = document.getElementById('reportType').value;
        const stockLimit = document.getElementById('stockLimit').value;

        const fullUrl = `${url}?reportType=${reportType}&stockLimit=${stockLimit}`;
        window.open(fullUrl, '_blank');
    };

    document.getElementById('stockLimit').addEventListener('input', function(event) {
        const input = event.target;
        if (input.value < 0) {
            input.value = 0;
        }
    });

    document.getElementById('reportType').addEventListener('change', function() {
        const reportType = this.value;
        const reportDescription = document.getElementById('reportDescription');

        if (reportType === 'alta') {
            reportDescription.textContent =
                "Genera un reporte de materiales con existencias superiores al límite especificado.";
        } else if (reportType === 'baja') {
            reportDescription.textContent =
                "Genera un reporte de materiales con existencias inferiores al límite especificado.";
        } else {
            reportDescription.textContent = "";
        }
    });
</script>
