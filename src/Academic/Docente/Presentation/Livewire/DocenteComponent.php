<?php

declare(strict_types=1);

namespace Src\Academic\Docente\Presentation\Livewire;

use App\Livewire\Concerns\InteractsWithDataTable;
use App\Livewire\Concerns\InteractsWithExports;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Src\Academic\Docente\Application\UseCases\CreateDocenteUseCase;
use Src\Academic\Docente\Application\UseCases\DeleteDocenteUseCase;
use Src\Academic\Docente\Application\UseCases\FindDocenteUseCase;
use Src\Academic\Docente\Application\UseCases\ListDocentesUseCase;
use Src\Academic\Docente\Application\UseCases\UpdateDocenteUseCase;
use Src\Academic\Docente\Domain\Entities\Docente;
use Src\Academic\Docente\Presentation\Livewire\Forms\DocenteForm;
use Src\Shared\Export\Contracts\ExcelExporterInterface;
use Src\Shared\Export\Contracts\PdfExporterInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocenteComponent extends Component
{
    use AuthorizesRequests;
    use InteractsWithDataTable;
    use InteractsWithExports;

    protected string $tableMode = 'client';

    public bool $showModal = false;
    public ?int $editingId = null;
    public DocenteForm $form;

    public function mount(): void
    {
        $this->authorize('viewAny', Docente::class);
        $this->sortKey = 'nombre';
    }

    public function openCreateModal(): void
    {
        $this->authorize('create', Docente::class);
        $this->editingId = null;
        $this->form->reset();
        $this->resetValidation();
        $this->showModal = true;
    }

    public function openEditModal(int $id, FindDocenteUseCase $useCase): void
    {
        $docente = $useCase->handle($id);
        $this->authorize('update', $docente);

        $this->editingId = $id;
        $this->form->fromEntity($docente);
        $this->resetValidation();
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    public function save(CreateDocenteUseCase $createUseCase, UpdateDocenteUseCase $updateUseCase, ListDocentesUseCase $listUseCase, FindDocenteUseCase $findUseCase): void
    {
        $this->form->validate();

        if ($this->editingId === null) {
            $this->authorize('create', Docente::class);
            $createUseCase->handle($this->form->toDto());
        } else {
            $this->authorize('update', $findUseCase->handle($this->editingId));
            $updateUseCase->handle($this->editingId, $this->form->toDto());
        }

        $this->showModal = false;
        $this->refreshTable($this->freshRows($listUseCase));
        $this->dispatch('toast', variant: 'success', text: $this->editingId === null
            ? __('Teacher created.')
            : __('Teacher updated.'));
    }

    public function delete(int $id, DeleteDocenteUseCase $useCase, ListDocentesUseCase $listUseCase, FindDocenteUseCase $findUseCase): void
    {
        $this->authorize('delete', $findUseCase->handle($id));
        $useCase->handle($id);

        $this->refreshTable($this->freshRows($listUseCase));
        $this->dispatch('toast', variant: 'success', text: __('Teacher deleted.'));
    }

    public function exportPdf(PdfExporterInterface $exporter, ListDocentesUseCase $useCase, ?string $search = null): StreamedResponse
    {
        $this->authorize('exportPdf', Docente::class);

        return $this->streamPdf(__('Teachers'), $this->exportHeaders(), $this->exportableRows($useCase, $search), Str::slug(__('Teachers')) . '.pdf', $exporter, paperSize: 'letter');
    }

    public function exportExcel(ExcelExporterInterface $exporter, ListDocentesUseCase $useCase, ?string $search = null): StreamedResponse
    {
        $this->authorize('exportExcel', Docente::class);

        return $this->streamExcel($this->exportHeaders(), $this->exportableRows($useCase, $search), Str::slug(__('Teachers')) . '.xlsx', $exporter);
    }

    public function render(ListDocentesUseCase $useCase): View
    {
        $view = $this->isServerMode() ? $this->renderServerMode($useCase) : $this->renderClientMode($useCase);

        return $view->layout('components.layouts.dashboard', [
            'title' => __('Teachers'),
            'subtitle' => __('Teacher management'),
        ]);
    }

    private function renderClientMode(ListDocentesUseCase $useCase): View
    {
        return view('academic.docente.livewire.docente-component', [
            'tableMode' => 'client',
            'rows' => $this->freshRows($useCase),
        ]);
    }

    private function renderServerMode(ListDocentesUseCase $useCase): View
    {
        $result = $useCase->paginate(search: $this->authorizedSearch(), perPage: $this->perPage, page: $this->page, sortBy: $this->sortKey, sortDir: $this->sortDir);
        $paginator = new LengthAwarePaginator(items: $result['items'], total: $result['total'], perPage: $this->perPage, currentPage: $this->page);

        return view('academic.docente.livewire.docente-component', ['tableMode' => 'server', 'docentes' => $paginator]);
    }

    private function toRow(Docente $docente): array
    {
        return ['id' => $docente->id(), 'name' => $docente->name(), 'lastName' => $docente->lastName(), 'governmentID' => $docente->governmentID()];
    }

    private function freshRows(ListDocentesUseCase $useCase): array
    {
        return array_map($this->toRow(...), $useCase->all(sortBy: $this->sortKey, sortDir: $this->sortDir));
    }

    private function exportableRows(ListDocentesUseCase $useCase, ?string $search): array
    {
        return array_map($this->toRow(...), $useCase->all(search: $this->authorizedSearch($search), sortBy: $this->sortKey, sortDir: $this->sortDir));
    }

    private function authorizedSearch(?string $explicit = null): ?string
    {
        if (! Auth::user()->can('search', Docente::class)) {
            return null;
        }
        $candidate = filled($explicit) ? $explicit : $this->search;
        return $candidate !== '' ? $candidate : null;
    }

    private function exportHeaders(): array
    {
        return [
            ['key' => 'name', 'label' => __('Name')],
            ['key' => 'lastName', 'label' => __('Last name')],
            ['key' => 'governmentID', 'label' => __('ID number')],
        ];
    }
}