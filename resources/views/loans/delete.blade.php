<div class="modal fade" id="delete{{ $loan->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar Préstamo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('loans.destroy', $loan->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body text-center text-danger">
                    <p>¿Estás seguro de eliminar el préstamo para el solicitante
                        <strong>{{ $loan->student->name }}</strong>?
                    </p>
                    <p><em>{{ $loan->detail }}</em></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>
