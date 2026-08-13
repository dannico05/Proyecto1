<?php

declare(strict_types=1);

namespace Src\Academic\Carrera\Infrastructure\Persistence\Repositories;

use App\Models\Carrera as CarreraModel;
use Src\Academic\Carrera\Domain\Contracts\CarreraRepositoryInterface;
use Src\Academic\Carrera\Domain\Entities\Carrera;

final class EloquentCarreraRepository implements CarreraRepositoryInterface
{
    private const SORTABLE_COLUMNS = ['codigo', 'nombre'];

    public function find(int $id): ?Carrera
    {
        $model = CarreraModel::query()->find($id);
        return $model ? $this->toDomain($model) : null;
    }

    public function all(?string $search = null, ?string $sortBy = null, string $sortDir = 'asc'): array
    {
        $query = CarreraModel::query();
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
        $query = CarreraModel::query();
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

    public function save(Carrera $carrera): Carrera
    {
        $model = $carrera->id()
            ? CarreraModel::query()->findOrFail($carrera->id())
            : new CarreraModel();
        $model->codigo = $carrera->codigo();
        $model->nombre = $carrera->nombre();
        $model->save();
        return $this->toDomain($model);
    }

    public function delete(int $id): void
    {
        CarreraModel::query()->whereKey($id)->delete();
    }

    private function toDomain(CarreraModel $model): Carrera
    {
        return Carrera::reconstitute(
            id: $model->id,
            codigo: $model->codigo,
            nombre: $model->nombre,
        );
    }
}