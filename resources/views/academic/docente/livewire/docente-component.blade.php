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
                ['key' => 'name', 'label' => __('Name'), 'sortable' => true],
                ['key' => 'lastName', 'label' => __('Last name'), 'sortable' => true],
                ['key' => 'governmentID', 'label' => __('ID number'), 'sortable' => false],
            ]"
        :mode="$tableMode"
        :rows="$rows ?? []"
        :searchable="['name']"
        :paginator="$docentes ?? null"
        :sort-key="$sortKey"
        :sort-dir="$sortDir"
        :per-page="$perPage"
        table-cols="2fr 2fr 1.5fr 1fr"
        :can-create="Auth::user()->can('create', \Src\Academic\Docente\Domain\Entities\Docente::class)"
        :can-search="Auth::user()->can('search', \Src\Academic\Docente\Domain\Entities\Docente::class)"
        :can-export-pdf="Auth::user()->can('exportPdf', \Src\Academic\Docente\Domain\Entities\Docente::class)"
        :can-export-excel="Auth::user()->can('exportExcel', \Src\Academic\Docente\Domain\Entities\Docente::class)"
        :title="__('Teachers management')">

        @if ($tableMode === 'client')
        <template x-for="row in pageRows" :key="row.id">
            <div class="data-row" role="row">
                <div class="name-cell">
                    <span class="name-avatar" x-text="row.name.charAt(0).toUpperCase()"></span>
                    <span class="name-text" x-text="row.name"></span>
                </div>
                <span x-text="row.lastName"></span>
                <span x-text="row.governmentID"></span>
                <div class="actions-cell">
                    <x-ui.row-actions
                        :can-edit="Auth::user()->hasPermissionTo('docentes.edit')"
                        :can-delete="Auth::user()->hasPermissionTo('docentes.delete')"
                        edit-action="$wire.openEditModal(row.id)"
                        delete-id="row.id" />
                </div>
            </div>
        </template>
        <div class="empty-row" x-show="pageRows.length === 0">{{ __('No records found') }}</div>
        @else
        @forelse ($docentes as $docente)
        <div class="data-row" role="row">
            <div class="name-cell">
                <span class="name-avatar">{{ Illuminate\Support\Str::upper(Illuminate\Support\Str::substr($docente->name(), 0, 1)) }}</span>
                <span class="name-text">{{ $docente->name() }}</span>
            </div>
            <span>{{ $docente->lastName() }}</span>
            <span>{{ $docente->governmentID() }}</span>
            <div class="actions-cell">
                <x-ui.row-actions
                    :can-edit="Auth::user()->can('update', $docente)"
                    :can-delete="Auth::user()->can('delete', $docente)"
                    edit-action="$wire.openEditModal({{ $docente->id() }})"
                    delete-id="{{ $docente->id() }}" />
            </div>
        </div>
        @empty
        <div class="empty-row">{{ __('No records found') }}</div>
        @endforelse
        @endif
    </x-ui.data-table>

    <x-ui.modal :show="$showModal" :title="$editingId === null ? __('New teacher') : __('Edit teacher')">
        <div class="form-field">
            <label for="docenteName">{{ __('Name') }}</label>
            <input type="text" id="docenteName" wire:model="form.name" class="{{ $errors->has('form.name') ? 'has-error' : '' }}">
            @error('form.name') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-field">
            <label for="docenteLastName">{{ __('Last name') }}</label>
            <input type="text" id="docenteLastName" wire:model="form.lastName" class="{{ $errors->has('form.lastName') ? 'has-error' : '' }}">
            @error('form.lastName') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-field">
            <label for="docenteGovernmentID">{{ __('ID number') }}</label>
            <input type="text" id="docenteGovernmentID" wire:model="form.governmentID" class="{{ $errors->has('form.governmentID') ? 'has-error' : '' }}">
            @error('form.governmentID') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <x-slot:footer>
            <button type="button" class="btn btn-secondary" wire:click="closeModal">{{ __('Cancel') }}</button>
            <button type="button" class="btn btn-primary" wire:click="save">{{ __('Confirm') }}</button>
        </x-slot:footer>
    </x-ui.modal>

    <x-ui.confirm-delete-modal :success-text="__('The teacher has been deleted.')" />
</div>