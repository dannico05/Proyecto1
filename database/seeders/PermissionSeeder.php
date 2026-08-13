<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    private const ACTIONS = [
        'create',
        'view',
        'edit',
        'delete',
        'search',
        'export_pdf',
        'export_excel',
    ];

    private const MODULES = [
        'roles',
        'permissions',
        'docentes',
        'cursos',
        'carreras',
        'atestados',
        'catalogo_versiones',
    ];

    public function run(): void
    {
        foreach (self::MODULES as $module) {
            foreach (self::ACTIONS as $action) {
                Permission::query()->firstOrCreate(
                    ['name' => "{$module}.{$action}"],
                    ['module' => $module, 'action' => $action],
                );
            }
        }
    }
}