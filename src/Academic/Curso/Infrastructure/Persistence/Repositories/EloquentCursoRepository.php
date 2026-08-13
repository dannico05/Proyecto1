<?php

declare(strict_types=1);

namespace Src\Academic\Curso\Infrastructure\Persistence\Repositories;

use App\Models\Curso as CursoModel;
use Src\Academic\Curso\Domain\Contracts\CursoRepositoryInterface;
use Src\Academic\Curso\Domain\Entities\Curso;

final class EloquentCursoRepository implements CursoRepositoryInterface
{
    private const SORTABLE_COLUMNS = ['codigo', 'nombre', 'creditos'];

    public function find(int $id): ?Curso
    {
        $model = CursoModel::query()->find($id);
        return $model ? $this->toDomain($model) : null;
    }

    public function all(?string $search = null, ?string $sortBy = null, string $sortDir = 'asc'): array
    {
        $query = CursoModel::query();

        if (filled($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                    ->orWhere('nombre', 'like', "%{$search}%");
            });
        }

        $column = in_array($sortBy, self::SORTABLE_COLUMNS, true) ? $sortBy : 'nombre';
        $direction = $sortDir === 'desc' ? 'desc' : 'asc';

        return $query->orderBy($column, $direction)->get()->map($this->toDomain(...))->all();
    }

    public function paginate(?string $search, int $perPage, int $page, ?string $sortBy = null, string $sortDir = 'asc'): array
    {
        $query = CursoModel::query();

        if (filled($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                    ->orWhere('nombre', 'like', "%{$search}%");
            });
        }

        $column = in_array($sortBy, self::SORTABLE_COLUMNS, true) ? $sortBy : 'nombre';
        $direction = $sortDir === 'desc' ? 'desc' : 'asc';

        $paginator = $query->orderBy($column, $direction)->paginate(perPage: $perPage, page: $page);

        return [
            'items' => array_map($this->toDomain(...), $paginator->items()),
            'total' => $paginator->total(),
        ];
    }

    public function save(Curso $curso): Curso
    {
        $model = $curso->id()
            ? CursoModel::query()->findOrFail($curso->id())
            : new CursoModel();

        $model->codigo = $curso->codigo();
        $model->nombre = $curso->nombre();
        $model->creditos = $curso->creditos();
        $model->save();

        return $this->toDomain($model);
    }

    public function delete(int $id): void
    {
        CursoModel::query()->whereKey($id)->delete();
    }

    private function toDomain(CursoModel $model): Curso
    {
        return Curso::reconstitute(
            id: $model->id,
            codigo: $model->codigo,
            nombre: $model->nombre,
            creditos: $model->creditos,
        );
    }
}