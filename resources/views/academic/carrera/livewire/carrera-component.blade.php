<div x-data="{
    confirmDelete: { open: false, step: 'confirm', id: null },
    askDelete(id) {
        this.confirmDelete = { open: true, step: 'confirm', id };
    },
    runDelete() {
        $wire.delete(this.confirmDelete.id)
            .then(() => { this.confirmDelete.step = 'success'; })
            .catch(() => { this.confirmDelete.open = false; });
    },
    closeDeleteModal() {
        this.confirmDelete.open = false;
    },
}">
    <x-ui.data-table
        :headers="[
            ['key' => 'codigo', 'label' => __('Code'), 'sortable' => true],
            ['key' => 'nombre', 'label' => __('Name'), 'sortable' => true],
        ]"
        :mode="$tableMode"
        :rows="$rows ?? []"
        :searchable="['codigo', 'nombre']"
        :paginator="$carreras ?? null"
        :sort-key="$sortKey"
        :sort-dir="$sortDir"
        :per-page="$perPage"
        table-cols="1.5fr 2fr 1fr"
        :can-create="Auth::user()->can('create', \Src\Academic\Carrera\Domain\Entities\Carrera::class)"
        :can-search="Auth::user()->can('search', \Src\Academic\Carrera\Domain\Entities\Carrera::class)"
        :can-export-pdf="Auth::user()->can('exportPdf', \Src\Academic\Carrera\Domain\Entities\Carrera::class)"
        :can-export-excel="Auth::user()->can('exportExcel', \Src\Academic\Carrera\Domain\Entities\Carrera::class)"
        :title="__('Careers management')">

        @if ($tableMode === 'client')
        <template x-for="row in pageRows" :key="row.id">
            <div class="data-row" role="row">
                <span x-text="row.codigo"></span>
                <span x-text="row.nombre"></span>
                <div class="actions-cell">
                    <x-ui.row-actions
                        :can-edit="Auth::user()->hasPermissionTo('carreras.edit')"
                        :can-delete="Auth::user()->hasPermissionTo('carreras.delete')"
                        edit-action="$wire.openEditModal(row.id)"
                        delete-id="row.id" />
                </div>
            </div>
        </template>
        <div class="empty-row" x-show="pageRows.length === 0">{{ __('No records found') }}</div>
        @else
        @forelse ($carreras as $carrera)
        <div class="data-row" role="row">
            <span>{{ $carrera->codigo() }}</span>
            <span>{{ $carrera->nombre() }}</span>
            <div class="actions-cell">
                <x-ui.row-actions
                    :can-edit="Auth::user()->can('update', $carrera)"
                    :can-delete="Auth::user()->can('delete', $carrera)"
                    edit-action="$wire.openEditModal({{ $carrera->id() }})"
                    delete-id="{{ $carrera->id() }}" />
            </div>
        </div>
        @empty
        <div class="empty-row">{{ __('No records found') }}</div>
        @endforelse
        @endif
    </x-ui.data-table>

    <x-ui.modal :show="$showModal" :title="$editingId === null ? __('New career') : __('Edit career')">
        <div class="form-field">
            <label for="carreraCodigo">{{ __('Code') }}</label>
            <input type="text" id="carreraCodigo" wire:model="form.codigo" class="{{ $errors->has('form.codigo') ? 'has-error' : '' }}">
            @error('form.codigo') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-field">
            <label for="carreraNombre">{{ __('Name') }}</label>
            <input type="text" id="carreraNombre" wire:model="form.nombre" class="{{ $errors->has('form.nombre') ? 'has-error' : '' }}">
            @error('form.nombre') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <x-slot:footer>
            <button type="button" class="btn btn-secondary" wire:click="closeModal">{{ __('Cancel') }}</button>
            <button type="button" class="btn btn-primary" wire:click="save">{{ __('Confirm') }}</button>
        </x-slot:footer>
    </x-ui.modal>

    <x-ui.confirm-delete-modal :success-text="__('The career has been deleted.')" />
</div>