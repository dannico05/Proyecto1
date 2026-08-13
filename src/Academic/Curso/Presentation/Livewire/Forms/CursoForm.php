<?php

declare(strict_types=1);

namespace Src\Academic\Curso\Presentation\Livewire\Forms;

use Illuminate\Validation\Rule;
use Livewire\Form;
use Src\Academic\Curso\Application\DTOs\CursoDTO;
use Src\Academic\Curso\Domain\Entities\Curso;
use Src\Academic\Curso\Presentation\Livewire\CursoComponent;

class CursoForm extends Form
{
    public string $codigo = '';
    public string $nombre = '';
    public ?int $creditos = null;

    public function rules(): array
    {
        /** @var CursoComponent $component */
        $component = $this->component;

        return [
            'codigo' => [
                'required',
                'string',
                'max:20',
                Rule::unique('cursos', 'codigo')->ignore($component->editingId),
            ],
            'nombre' => ['required', 'string', 'max:255'],
            'creditos' => ['nullable', 'integer', 'min:1', 'max:10'],
        ];
    }

    public function fromEntity(Curso $curso): void
    {
        $this->codigo = $curso->codigo();
        $this->nombre = $curso->nombre();
        $this->creditos = $curso->creditos();
    }

    public function toDto(): CursoDTO
    {
        return new CursoDTO(
            codigo: $this->codigo,
            nombre: $this->nombre,
            creditos: $this->creditos,
        );
    }
}