<?php

declare(strict_types=1);

namespace Src\Academic\CatalogoVersion\Presentation\Livewire;

use App\Livewire\Concerns\InteractsWithDataTable;
use App\Livewire\Concerns\InteractsWithExports;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Src\Academic\CatalogoVersion\Application\UseCases\CreateCatalogoVersionUseCase;
use Src\Academic\CatalogoVersion\Application\UseCases\DeleteCatalogoVersionUseCase;
use Src\Academic\CatalogoVersion\Application\UseCases\FindCatalogoVersionUseCase;
use Src\Academic\CatalogoVersion\Application\UseCases\ListCatalogoVersionsUseCase;
use Src\Academic\CatalogoVersion\Application\UseCases\UpdateCatalogoVersionUseCase;
use Src\Academic\CatalogoVersion\Domain\Entities\CatalogoVersion;
use Src\Academic\CatalogoVersion\Presentation\Livewire\Forms\CatalogoVersionForm;
use Src\Shared\Export\Contracts\ExcelExporterInterface;
use Src\Shared\Export\Contracts\PdfExporterInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CatalogoVersionComponent extends Component
{
    use AuthorizesRequests;
    use InteractsWithDataTable;
    use InteractsWithExports;

    protected string $tableMode = 'client';
    public bool $showModal = false;
    public ?int $editingId = null;
    public CatalogoVersionForm $form;

    public function mount(): void
    {
        $this->authorize('viewAny', CatalogoVersion::class);
        $this->sortKey = 'version';
    }

    public function openCreateModal(): void
    {
        $this->authorize('create', CatalogoVersion::class);
        $this->editingId = null;
        $this->form->reset();
        $this->resetValidation();
        $this->showModal = true;
    }

    public function openEditModal(int $id, FindCatalogoVersionUseCase $useCase): void
    {
        $catalogo = $useCase->handle($id);
        $this->authorize('update', $catalogo);
        $this->editingId = $id;
        $this->form->fromEntity($catalogo);
        $this->resetValidation();
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    public function addGrado(): void
    {
        $this->form->gradosAtinentes[] = '';
    }

    public function removeGrado(int $index): void
    {
        unset($this->form->gradosAtinentes[$index]);
        $this->form->gradosAtinentes = array_values($this->form->gradosAtinentes);
    }

    public function save(
        CreateCatalogoVersionUseCase $createUseCase,
        UpdateCatalogoVersionUseCase $updateUseCase,
        ListCatalogoVersionsUseCase $listUseCase,
        FindCatalogoVersionUseCase $findUseCase
    ): void {
        $this->form->validate();
        
        if ($this->editingId === null) {
            $this->authorize('create', CatalogoVersion::class);
            $createUseCase->handle($this->form->toDto());
        } else {
            $this->authorize('update', $findUseCase->handle($this->editingId));
            $updateUseCase->handle($this->editingId, $this->form->toDto());
        }
        
        $this->showModal = false;
        $this->refreshTable($this->freshRows($listUseCase));
        $this->dispatch('toast', variant: 'success', text: $this->editingId === null ? __('Catalog entry created.') : __('Catalog entry updated.'));
    }

    public function delete(int $id, DeleteCatalogoVersionUseCase $useCase, ListCatalogoVersionsUseCase $listUseCase, FindCatalogoVersionUseCase $findUseCase): void
    {
        $this->authorize('delete', $findUseCase->handle($id));
        $useCase->handle($id);
        $this->refreshTable($this->freshRows($listUseCase));
        $this->dispatch('toast', variant: 'success', text: __('Catalog entry deleted.'));
    }

    public function exportPdf(PdfExporterInterface $exporter, ListCatalogoVersionsUseCase $useCase, ?string $search = null): StreamedResponse
    {
        $this->authorize('exportPdf', CatalogoVersion::class);
        return $this->streamPdf(__('Atinence catalog'), $this->exportHeaders(), $this->exportableRows($useCase, $search), Str::slug(__('Atinence catalog')) . '.pdf', $exporter, paperSize: 'letter');
    }

    public function exportExcel(ExcelExporterInterface $exporter, ListCatalogoVersionsUseCase $useCase, ?string $search = null): StreamedResponse
    {
        $this->authorize('exportExcel', CatalogoVersion::class);
        return $this->streamExcel($this->exportHeaders(), $this->exportableRows($useCase, $search), Str::slug(__('Atinence catalog')) . '.xlsx', $exporter);
    }

    public function render(ListCatalogoVersionsUseCase $useCase): View
    {
        $carreras = app(\Src\Academic\Carrera\Application\UseCases\ListCarrerasUseCase::class)->all();
        $cursos = app(\Src\Academic\Curso\Application\UseCases\ListCursosUseCase::class)->all();
        
        $view = $this->isServerMode() ? $this->renderServerMode($useCase) : $this->renderClientMode($useCase);
        return $view->layout('components.layouts.dashboard', [
            'title' => __('Atinence catalog'),
            'subtitle' => __('Catalog management'),
        ])->with(['carreras' => $carreras, 'cursos' => $cursos]);
    }

    private function renderClientMode(ListCatalogoVersionsUseCase $useCase): View
    {
        return view('academic.catalogo-version.livewire.catalogo-version-component', [
            'tableMode' => 'client',
            'rows' => $this->freshRows($useCase),
            'carreras' => app(\Src\Academic\Carrera\Application\UseCases\ListCarrerasUseCase::class)->all(),
            'cursos' => app(\Src\Academic\Curso\Application\UseCases\ListCursosUseCase::class)->all(),
        ]);
    }

    private function renderServerMode(ListCatalogoVersionsUseCase $useCase): View
    {
        $result = $useCase->paginate(search: $this->authorizedSearch(), perPage: $this->perPage, page: $this->page, sortBy: $this->sortKey, sortDir: $this->sortDir);
        $paginator = new LengthAwarePaginator(items: $result['items'], total: $result['total'], perPage: $this->perPage, currentPage: $this->page);
        return view('academic.catalogo-version.livewire.catalogo-version-component', [
            'tableMode' => 'server',
            'catalogoVersions' => $paginator,
            'carreras' => app(\Src\Academic\Carrera\Application\UseCases\ListCarrerasUseCase::class)->all(),
            'cursos' => app(\Src\Academic\Curso\Application\UseCases\ListCursosUseCase::class)->all(),
        ]);
    }

    private function toRow(CatalogoVersion $catalogo): array
    {
        return [
            'id' => $catalogo->id(),
            'carreraId' => $catalogo->carreraId(),
            'cursoId' => $catalogo->cursoId(),
            'version' => $catalogo->version(),
            'acuerdo' => $catalogo->acuerdo(),
            'gaceta' => $catalogo->gaceta(),
            'gradosAtinentes' => implode(', ', $catalogo->gradosAtinentes()),
            'fechaInicioVigencia' => $catalogo->fechaInicioVigencia()->format('Y-m-d'),
            'fechaFinVigencia' => $catalogo->fechaFinVigencia()?->format('Y-m-d') ?? '-',
        ];
    }

    private function freshRows(ListCatalogoVersionsUseCase $useCase): array
    {
        return array_map($this->toRow(...), $useCase->all(sortBy: $this->sortKey, sortDir: $this->sortDir));
    }

    private function exportableRows(ListCatalogoVersionsUseCase $useCase, ?string $search): array
    {
        return array_map($this->toRow(...), $useCase->all(search: $this->authorizedSearch($search), sortBy: $this->sortKey, sortDir: $this->sortDir));
    }

    private function authorizedSearch(?string $explicit = null): ?string
    {
        if (!Auth::user()->can('search', CatalogoVersion::class)) return null;
        $candidate = filled($explicit) ? $explicit : $this->search;
        return $candidate !== '' ? $candidate : null;
    }

    private function exportHeaders(): array
    {
        return [
            ['key' => 'version', 'label' => __('Version')],
            ['key' => 'acuerdo', 'label' => __('Agreement')],
            ['key' => 'gaceta', 'label' => __('Gazette')],
            ['key' => 'gradosAtinentes', 'label' => __('Atinent degrees')],
            ['key' => 'fechaInicioVigencia', 'label' => __('Start date')],
            ['key' => 'fechaFinVigencia', 'label' => __('End date')],
        ];
    }
}