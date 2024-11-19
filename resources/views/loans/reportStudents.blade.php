<div class="modal fade" id="reportLoan" role="dialog" aria-labelledby="reportLoan" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header modal-header-custom bg-maroon">
                <h5 class="modal-title" id="reportLoan">Reporte de Préstamos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="loanReportForm" method="GET" action="{{ route('report.loan.student') }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="studentId" class="form-label">Selecciona un Solicitante(*)</label>
                        <select class="form-control select2" name="studentId" id="studentId" required>
                            <option value="">Selecciona un solicitante</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }} {{ $student->last_name }}
                                </option>
                            @endforeach
                        </select>
                        <label for="startDate" class="form-label mt-3">Fecha inicio(*)</label>
                        <input type="date" id="startDate" name="startDate" class="form-control" required
                            placeholder="Ingrese fecha inicio" />
                        <label for="endDate" class="form-label mt-3">Fecha fin(*)</label>
                        <input type="date" id="endDate" name="endDate" class="form-control" required
                            placeholder="Ingrese fecha fin" />
                        <span id="dateError" class="text-danger mt-2" style="display: none;">La fecha de inicio no puede
                            ser mayor o igual a la fecha fin.</span>
                        <div class="form-check mt-3">
                            <input type="checkbox" class="form-check-input" id="includeReturns" name="includeReturns">
                            <label for="includeReturns" class="form-check-label">Incluir devoluciones</label>
                        </div>
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
        const form = document.getElementById('loanReportForm');
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
            const studentId = document.getElementById('studentId').value;
            const startDate = startDateInput.value;
            const endDate = endDateInput.value;

            return `${form.action}?studentId=${encodeURIComponent(studentId)}&startDate=${encodeURIComponent(startDate)}&endDate=${encodeURIComponent(endDate)}`;
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
