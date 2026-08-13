<?php

declare(strict_types=1);

namespace Src\Academic\Docente\Presentation\Livewire\Forms;

use Illuminate\Validation\Rule;
use Livewire\Form;
use Src\Academic\Docente\Application\DTOs\DocenteDTO;
use Src\Academic\Docente\Domain\Entities\Docente;
use Src\Academic\Docente\Presentation\Livewire\DocenteComponent;

class DocenteForm extends Form
{
    public string $name = '';
    public string $governmentID = '';
    public string $lastName = '';

    public function rules(): array
    {
        /** @var DocenteComponent $component */
        $component = $this->component;

        return [
            'name' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'governmentID' => [
                'required',
                'string',
                'max:20',
                Rule::unique('docentes', 'cedula')->ignore($component->editingId),
            ],
        ];
    }

    public function fromEntity(Docente $docente): void
    {
        $this->name = $docente->name();
        $this->governmentID = $docente->governmentID();
        $this->lastName = $docente->lastName();
    }

    public function toDto(): DocenteDTO
    {
        return new DocenteDTO(name: $this->name, governmentID: $this->governmentID, lastName: $this->lastName);
    }
}