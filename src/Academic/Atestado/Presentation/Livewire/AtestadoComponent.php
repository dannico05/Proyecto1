<?php

declare(strict_types=1);

namespace Src\Academic\Atestado\Presentation\Livewire;

use App\Livewire\Concerns\InteractsWithDataTable;
use App\Livewire\Concerns\InteractsWithExports;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Src\Academic\Atestado\Application\UseCases\CreateAtestadoUseCase;
use Src\Academic\Atestado\Application\UseCases\DeleteAtestadoUseCase;
use Src\Academic\Atestado\Application\UseCases\FindAtestadoUseCase;
use Src\Academic\Atestado\Application\UseCases\ListAtestadosUseCase;
use Src\Academic\Atestado\Application\UseCases\UpdateAtestadoUseCase;
use Src\Academic\Atestado\Domain\Entities\Atestado;
use Src\Academic\Atestado\Presentation\Livewire\Forms\AtestadoForm;
use Src\Shared\Export\Contracts\ExcelExporterInterface;
use Src\Shared\Export\Contracts\PdfExporterInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AtestadoComponent extends Component
{
    use AuthorizesRequests;
    use InteractsWithDataTable;
    use InteractsWithExports;

    protected string $tableMode = 'client';
    public bool $showModal = false;
    public ?int $editingId = null;
    public AtestadoForm $form;

    public function mount(): void
    {
        $this->authorize('viewAny', Atestado::class);
        $this->sortKey = 'grado';
    }

    public function openCreateModal(): void
    {
        $this->authorize('create', Atestado::class);
        $this->editingId = null;
        $this->form->reset();
        $this->resetValidation();
        $this->showModal = true;
    }

    public function openEditModal(int $id, FindAtestadoUseCase $useCase): void
    {
        $atestado = $useCase->handle($id);
        $this->authorize('update', $atestado);
        $this->editingId = $id;
        $this->form->fromEntity($atestado);
        $this->resetValidation();
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    public function save(CreateAtestadoUseCase $createUseCase, UpdateAtestadoUseCase $updateUseCase, ListAtestadosUseCase $listUseCase, FindAtestadoUseCase $findUseCase): void
    {
        $this->form->validate();
        if ($this->editingId === null) {
            $this->authorize('create', Atestado::class);
            $createUseCase->handle($this->form->toDto());
        } else {
            $this->authorize('update', $findUseCase->handle($this->editingId));
            $updateUseCase->handle($this->editingId, $this->form->toDto());
        }
        $this->showModal = false;
        $this->refreshTable($this->freshRows($listUseCase));
        $this->dispatch('toast', variant: 'success', text: $this->editingId === null ? __('Academic record created.') : __('Academic record updated.'));
    }

    public function delete(int $id, DeleteAtestadoUseCase $useCase, ListAtestadosUseCase $listUseCase, FindAtestadoUseCase $findUseCase): void
    {
        $this->authorize('delete', $findUseCase->handle($id));
        $useCase->handle($id);
        $this->refreshTable($this->freshRows($listUseCase));
        $this->dispatch('toast', variant: 'success', text: __('Academic record deleted.'));
    }

    public function exportPdf(PdfExporterInterface $exporter, ListAtestadosUseCase $useCase, ?string $search = null): StreamedResponse
    {
        $this->authorize('exportPdf', Atestado::class);
        return $this->streamPdf(__('Academic records'), $this->exportHeaders(), $this->exportableRows($useCase, $search), Str::slug(__('Academic records')) . '.pdf', $exporter, paperSize: 'letter');
    }

    public function exportExcel(ExcelExporterInterface $exporter, ListAtestadosUseCase $useCase, ?string $search = null): StreamedResponse
    {
        $this->authorize('exportExcel', Atestado::class);
        return $this->streamExcel($this->exportHeaders(), $this->exportableRows($useCase, $search), Str::slug(__('Academic records')) . '.xlsx', $exporter);
    }

    public function render(ListAtestadosUseCase $useCase): View
    {
        $view = $this->isServerMode() ? $this->renderServerMode($useCase) : $this->renderClientMode($useCase);
        return $view->layout('components.layouts.dashboard', [
            'title' => __('Academic records'),
            'subtitle' => __('Academic record management'),
        ]);

         // Cargar docentes para el select
        $docentes = app(\Src\Academic\Docente\Application\UseCases\ListDocentesUseCase::class)->all();
        
        $view = $this->isServerMode() ? $this->renderServerMode($useCase) : $this->renderClientMode($useCase);
        return $view->layout('components.layouts.dashboard', [
            'title' => __('Academic records'),
            'subtitle' => __('Academic record management'),
        ])->with('docentes', $docentes);
    }

    private function renderClientMode(ListAtestadosUseCase $useCase): View
    {
        return view('academic.atestado.livewire.atestado-component', [
        'tableMode' => 'client',
        'rows' => $this->freshRows($useCase),
        'docentes' => app(\Src\Academic\Docente\Application\UseCases\ListDocentesUseCase::class)->all(),
    ]);
    }

    private function renderServerMode(ListAtestadosUseCase $useCase): View
    {
        $result = $useCase->paginate(search: $this->authorizedSearch(), perPage: $this->perPage, page: $this->page, sortBy: $this->sortKey, sortDir: $this->sortDir);
        $paginator = new LengthAwarePaginator(items: $result['items'], total: $result['total'], perPage: $this->perPage, currentPage: $this->page);
        return view('academic.atestado.livewire.atestado-component', [
            'tableMode' => 'server', 
            'atestados' => $paginator,
            'docentes' => app(\Src\Academic\Docente\Application\UseCases\ListDocentesUseCase::class)->all(),
        ]);
    }

    private function toRow(Atestado $atestado): array
    {
        return [
            'id' => $atestado->id(),
            'docenteId' => $atestado->docenteId(),
            'grado' => $atestado->grado(),
            'institucion' => $atestado->institucion(),
            'anioObtencion' => $atestado->anioObtencion(),
            'areaEspecializacion' => $atestado->areaEspecializacion(),
        ];
    }

    private function freshRows(ListAtestadosUseCase $useCase): array
    {
        return array_map($this->toRow(...), $useCase->all(sortBy: $this->sortKey, sortDir: $this->sortDir));
    }

    private function exportableRows(ListAtestadosUseCase $useCase, ?string $search): array
    {
        return array_map($this->toRow(...), $useCase->all(search: $this->authorizedSearch($search), sortBy: $this->sortKey, sortDir: $this->sortDir));
    }

    private function authorizedSearch(?string $explicit = null): ?string
    {
        if (!Auth::user()->can('search', Atestado::class)) return null;
        $candidate = filled($explicit) ? $explicit : $this->search;
        return $candidate !== '' ? $candidate : null;
    }

    private function exportHeaders(): array
    {
        return [
            ['key' => 'grado', 'label' => __('Degree')],
            ['key' => 'institucion', 'label' => __('Institution')],
            ['key' => 'anioObtencion', 'label' => __('Year obtained')],
            ['key' => 'areaEspecializacion', 'label' => __('Specialization area')],
        ];
    }
}