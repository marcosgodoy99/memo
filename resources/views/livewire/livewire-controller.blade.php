<div>
    
    <button class="btn btn-sm btn-primary custom-button" wire:click="cambiarCantidad('incrementar')">
        <i class="bi bi-arrow-up-short"></i>
    </button>

    <p>
        {{ $cantidadProducto }}
    </p>
    <button class="btn btn-sm btn-primary custom-button" wire:click="cambiarCantidad('decrementar')">
        <i class="bi bi-arrow-down-short"></i>
    </button>
</div>
