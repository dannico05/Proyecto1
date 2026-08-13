<?php

declare(strict_types=1);

namespace Src\Academic\CatalogoVersion\Infrastructure\Persistence\Repositories;

use App\Models\CatalogoVersion as CatalogoVersionModel;
use Src\Academic\CatalogoVersion\Domain\Contracts\CatalogoVersionRepositoryInterface;
use Src\Academic\CatalogoVersion\Domain\Entities\CatalogoVersion;
use DateTimeImmutable;

final class EloquentCatalogoVersionRepository implements CatalogoVersionRepositoryInterface
{
    private const SORTABLE_COLUMNS = ['version', 'acuerdo', 'gaceta', 'fecha_inicio_vigencia'];

    public function find(int $id): ?CatalogoVersion
    {
        $model = CatalogoVersionModel::query()->with(['carrera', 'curso'])->find($id);
        return $model ? $this->toDomain($model) : null;
    }

    public function all(?string $search = null, ?string $sortBy = null, string $sortDir = 'asc'): array
    {
        $query = CatalogoVersionModel::query()->with(['carrera', 'curso']);
        if (filled($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('acuerdo', 'like', "%{$search}%")
                    ->orWhere('gaceta', 'like', "%{$search}%")
                    ->orWhere('grados_atinentes', 'like', "%{$search}%");
            });
        }
        $column = in_array($sortBy, self::SORTABLE_COLUMNS, true) ? $sortBy : 'version';
        $direction = $sortDir === 'desc' ? 'desc' : 'asc';
        return $query->orderBy($column, $direction)->get()->map($this->toDomain(...))->all();
    }

    public function paginate(?string $search, int $perPage, int $page, ?string $sortBy = null, string $sortDir = 'asc'): array
    {
        $query = CatalogoVersionModel::query()->with(['carrera', 'curso']);
        if (filled($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('acuerdo', 'like', "%{$search}%")
                    ->orWhere('gaceta', 'like', "%{$search}%")
                    ->orWhere('grados_atinentes', 'like', "%{$search}%");
            });
        }
        $column = in_array($sortBy, self::SORTABLE_COLUMNS, true) ? $sortBy : 'version';
        $direction = $sortDir === 'desc' ? 'desc' : 'asc';
        $paginator = $query->orderBy($column, $direction)->paginate(perPage: $perPage, page: $page);
        return [
            'items' => array_map($this->toDomain(...), $paginator->items()),
            'total' => $paginator->total(),
        ];
    }

    public function save(CatalogoVersion $catalogo): CatalogoVersion
    {
        $model = $catalogo->id()
            ? CatalogoVersionModel::query()->findOrFail($catalogo->id())
            : new CatalogoVersionModel();
        
        $model->carrera_id = $catalogo->carreraId();
        $model->curso_id = $catalogo->cursoId();
        $model->version = $catalogo->version();
        $model->acuerdo = $catalogo->acuerdo();
        $model->gaceta = $catalogo->gaceta();
        $model->grados_atinentes = json_encode($catalogo->gradosAtinentes());
        $model->fecha_inicio_vigencia = $catalogo->fechaInicioVigencia();
        $model->fecha_fin_vigencia = $catalogo->fechaFinVigencia();
        $model->save();
        
        return $this->toDomain($model);
    }

    public function delete(int $id): void
    {
        CatalogoVersionModel::query()->whereKey($id)->delete();
    }

    private function toDomain(CatalogoVersionModel $model): CatalogoVersion
    {
        return CatalogoVersion::reconstitute(
            id: $model->id,
            carreraId: $model->carrera_id,
            cursoId: $model->curso_id,
            version: $model->version,
            acuerdo: $model->acuerdo,
            gaceta: $model->gaceta,
            gradosAtinentes: json_decode($model->grados_atinentes, true) ?? [],
            fechaInicioVigencia: new DateTimeImmutable($model->fecha_inicio_vigencia),
            fechaFinVigencia: $model->fecha_fin_vigencia ? new DateTimeImmutable($model->fecha_fin_vigencia) : null,
        );
    }
}