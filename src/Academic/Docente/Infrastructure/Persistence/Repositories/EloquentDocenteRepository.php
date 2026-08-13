<?php

declare(strict_types=1);

namespace Src\Academic\Docente\Infrastructure\Persistence\Repositories;

use App\Models\Docente as DocenteModel;
use Src\Academic\Docente\Domain\Contracts\DocenteRepositoryInterface;
use Src\Academic\Docente\Domain\Entities\Docente;

final class EloquentDocenteRepository implements DocenteRepositoryInterface
{
    private const SORTABLE_COLUMNS = ['nombre', 'cedula', 'apellido'];

    public function find(int $id): ?Docente
    {
        $model = DocenteModel::query()->find($id);

        return $model ? $this->toDomain($model) : null;
    }

    public function all(?string $search = null, ?string $sortBy = null, string $sortDir = 'asc'): array
    {
        $query = DocenteModel::query();

        if (filled($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('apellido', 'like', "%{$search}%")
                    ->orWhere('cedula', 'like', "%{$search}%");
            });
        }

        $column = in_array($sortBy, self::SORTABLE_COLUMNS, true) ? $sortBy : 'nombre';
        $direction = $sortDir === 'desc' ? 'desc' : 'asc';

        return $query->orderBy($column, $direction)->get()->map($this->toDomain(...))->all();
    }

    public function paginate(?string $search, int $perPage, int $page, ?string $sortBy = null, string $sortDir = 'asc'): array
    {
        $query = DocenteModel::query();

        if (filled($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('apellido', 'like', "%{$search}%")
                    ->orWhere('cedula', 'like', "%{$search}%");
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

    public function save(Docente $docente): Docente
    {
        $model = $docente->id()
            ? DocenteModel::query()->findOrFail($docente->id())
            : new DocenteModel();

        $model->nombre = $docente->name();
        $model->cedula = $docente->governmentID();
        $model->apellido = $docente->lastName();
        $model->save();

        return $this->toDomain($model);
    }

    public function delete(int $id): void
    {
        DocenteModel::query()->whereKey($id)->delete();
    }

    private function toDomain(DocenteModel $model): Docente
    {
        return Docente::reconstitute(
            id: $model->id,
            name: $model->nombre,
            governmentID: $model->cedula,
            lastName: $model->apellido,
        );
    }
}