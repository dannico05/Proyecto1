<?php

declare(strict_types=1);

namespace Src\Academic\Atestado\Infrastructure\Persistence\Repositories;

use App\Models\Atestado as AtestadoModel;
use Src\Academic\Atestado\Domain\Contracts\AtestadoRepositoryInterface;
use Src\Academic\Atestado\Domain\Entities\Atestado;

final class EloquentAtestadoRepository implements AtestadoRepositoryInterface
{
    private const SORTABLE_COLUMNS = ['grado', 'institucion', 'anio_obtencion', 'area_especializacion'];

    public function find(int $id): ?Atestado
    {
        $model = AtestadoModel::query()->find($id);
        return $model ? $this->toDomain($model) : null;
    }

    public function all(?string $search = null, ?string $sortBy = null, string $sortDir = 'asc'): array
    {
        $query = AtestadoModel::query()->with('docente');
        if (filled($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('grado', 'like', "%{$search}%")
                    ->orWhere('institucion', 'like', "%{$search}%")
                    ->orWhere('area_especializacion', 'like', "%{$search}%");
            });
        }
        $column = in_array($sortBy, self::SORTABLE_COLUMNS, true) ? $sortBy : 'grado';
        $direction = $sortDir === 'desc' ? 'desc' : 'asc';
        return $query->orderBy($column, $direction)->get()->map($this->toDomain(...))->all();
    }

    public function paginate(?string $search, int $perPage, int $page, ?string $sortBy = null, string $sortDir = 'asc'): array
    {
        $query = AtestadoModel::query()->with('docente');
        if (filled($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('grado', 'like', "%{$search}%")
                    ->orWhere('institucion', 'like', "%{$search}%")
                    ->orWhere('area_especializacion', 'like', "%{$search}%");
            });
        }
        $column = in_array($sortBy, self::SORTABLE_COLUMNS, true) ? $sortBy : 'grado';
        $direction = $sortDir === 'desc' ? 'desc' : 'asc';
        $paginator = $query->orderBy($column, $direction)->paginate(perPage: $perPage, page: $page);
        return [
            'items' => array_map($this->toDomain(...), $paginator->items()),
            'total' => $paginator->total(),
        ];
    }

    public function save(Atestado $atestado): Atestado
    {
        $model = $atestado->id()
            ? AtestadoModel::query()->findOrFail($atestado->id())
            : new AtestadoModel();
        $model->docente_id = $atestado->docenteId();
        $model->grado = $atestado->grado();
        $model->institucion = $atestado->institucion();
        $model->anio_obtencion = $atestado->anioObtencion();
        $model->area_especializacion = $atestado->areaEspecializacion();
        $model->save();
        return $this->toDomain($model);
    }

    public function delete(int $id): void
    {
        AtestadoModel::query()->whereKey($id)->delete();
    }

    private function toDomain(AtestadoModel $model): Atestado
    {
        return Atestado::reconstitute(
            id: $model->id,
            docenteId: $model->docente_id,
            grado: $model->grado,
            institucion: $model->institucion,
            anioObtencion: $model->anio_obtencion,
            areaEspecializacion: $model->area_especializacion,
        );
    }
}