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
    addGrado() {
        $wire.addGrado();
    },
    removeGrado(index) {
        $wire.removeGrado(index);
    }
}">
    <x-ui.data-table
        :headers="[
            ['key' => 'version', 'label' => __('Version'), 'sortable' => true],
            ['key' => 'acuerdo', 'label' => __('Agreement'), 'sortable' => true],
            ['key' => 'gaceta', 'label' => __('Gazette'), 'sortable' => true],
            ['key' => 'gradosAtinentes', 'label' => __('Atinent degrees'), 'sortable' => false],
            ['key' => 'fechaInicioVigencia', 'label' => __('Start date'), 'sortable' => true],
            ['key' => 'fechaFinVigencia', 'label' => __('End date'), 'sortable' => true],
        ]"
        :mode="$tableMode"
        :rows="$rows ?? []"
        :searchable="['acuerdo', 'gaceta']"
        :paginator="$catalogoVersions ?? null"
        :sort-key="$sortKey"
        :sort-dir="$sortDir"
        :per-page="$perPage"
        table-cols="1fr 1.5fr 1.5fr 2fr 1.5fr 1.5fr 1fr"
        :can-create="Auth::user()->can('create', \Src\Academic\CatalogoVersion\Domain\Entities\CatalogoVersion::class)"
        :can-search="Auth::user()->can('search', \Src\Academic\CatalogoVersion\Domain\Entities\CatalogoVersion::class)"
        :can-export-pdf="Auth::user()->can('exportPdf', \Src\Academic\CatalogoVersion\Domain\Entities\CatalogoVersion::class)"
        :can-export-excel="Auth::user()->can('exportExcel', \Src\Academic\CatalogoVersion\Domain\Entities\CatalogoVersion::class)"
        :title="__('Atinence catalog management')">

        @if ($tableMode === 'client')
        <template x-for="row in pageRows" :key="row.id">
            <div class="data-row" role="row">
                <span x-text="row.version"></span>
                <span x-text="row.acuerdo"></span>
                <span x-text="row.gaceta"></span>
                <span x-text="row.gradosAtinentes"></span>
                <span x-text="row.fechaInicioVigencia"></span>
                <span x-text="row.fechaFinVigencia"></span>
                <div class="actions-cell">
                    <x-ui.row-actions
                        :can-edit="Auth::user()->hasPermissionTo('catalogo_versiones.edit')"
                        :can-delete="Auth::user()->hasPermissionTo('catalogo_versiones.delete')"
                        edit-action="$wire.openEditModal(row.id)"
                        delete-id="row.id" />
                </div>
            </div>
        </template>
        <div class="empty-row" x-show="pageRows.length === 0">{{ __('No records found') }}</div>
        @else
        @forelse ($catalogoVersions as $catalogo)
        <div class="data-row" role="row">
            <span>{{ $catalogo->version() }}</span>
            <span>{{ $catalogo->acuerdo() }}</span>
            <span>{{ $catalogo->gaceta() }}</span>
            <span>{{ implode(', ', $catalogo->gradosAtinentes()) }}</span>
            <span>{{ $catalogo->fechaInicioVigencia()->format('Y-m-d') }}</span>
            <span>{{ $catalogo->fechaFinVigencia()?->format('Y-m-d') ?? '-' }}</span>
            <div class="actions-cell">
                <x-ui.row-actions
                    :can-edit="Auth::user()->can('update', $catalogo)"
                    :can-delete="Auth::user()->can('delete', $catalogo)"
                    edit-action="$wire.openEditModal({{ $catalogo->id() }})"
                    delete-id="{{ $catalogo->id() }}" />
            </div>
        </div>
        @empty
        <div class="empty-row">{{ __('No records found') }}</div>
        @endforelse
        @endif
    </x-ui.data-table>

    <x-ui.modal :show="$showModal" :title="$editingId === null ? __('New catalog entry') : __('Edit catalog entry')" size="lg">
        <div class="grid grid-cols-2 gap-4">
            <div class="form-field">
                <label for="catalogoCarrera">{{ __('Career') }}</label>
                <select id="catalogoCarrera" wire:model="form.carreraId" class="{{ $errors->has('form.carreraId') ? 'has-error' : '' }}">
                    <option value="">{{ __('Select a career') }}</option>
                    @foreach($carreras ?? [] as $carrera)
                        <option value="{{ $carrera->id() }}">{{ $carrera->codigo() }} - {{ $carrera->nombre() }}</option>
                    @endforeach
                </select>
                @error('form.carreraId') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-field">
                <label for="catalogoCurso">{{ __('Course') }}</label>
                <select id="catalogoCurso" wire:model="form.cursoId" class="{{ $errors->has('form.cursoId') ? 'has-error' : '' }}">
                    <option value="">{{ __('Select a course') }}</option>
                    @foreach($cursos ?? [] as $curso)
                        <option value="{{ $curso->id() }}">{{ $curso->codigo() }} - {{ $curso->nombre() }}</option>
                    @endforeach
                </select>
                @error('form.cursoId') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-field">
                <label for="catalogoVersion">{{ __('Version') }}</label>
                <input type="number" id="catalogoVersion" wire:model="form.version" min="1" class="{{ $errors->has('form.version') ? 'has-error' : '' }}">
                @error('form.version') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-field">
                <label for="catalogoAcuerdo">{{ __('Agreement') }}</label>
                <input type="text" id="catalogoAcuerdo" wire:model="form.acuerdo" class="{{ $errors->has('form.acuerdo') ? 'has-error' : '' }}">
                @error('form.acuerdo') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-field">
                <label for="catalogoGaceta">{{ __('Gazette') }}</label>
                <input type="text" id="catalogoGaceta" wire:model="form.gaceta" class="{{ $errors->has('form.gaceta') ? 'has-error' : '' }}">
                @error('form.gaceta') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-field">
                <label for="catalogoFechaInicio">{{ __('Start date') }}</label>
                <input type="date" id="catalogoFechaInicio" wire:model="form.fechaInicioVigencia" class="{{ $errors->has('form.fechaInicioVigencia') ? 'has-error' : '' }}">
                @error('form.fechaInicioVigencia') <span class="form-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-field">
                <label for="catalogoFechaFin">{{ __('End date') }}</label>
                <input type="date" id="catalogoFechaFin" wire:model="form.fechaFinVigencia" class="{{ $errors->has('form.fechaFinVigencia') ? 'has-error' : '' }}">
                @error('form.fechaFinVigencia') <span class="form-error">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-field mt-4">
            <label>{{ __('Atinent degrees') }}</label>
            <div class="space-y-2">
                @foreach($form->gradosAtinentes as $index => $grado)
                    <div class="flex items-center gap-2">
                        <input type="text" wire:model="form.gradosAtinentes.{{ $index }}" class="flex-1 {{ $errors->has('form.gradosAtinentes.'.$index) ? 'has-error' : '' }}" placeholder="{{ __('Enter degree name') }}">
                        <button type="button" class="btn btn-danger btn-sm" @click="removeGrado({{ $index }})">✕</button>
                    </div>
                @endforeach
                @error('form.gradosAtinentes') <span class="form-error">{{ $message }}</span> @enderror
                <button type="button" class="btn btn-secondary btn-sm" @click="addGrado">+ {{ __('Add degree') }}</button>
            </div>
        </div>

        <x-slot:footer>
            <button type="button" class="btn btn-secondary" wire:click="closeModal">{{ __('Cancel') }}</button>
            <button type="button" class="btn btn-primary" wire:click="save">{{ __('Confirm') }}</button>
        </x-slot:footer>
    </x-ui.modal>

    <x-ui.confirm-delete-modal :success-text="__('The catalog entry has been deleted.')" />
</div>