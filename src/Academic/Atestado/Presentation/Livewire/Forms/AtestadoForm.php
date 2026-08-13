<?php

declare(strict_types=1);

namespace Src\Academic\Atestado\Presentation\Livewire\Forms;

use Illuminate\Validation\Rule;
use Livewire\Form;
use Src\Academic\Atestado\Application\DTOs\AtestadoDTO;
use Src\Academic\Atestado\Domain\Entities\Atestado;
use Src\Academic\Atestado\Presentation\Livewire\AtestadoComponent;

class AtestadoForm extends Form
{
    public int $docenteId = 0;
    public string $grado = '';
    public string $institucion = '';
    public int $anioObtencion = 2000;
    public string $areaEspecializacion = '';

    public function rules(): array
    {
        return [
            'docenteId' => ['required', 'integer', 'exists:docentes,id'],
            'grado' => ['required', 'string', 'max:50'],
            'institucion' => ['required', 'string', 'max:255'],
            'anioObtencion' => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
            'areaEspecializacion' => ['required', 'string', 'max:255'],
        ];
    }

    public function fromEntity(Atestado $atestado): void
    {
        $this->docenteId = $atestado->docenteId();
        $this->grado = $atestado->grado();
        $this->institucion = $atestado->institucion();
        $this->anioObtencion = $atestado->anioObtencion();
        $this->areaEspecializacion = $atestado->areaEspecializacion();
    }

    public function toDto(): AtestadoDTO
    {
        return new AtestadoDTO(
            docenteId: $this->docenteId,
            grado: $this->grado,
            institucion: $this->institucion,
            anioObtencion: $this->anioObtencion,
            areaEspecializacion: $this->areaEspecializacion,
        );
    }
}