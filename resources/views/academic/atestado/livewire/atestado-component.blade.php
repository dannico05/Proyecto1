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
            ['key' => 'grado', 'label' => __('Degree'), 'sortable' => true],
            ['key' => 'institucion', 'label' => __('Institution'), 'sortable' => true],
            ['key' => 'anioObtencion', 'label' => __('Year obtained'), 'sortable' => true],
            ['key' => 'areaEspecializacion', 'label' => __('Specialization area'), 'sortable' => true],
        ]"
        :mode="$tableMode"
        :rows="$rows ?? []"
        :searchable="['grado', 'institucion', 'area_especializacion']"
        :paginator="$atestados ?? null"
        :sort-key="$sortKey"
        :sort-dir="$sortDir"
        :per-page="$perPage"
        table-cols="1.5fr 2fr 1fr 2fr 1fr"
        :can-create="Auth::user()->can('create', \Src\Academic\Atestado\Domain\Entities\Atestado::class)"
        :can-search="Auth::user()->can('search', \Src\Academic\Atestado\Domain\Entities\Atestado::class)"
        :can-export-pdf="Auth::user()->can('exportPdf', \Src\Academic\Atestado\Domain\Entities\Atestado::class)"
        :can-export-excel="Auth::user()->can('exportExcel', \Src\Academic\Atestado\Domain\Entities\Atestado::class)"
        :title="__('Academic records management')">

        @if ($tableMode === 'client')
        <template x-for="row in pageRows" :key="row.id">
            <div class="data-row" role="row">
                <span x-text="row.grado"></span>
                <span x-text="row.institucion"></span>
                <span x-text="row.anioObtencion"></span>
                <span x-text="row.areaEspecializacion"></span>
                <div class="actions-cell">
                    <x-ui.row-actions
                        :can-edit="Auth::user()->hasPermissionTo('atestados.edit')"
                        :can-delete="Auth::user()->hasPermissionTo('atestados.delete')"
                        edit-action="$wire.openEditModal(row.id)"
                        delete-id="row.id" />
                </div>
            </div>
        </template>
        <div class="empty-row" x-show="pageRows.length === 0">{{ __('No records found') }}</div>
        @else
        @forelse ($atestados as $atestado)
        <div class="data-row" role="row">
            <span>{{ $atestado->grado() }}</span>
            <span>{{ $atestado->institucion() }}</span>
            <span>{{ $atestado->anioObtencion() }}</span>
            <span>{{ $atestado->areaEspecializacion() }}</span>
            <div class="actions-cell">
                <x-ui.row-actions
                    :can-edit="Auth::user()->can('update', $atestado)"
                    :can-delete="Auth::user()->can('delete', $atestado)"
                    edit-action="$wire.openEditModal({{ $atestado->id() }})"
                    delete-id="{{ $atestado->id() }}" />
            </div>
        </div>
        @empty
        <div class="empty-row">{{ __('No records found') }}</div>
        @endforelse
        @endif
    </x-ui.data-table>

    <x-ui.modal :show="$showModal" :title="$editingId === null ? __('New academic record') : __('Edit academic record')">
        <div class="form-field">
            <label for="atestadoDocente">{{ __('Teacher') }}</label>
            <select id="atestadoDocente" wire:model="form.docenteId" class="{{ $errors->has('form.docenteId') ? 'has-error' : '' }}">
                <option value="">{{ __('Select a teacher') }}</option>
                @foreach($docentes ?? [] as $docente)
                    <option value="{{ $docente->id() }}">{{ $docente->name() }} {{ $docente->lastName() }}</option>
                @endforeach
            </select>
            @error('form.docenteId') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-field">
            <label for="atestadoGrado">{{ __('Degree') }}</label>
            <select id="atestadoGrado" wire:model="form.grado" class="{{ $errors->has('form.grado') ? 'has-error' : '' }}">
                <option value="">{{ __('Select degree') }}</option>
                <option value="Bachillerato">Bachillerato</option>
                <option value="Licenciatura">Licenciatura</option>
                <option value="Maestría">Maestría</option>
                <option value="Doctorado">Doctorado</option>
            </select>
            @error('form.grado') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-field">
            <label for="atestadoInstitucion">{{ __('Institution') }}</label>
            <input type="text" id="atestadoInstitucion" wire:model="form.institucion" class="{{ $errors->has('form.institucion') ? 'has-error' : '' }}">
            @error('form.institucion') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-field">
            <label for="atestadoAnio">{{ __('Year obtained') }}</label>
            <input type="number" id="atestadoAnio" wire:model="form.anioObtencion" min="1900" max="{{ date('Y') }}" class="{{ $errors->has('form.anioObtencion') ? 'has-error' : '' }}">
            @error('form.anioObtencion') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-field">
            <label for="atestadoArea">{{ __('Specialization area') }}</label>
            <input type="text" id="atestadoArea" wire:model="form.areaEspecializacion" class="{{ $errors->has('form.areaEspecializacion') ? 'has-error' : '' }}">
            @error('form.areaEspecializacion') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <x-slot:footer>
            <button type="button" class="btn btn-secondary" wire:click="closeModal">{{ __('Cancel') }}</button>
            <button type="button" class="btn btn-primary" wire:click="save">{{ __('Confirm') }}</button>
        </x-slot:footer>
    </x-ui.modal>

    <x-ui.confirm-delete-modal :success-text="__('The academic record has been deleted.')" />
</div>