<?php

declare(strict_types=1);

namespace Src\Academic\Curso\Presentation\Livewire;



use App\Livewire\Concerns\InteractsWithDataTable;
use App\Livewire\Concerns\InteractsWithExports;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Src\Academic\Curso\Application\UseCases\CreateCursoUseCase;
use Src\Academic\Curso\Application\UseCases\DeleteCursoUseCase;
use Src\Academic\Curso\Application\UseCases\FindCursoUseCase;
use Src\Academic\Curso\Application\UseCases\ListCursosUseCase;
use Src\Academic\Curso\Application\UseCases\UpdateCursoUseCase;
use Src\Academic\Curso\Domain\Entities\Curso;
use Src\Academic\Curso\Presentation\Livewire\Forms\CursoForm;
use Src\Shared\Export\Contracts\ExcelExporterInterface;
use Src\Shared\Export\Contracts\PdfExporterInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CursoComponent extends Component
{
    use AuthorizesRequests;
    use InteractsWithDataTable;
    use InteractsWithExports;

    protected string $tableMode = 'client';

    public bool $showModal = false;
    public ?int $editingId = null;
    public CursoForm $form;

    public function mount(): void
    {
        $this->authorize('viewAny', Curso::class);
        $this->sortKey = 'nombre';
    }

    public function openCreateModal(): void
    {
        $this->authorize('create', Curso::class);
        $this->editingId = null;
        $this->form->reset();
        $this->resetValidation();
        $this->showModal = true;
    }

    public function openEditModal(int $id, FindCursoUseCase $useCase): void
    {
        $curso = $useCase->handle($id);
        $this->authorize('update', $curso);

        $this->editingId = $id;
        $this->form->fromEntity($curso);
        $this->resetValidation();
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    public function save(CreateCursoUseCase $createUseCase, UpdateCursoUseCase $updateUseCase, ListCursosUseCase $listUseCase, FindCursoUseCase $findUseCase): void
    {
        $this->form->validate();

        if ($this->editingId === null) {
            $this->authorize('create', Curso::class);
            $createUseCase->handle($this->form->toDto());
        } else {
            $this->authorize('update', $findUseCase->handle($this->editingId));
            $updateUseCase->handle($this->editingId, $this->form->toDto());
        }

        $this->showModal = false;
        $this->refreshTable($this->freshRows($listUseCase));
        $this->dispatch('toast', variant: 'success', text: $this->editingId === null
            ? __('Course created.')
            : __('Course updated.'));
    }

    public function delete(int $id, DeleteCursoUseCase $useCase, ListCursosUseCase $listUseCase, FindCursoUseCase $findUseCase): void
    {
        $this->authorize('delete', $findUseCase->handle($id));
        $useCase->handle($id);

        $this->refreshTable($this->freshRows($listUseCase));
        $this->dispatch('toast', variant: 'success', text: __('Course deleted.'));
    }

    public function exportPdf(PdfExporterInterface $exporter, ListCursosUseCase $useCase, ?string $search = null): StreamedResponse
    {
        $this->authorize('exportPdf', Curso::class);

        return $this->streamPdf(__('Courses'), $this->exportHeaders(), $this->exportableRows($useCase, $search), Str::slug(__('Courses')) . '.pdf', $exporter, paperSize: 'letter');
    }

    public function exportExcel(ExcelExporterInterface $exporter, ListCursosUseCase $useCase, ?string $search = null): StreamedResponse
    {
        $this->authorize('exportExcel', Curso::class);

        return $this->streamExcel($this->exportHeaders(), $this->exportableRows($useCase, $search), Str::slug(__('Courses')) . '.xlsx', $exporter);
    }

    public function render(ListCursosUseCase $useCase): View
    {
        $view = $this->isServerMode() ? $this->renderServerMode($useCase) : $this->renderClientMode($useCase);

        return $view->layout('components.layouts.dashboard', [
            'title' => __('Courses'),
            'subtitle' => __('Course management'),
        ]);
    }

    private function renderClientMode(ListCursosUseCase $useCase): View
    {
        return view('academic.curso.livewire.curso-component', [
            'tableMode' => 'client',
            'rows' => $this->freshRows($useCase),
        ]);
    }

    private function renderServerMode(ListCursosUseCase $useCase): View
    {
        $result = $useCase->paginate(search: $this->authorizedSearch(), perPage: $this->perPage, page: $this->page, sortBy: $this->sortKey, sortDir: $this->sortDir);
        $paginator = new LengthAwarePaginator(items: $result['items'], total: $result['total'], perPage: $this->perPage, currentPage: $this->page);

        return view('academic.curso.livewire.curso-component', ['tableMode' => 'server', 'cursos' => $paginator]);
    }

    private function toRow(Curso $curso): array
    {
        return [
            'id' => $curso->id(),
            'codigo' => $curso->codigo(),
            'nombre' => $curso->nombre(),
            'creditos' => $curso->creditos(),
        ];
    }

    private function freshRows(ListCursosUseCase $useCase): array
    {
        return array_map($this->toRow(...), $useCase->all(sortBy: $this->sortKey, sortDir: $this->sortDir));
    }

    private function exportableRows(ListCursosUseCase $useCase, ?string $search): array
    {
        return array_map($this->toRow(...), $useCase->all(search: $this->authorizedSearch($search), sortBy: $this->sortKey, sortDir: $this->sortDir));
    }

    private function authorizedSearch(?string $explicit = null): ?string
    {
        if (! Auth::user()->can('search', Curso::class)) {
            return null;
        }
        $candidate = filled($explicit) ? $explicit : $this->search;
        return $candidate !== '' ? $candidate : null;
    }

    private function exportHeaders(): array
    {
        return [
            ['key' => 'codigo', 'label' => __('Code')],
            ['key' => 'nombre', 'label' => __('Name')],
            ['key' => 'creditos', 'label' => __('Credits')],
        ];
    }
}