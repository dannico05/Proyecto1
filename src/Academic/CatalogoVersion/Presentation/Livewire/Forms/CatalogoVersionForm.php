<?php

declare(strict_types=1);

namespace Src\Academic\CatalogoVersion\Presentation\Livewire\Forms;

use Illuminate\Validation\Rule;
use Livewire\Form;
use Src\Academic\CatalogoVersion\Application\DTOs\CatalogoVersionDTO;
use Src\Academic\CatalogoVersion\Domain\Entities\CatalogoVersion;
use Src\Academic\CatalogoVersion\Presentation\Livewire\CatalogoVersionComponent;
use DateTimeImmutable;

class CatalogoVersionForm extends Form
{
    public int $carreraId = 0;
    public int $cursoId = 0;
    public int $version = 1;
    public string $acuerdo = '';
    public string $gaceta = '';
    public array $gradosAtinentes = [];
    public string $fechaInicioVigencia = '';
    public ?string $fechaFinVigencia = null;

    public function rules(): array
    {
        /** @var CatalogoVersionComponent $component */
        $component = $this->component;
        
        return [
            'carreraId' => ['required', 'integer', 'exists:carreras,id'],
            'cursoId' => ['required', 'integer', 'exists:cursos,id'],
            'version' => ['required', 'integer', 'min:1'],
            'acuerdo' => ['required', 'string', 'max:100'],
            'gaceta' => ['required', 'string', 'max:100'],
            'gradosAtinentes' => ['required', 'array', 'min:1'],
            'gradosAtinentes.*' => ['string', 'max:255'],
            'fechaInicioVigencia' => ['required', 'date'],
            'fechaFinVigencia' => ['nullable', 'date', 'after:fechaInicioVigencia'],
        ];
    }

    public function fromEntity(CatalogoVersion $catalogo): void
    {
        $this->carreraId = $catalogo->carreraId();
        $this->cursoId = $catalogo->cursoId();
        $this->version = $catalogo->version();
        $this->acuerdo = $catalogo->acuerdo();
        $this->gaceta = $catalogo->gaceta();
        $this->gradosAtinentes = $catalogo->gradosAtinentes();
        $this->fechaInicioVigencia = $catalogo->fechaInicioVigencia()->format('Y-m-d');
        $this->fechaFinVigencia = $catalogo->fechaFinVigencia()?->format('Y-m-d');
    }

    public function toDto(): CatalogoVersionDTO
    {
        return new CatalogoVersionDTO(
            carreraId: $this->carreraId,
            cursoId: $this->cursoId,
            version: $this->version,
            acuerdo: $this->acuerdo,
            gaceta: $this->gaceta,
            gradosAtinentes: $this->gradosAtinentes,
            fechaInicioVigencia: new DateTimeImmutable($this->fechaInicioVigencia),
            fechaFinVigencia: $this->fechaFinVigencia ? new DateTimeImmutable($this->fechaFinVigencia) : null,
        );
    }
}