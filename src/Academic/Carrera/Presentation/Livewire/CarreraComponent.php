<?php

declare(strict_types=1);

namespace Src\Academic\Carrera\Presentation\Livewire;

use App\Livewire\Concerns\InteractsWithDataTable;
use App\Livewire\Concerns\InteractsWithExports;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Src\Academic\Carrera\Application\UseCases\CreateCarreraUseCase;
use Src\Academic\Carrera\Application\UseCases\DeleteCarreraUseCase;
use Src\Academic\Carrera\Application\UseCases\FindCarreraUseCase;
use Src\Academic\Carrera\Application\UseCases\ListCarrerasUseCase;
use Src\Academic\Carrera\Application\UseCases\UpdateCarreraUseCase;
use Src\Academic\Carrera\Domain\Entities\Carrera;
use Src\Academic\Carrera\Presentation\Livewire\Forms\CarreraForm;
use Src\Shared\Export\Contracts\ExcelExporterInterface;
use Src\Shared\Export\Contracts\PdfExporterInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CarreraComponent extends Component
{
    use AuthorizesRequests;
    use InteractsWithDataTable;
    use InteractsWithExports;

    protected string $tableMode = 'client';
    public bool $showModal = false;
    public ?int $editingId = null;
    public CarreraForm $form;

    public function mount(): void
    {
        $this->authorize('viewAny', Carrera::class);
        $this->sortKey = 'nombre';
    }

    public function openCreateModal(): void
    {
        $this->authorize('create', Carrera::class);
        $this->editingId = null;
        $this->form->reset();
        $this->resetValidation();
        $this->showModal = true;
    }

    public function openEditModal(int $id, FindCarreraUseCase $useCase): void
    {
        $carrera = $useCase->handle($id);
        $this->authorize('update', $carrera);
        $this->editingId = $id;
        $this->form->fromEntity($carrera);
        $this->resetValidation();
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    public function save(CreateCarreraUseCase $createUseCase, UpdateCarreraUseCase $updateUseCase, ListCarrerasUseCase $listUseCase, FindCarreraUseCase $findUseCase): void
    {
        $this->form->validate();
        if ($this->editingId === null) {
            $this->authorize('create', Carrera::class);
            $createUseCase->handle($this->form->toDto());
        } else {
            $this->authorize('update', $findUseCase->handle($this->editingId));
            $updateUseCase->handle($this->editingId, $this->form->toDto());
        }
        $this->showModal = false;
        $this->refreshTable($this->freshRows($listUseCase));
        $this->dispatch('toast', variant: 'success', text: $this->editingId === null ? __('Career created.') : __('Career updated.'));
    }

    public function delete(int $id, DeleteCarreraUseCase $useCase, ListCarrerasUseCase $listUseCase, FindCarreraUseCase $findUseCase): void
    {
        $this->authorize('delete', $findUseCase->handle($id));
        $useCase->handle($id);
        $this->refreshTable($this->freshRows($listUseCase));
        $this->dispatch('toast', variant: 'success', text: __('Career deleted.'));
    }

    public function exportPdf(PdfExporterInterface $exporter, ListCarrerasUseCase $useCase, ?string $search = null): StreamedResponse
    {
        $this->authorize('exportPdf', Carrera::class);
        return $this->streamPdf(__('Careers'), $this->exportHeaders(), $this->exportableRows($useCase, $search), Str::slug(__('Careers')) . '.pdf', $exporter, paperSize: 'letter');
    }

    public function exportExcel(ExcelExporterInterface $exporter, ListCarrerasUseCase $useCase, ?string $search = null): StreamedResponse
    {
        $this->authorize('exportExcel', Carrera::class);
        return $this->streamExcel($this->exportHeaders(), $this->exportableRows($useCase, $search), Str::slug(__('Careers')) . '.xlsx', $exporter);
    }

    public function render(ListCarrerasUseCase $useCase): View
    {
        $view = $this->isServerMode() ? $this->renderServerMode($useCase) : $this->renderClientMode($useCase);
        return $view->layout('components.layouts.dashboard', [
            'title' => __('Careers'),
            'subtitle' => __('Career management'),
        ]);
    }

    private function renderClientMode(ListCarrerasUseCase $useCase): View
    {
        return view('academic.carrera.livewire.carrera-component', [
            'tableMode' => 'client',
            'rows' => $this->freshRows($useCase),
        ]);
    }

    private function renderServerMode(ListCarrerasUseCase $useCase): View
    {
        $result = $useCase->paginate(search: $this->authorizedSearch(), perPage: $this->perPage, page: $this->page, sortBy: $this->sortKey, sortDir: $this->sortDir);
        $paginator = new LengthAwarePaginator(items: $result['items'], total: $result['total'], perPage: $this->perPage, currentPage: $this->page);
        return view('academic.carrera.livewire.carrera-component', ['tableMode' => 'server', 'carreras' => $paginator]);
    }

    private function toRow(Carrera $carrera): array
    {
        return ['id' => $carrera->id(), 'codigo' => $carrera->codigo(), 'nombre' => $carrera->nombre()];
    }

    private function freshRows(ListCarrerasUseCase $useCase): array
    {
        return array_map($this->toRow(...), $useCase->all(sortBy: $this->sortKey, sortDir: $this->sortDir));
    }

    private function exportableRows(ListCarrerasUseCase $useCase, ?string $search): array
    {
        return array_map($this->toRow(...), $useCase->all(search: $this->authorizedSearch($search), sortBy: $this->sortKey, sortDir: $this->sortDir));
    }

    private function authorizedSearch(?string $explicit = null): ?string
    {
        if (!Auth::user()->can('search', Carrera::class)) return null;
        $candidate = filled($explicit) ? $explicit : $this->search;
        return $candidate !== '' ? $candidate : null;
    }

    private function exportHeaders(): array
    {
        return [
            ['key' => 'codigo', 'label' => __('Code')],
            ['key' => 'nombre', 'label' => __('Name')],
        ];
    }
}