<div class="modal fade" id="delete{{ $inventory->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteInventoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title" id="deleteInventoryLabel">Eliminar Elemento de Inventario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('inventories.destroy', $inventory->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('DELETE')
                <div class="modal-body text-center text-danger">
                    ¿Estás seguro de eliminar el elemento de inventario con ID: <strong>{{ $inventory->id}}</strong>?
                    Esta acción no se puede deshacer.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>
