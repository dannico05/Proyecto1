<?php

declare(strict_types=1);

namespace Src\Academic\Carrera\Presentation\Livewire\Forms;

use Illuminate\Validation\Rule;
use Livewire\Form;
use Src\Academic\Carrera\Application\DTOs\CarreraDTO;
use Src\Academic\Carrera\Domain\Entities\Carrera;
use Src\Academic\Carrera\Presentation\Livewire\CarreraComponent;

class CarreraForm extends Form
{
    public string $codigo = '';
    public string $nombre = '';

    public function rules(): array
    {
        /** @var CarreraComponent $component */
        $component = $this->component;
        return [
            'codigo' => ['required', 'string', 'max:20', Rule::unique('carreras', 'codigo')->ignore($component->editingId)],
            'nombre' => ['required', 'string', 'max:255'],
        ];
    }

    public function fromEntity(Carrera $carrera): void
    {
        $this->codigo = $carrera->codigo();
        $this->nombre = $carrera->nombre();
    }

    public function toDto(): CarreraDTO
    {
        return new CarreraDTO(codigo: $this->codigo, nombre: $this->nombre);
    }
}