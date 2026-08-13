 .editorconfig => SIGA/.editorconfig                |   0
 SIGA/.env.example                                  |  65 [32m+++++++[m
 .gitattributes => SIGA/.gitattributes              |   0
 {.github => SIGA/.github}/dependabot.yml           |   0
 {.github => SIGA/.github}/workflows/tests.yml      |   0
 .gitignore => SIGA/.gitignore                      |   0
 .npmrc => SIGA/.npmrc                              |   0
 .../app}/Actions/Fortify/CreateNewUser.php         |   0
 .../app}/Actions/Fortify/ResetUserPassword.php     |   0
 .../app}/Concerns/HasRolesAndPermissions.php       |   0
 .../app}/Concerns/PasswordValidationRules.php      |   0
 .../app}/Concerns/ProfileValidationRules.php       |   0
 .../app}/Console/Commands/DDDStructure.php         |   0
 {app => SIGA/app}/Http/Controllers/Controller.php  |   0
 {app => SIGA/app}/Livewire/Actions/Logout.php      |   0
 .../Livewire/Concerns/InteractsWithDataTable.php   |   0
 .../Livewire/Concerns/InteractsWithExports.php     |   0
 {app => SIGA/app}/Models/Permission.php            |   0
 {app => SIGA/app}/Models/Role.php                  |   0
 {app => SIGA/app}/Models/User.php                  |   0
 {app => SIGA/app}/Providers/AppServiceProvider.php |   0
 .../app}/Providers/DomainServiceProvider.php       |  20 [31m---[m
 .../app}/Providers/FortifyServiceProvider.php      |   0
 artisan => SIGA/artisan                            |   0
 {bootstrap => SIGA/bootstrap}/app.php              |   0
 {bootstrap => SIGA/bootstrap}/cache/.gitignore     |   0
 {bootstrap => SIGA/bootstrap}/providers.php        |   0
 composer.json => SIGA/composer.json                |   0
 composer.lock => SIGA/composer.lock                |   0
 {config => SIGA/config}/app.php                    |   0
 {config => SIGA/config}/auth.php                   |   0
 {config => SIGA/config}/cache.php                  |   0
 {config => SIGA/config}/database.php               |   0
 {config => SIGA/config}/filesystems.php            |   0
 {config => SIGA/config}/fortify.php                |   0
 {config => SIGA/config}/logging.php                |   0
 {config => SIGA/config}/mail.php                   |   0
 {config => SIGA/config}/queue.php                  |   0
 {config => SIGA/config}/services.php               |   0
 {config => SIGA/config}/session.php                |   0
 {database => SIGA/database}/.gitignore             |   0
 .../database}/factories/PermissionFactory.php      |   0
 .../database}/factories/RoleFactory.php            |   0
 .../database}/factories/UserFactory.php            |   0
 .../0001_01_01_000000_create_users_table.php       |   0
 .../0001_01_01_000001_create_cache_table.php       |   0
 .../0001_01_01_000002_create_jobs_table.php        |   0
 .../2024_01_01_000000_create_passkeys_table.php    |   0
 ...70933_add_two_factor_columns_to_users_table.php |   0
 .../2026_08_06_174535_create_permissions_table.php |   0
 .../2026_08_06_174631_create_roles_table.php       |   0
 ...6_08_06_174933_create_permission_role_table.php |   0
 .../2026_08_06_175018_create_role_user_table.php   |   0
 ...6_08_06_175223_create_permission_user_table.php |   0
 ...08_06_175513_add_avatar_path_to_users_table.php |   0
 .../database}/seeders/DatabaseSeeder.php           |   0
 .../database}/seeders/PermissionSeeder.php         |   2 [32m+[m[31m-[m
 {database => SIGA/database}/seeders/RoleSeeder.php |   0
 {lang => SIGA/lang}/en/auth.php                    |   0
 {lang => SIGA/lang}/en/pagination.php              |   0
 {lang => SIGA/lang}/en/passwords.php               |   0
 {lang => SIGA/lang}/en/validation.php              |   0
 {lang => SIGA/lang}/es.json                        |  12 [32m+[m[31m-[m
 {lang => SIGA/lang}/es/auth.php                    |   0
 package-lock.json => SIGA/package-lock.json        |   0
 package.json => SIGA/package.json                  |   0
 phpstan.neon => SIGA/phpstan.neon                  |   0
 phpunit.xml => SIGA/phpunit.xml                    |   0
 pint.json => SIGA/pint.json                        |   0
 {public => SIGA/public}/.htaccess                  |   0
 {public => SIGA/public}/apple-touch-icon.png       | Bin
 {public => SIGA/public}/favicon.ico                | Bin
 {public => SIGA/public}/favicon.svg                |   0
 {public => SIGA/public}/images/icons/pdf-icon.svg  |   0
 {public => SIGA/public}/images/icons/xls-icon.svg  |   0
 {public => SIGA/public}/images/logo-utn.avif       | Bin
 {public => SIGA/public}/index.php                  |   0
 {public => SIGA/public}/robots.txt                 |   0
 {resources => SIGA/resources}/css/app.css          |   0
 {resources => SIGA/resources}/js/app.js            |   0
 {resources => SIGA/resources}/js/data-table.js     |   0
 {resources => SIGA/resources}/js/passkeys.js       |   0
 .../views/components/app-logo-icon.blade.php       |   0
 .../resources}/views/components/app-logo.blade.php |   0
 .../views/components/auth-header.blade.php         |   0
 .../views/components/auth-session-status.blade.php |   0
 .../views/components/desktop-user-menu.blade.php   |   0
 .../views/components/layouts/dashboard.blade.php   |   0
 .../components/passkey-registration.blade.php      |   0
 .../views/components/passkey-verify.blade.php      |   0
 .../views/components/placeholder-pattern.blade.php |   0
 .../views/components/siga/auth-card.blade.php      |   0
 .../views/components/siga/footer.blade.php         |   0
 .../views/components/siga/header.blade.php         |   0
 .../views/components/siga/hero.blade.php           |   0
 .../views/components/siga/sidebar.blade.php        |  59 [32m+[m[31m------[m
 .../views/components/siga/topbar.blade.php         |   0
 .../components/ui/confirm-delete-modal.blade.php   |   0
 .../views/components/ui/data-table.blade.php       |   0
 .../resources}/views/components/ui/modal.blade.php |   0
 .../views/components/ui/row-actions.blade.php      |   0
 .../resources}/views/dashboard.blade.php           |   0
 .../resources}/views/errors/403.blade.php          |   0
 .../resources}/views/exports/table-pdf.blade.php   |   0
 .../views/flux/icon/book-open-text.blade.php       |   0
 .../views/flux/icon/chevrons-up-down.blade.php     |   0
 .../views/flux/icon/folder-git-2.blade.php         |   0
 .../views/flux/icon/layout-grid.blade.php          |   0
 .../resources}/views/flux/navlist/group.blade.php  |   0
 .../livewire/permission-component.blade.php        |   0
 .../role/livewire/role-component.blade.php         |   0
 .../resources}/views/layouts/app.blade.php         |   0
 .../resources}/views/layouts/app/header.blade.php  |   0
 .../resources}/views/layouts/app/sidebar.blade.php |   0
 .../resources}/views/layouts/auth.blade.php        |   0
 .../resources}/views/layouts/auth/card.blade.php   |   0
 .../resources}/views/layouts/auth/simple.blade.php |   0
 .../resources}/views/layouts/auth/split.blade.php  |   0
 .../views/pages/auth/confirm-password.blade.php    |   0
 .../views/pages/auth/forgot-password.blade.php     |   0
 .../resources}/views/pages/auth/login.blade.php    |   0
 .../resources}/views/pages/auth/register.blade.php |   0
 .../views/pages/auth/reset-password.blade.php      |   0
 .../pages/auth/two-factor-challenge.blade.php      |   0
 .../views/pages/auth/verify-email.blade.php        |   0
 .../views/pages/settings/layout.blade.php          |   0
 .../\342\232\241recovery-codes.blade.php"          |   0
 .../settings/\342\232\241appearance.blade.php"     |   0
 .../\342\232\241delete-user-form.blade.php"        |   0
 .../\342\232\241delete-user-modal.blade.php"       |   0
 .../pages/settings/\342\232\241profile.blade.php"  |   0
 .../pages/settings/\342\232\241security.blade.php" |   0
 .../\342\232\241two-factor-setup-modal.blade.php"  |   0
 .../resources}/views/partials/head.blade.php       |   0
 .../views/partials/settings-heading.blade.php      |   0
 .../resources}/views/welcome.blade.php             |   0
 {routes => SIGA/routes}/console.php                |   0
 {routes => SIGA/routes}/settings.php               |   0
 {routes => SIGA/routes}/web.php                    |   0
 .../Permission/Application/DTOs/PermissionDTO.php  |   0
 .../UseCases/CreatePermissionUseCase.php           |   0
 .../UseCases/DeletePermissionUseCase.php           |   0
 .../Application/UseCases/FindPermissionUseCase.php |   0
 .../UseCases/ListPermissionsUseCase.php            |   0
 .../UseCases/UpdatePermissionUseCase.php           |   0
 .../Contracts/PermissionRepositoryInterface.php    |   0
 .../Permission/Domain/Entities/Permission.php      |   0
 .../Exceptions/PermissionNotFoundException.php     |   0
 .../Repositories/EloquentPermissionRepository.php  |   0
 .../Presentation/Livewire/Forms/PermissionForm.php |   0
 .../Presentation/Livewire/PermissionComponent.php  |   0
 .../Presentation/Policies/PermissionPolicy.php     |   0
 .../Permission/Presentation/Routes/web.php         |   0
 .../Support/PermissionLabelFormatter.php           |   0
 .../Role/Application/DTOs/RoleDTO.php              |   0
 .../Application/UseCases/CreateRoleUseCase.php     |   0
 .../Application/UseCases/DeleteRoleUseCase.php     |   0
 .../Role/Application/UseCases/FindRoleUseCase.php  |   0
 .../Role/Application/UseCases/ListRolesUseCase.php |   0
 .../Application/UseCases/UpdateRoleUseCase.php     |   0
 .../Domain/Contracts/RoleRepositoryInterface.php   |   0
 .../IdentityAccess/Role/Domain/Entities/Role.php   |   0
 .../Domain/Exceptions/RoleIsProtectedException.php |   0
 .../Domain/Exceptions/RoleNotFoundException.php    |   0
 .../Repositories/EloquentRoleRepository.php        |   0
 .../Role/Presentation/Livewire/Forms/RoleForm.php  |   0
 .../Role/Presentation/Livewire/RoleComponent.php   |   0
 .../Role/Presentation/Policies/RolePolicy.php      |   0
 .../Role/Presentation/Routes/web.php               |   0
 .../Export/Contracts/ExcelExporterInterface.php    |   0
 .../Export/Contracts/PdfExporterInterface.php      |   0
 .../Export/Infrastructure/SpatieExcelExporter.php  |   0
 .../Export/Infrastructure/SpatiePdfExporter.php    |   0
 {storage => SIGA/storage}/app/.gitignore           |   0
 {storage => SIGA/storage}/app/private/.gitignore   |   0
 {storage => SIGA/storage}/app/public/.gitignore    |   0
 {storage => SIGA/storage}/framework/.gitignore     |   0
 .../storage}/framework/cache/.gitignore            |   0
 .../storage}/framework/cache/data/.gitignore       |   0
 .../storage}/framework/sessions/.gitignore         |   0
 .../storage}/framework/testing/.gitignore          |   0
 .../storage}/framework/views/.gitignore            |   0
 {storage => SIGA/storage}/logs/.gitignore          |   0
 {stubs => SIGA/stubs}/ddd/contract.stub            |   0
 {stubs => SIGA/stubs}/ddd/controller.stub          |   0
 {stubs => SIGA/stubs}/ddd/dto.stub                 |   0
 {stubs => SIGA/stubs}/ddd/entity.stub              |   0
 {stubs => SIGA/stubs}/ddd/event.stub               |   0
 {stubs => SIGA/stubs}/ddd/exception.stub           |   0
 {stubs => SIGA/stubs}/ddd/livewire.stub            |   0
 {stubs => SIGA/stubs}/ddd/policy.stub              |   0
 {stubs => SIGA/stubs}/ddd/repository.stub          |   0
 {stubs => SIGA/stubs}/ddd/request.stub             |   0
 {stubs => SIGA/stubs}/ddd/route.stub               |   0
 {stubs => SIGA/stubs}/ddd/use_case.stub            |   0
 {stubs => SIGA/stubs}/ddd/value_object.stub        |   0
 .../tests}/Feature/Auth/AuthenticationTest.php     |   0
 .../tests}/Feature/Auth/EmailVerificationTest.php  |   0
 .../Feature/Auth/PasswordConfirmationTest.php      |   0
 .../tests}/Feature/Auth/PasswordResetTest.php      |   0
 .../tests}/Feature/Auth/RegistrationTest.php       |   0
 .../tests}/Feature/Auth/TwoFactorChallengeTest.php |   0
 {tests => SIGA/tests}/Feature/DashboardTest.php    |   0
 {tests => SIGA/tests}/Feature/ExampleTest.php      |   0
 .../tests}/Feature/Settings/ProfileUpdateTest.php  |   0
 .../tests}/Feature/Settings/SecurityTest.php       |   0
 {tests => SIGA/tests}/TestCase.php                 |   0
 {tests => SIGA/tests}/Unit/ExampleTest.php         |   0
 vite.config.js => SIGA/vite.config.js              |   0
 app/Models/Atestado.php                            |  13 [31m--[m
 app/Models/Carrera.php                             |  13 [31m--[m
 app/Models/CatalogoVersion.php                     |  40 [31m-----[m
 app/Models/Curso.php                               |  13 [31m--[m
 app/Models/Docente.php                             |  13 [31m--[m
 database/factories/AtestadoFactory.php             |  29 [31m---[m
 database/factories/CarreraFactory.php              |  22 [31m---[m
 database/factories/CatalogoVersionFactory.php      |  27 [31m---[m
 database/factories/CursoFactory.php                |  26 [31m---[m
 database/factories/DocenteFactory.php              |  21 [31m---[m
 .../2026_08_04_060542_create_docentes_table.php    |  31 [31m----[m
 .../2026_08_04_060646_create_carreras_table.php    |  29 [31m---[m
 .../2026_08_04_060723_create_cursos_table.php      |  30 [31m----[m
 .../2026_08_04_060749_create_atestados_table.php   |  32 [31m----[m
 ...8_04_060928_create_catalogo_versiones_table.php |  39 [31m----[m
 getNameWithReadWriteType()                         |   0
 isUniqueConstraintError($e))                       |   0
 php                                                |   0
 prepareBindings($bindings)                         |   0
 .../atestado/livewire/atestado-component.blade.php | 123 [31m-------------[m
 .../carrera/livewire/carrera-component.blade.php   |  88 [31m---------[m
 .../livewire/catalogo-version-component.blade.php  | 162 [31m-----------------[m
 .../curso/livewire/curso-component.blade.php       |  97 [31m----------[m
 .../docente/livewire/docente-component.blade.php   | 103 [31m-----------[m
 .../Atestado/Application/DTOs/AtestadoDTO.php      |  28 [31m---[m
 .../Application/UseCases/CreateAtestadoUseCase.php |  26 [31m---[m
 .../Application/UseCases/DeleteAtestadoUseCase.php |  19 [31m--[m
 .../Application/UseCases/FindAtestadoUseCase.php   |  19 [31m--[m
 .../Application/UseCases/ListAtestadosUseCase.php  |  23 [31m---[m
 .../Application/UseCases/UpdateAtestadoUseCase.php |  26 [31m---[m
 .../Contracts/AtestadoRepositoryInterface.php      |  16 [31m--[m
 src/Academic/Atestado/Domain/Entities/Atestado.php |  66 [31m-------[m
 .../Exceptions/AtestadoNotFoundException.php       |  15 [31m--[m
 .../Repositories/EloquentAtestadoRepository.php    |  85 [31m---------[m
 .../Presentation/Livewire/AtestadoComponent.php    | 178 [31m-------------------[m
 .../Presentation/Livewire/Forms/AtestadoForm.php   |  51 [31m------[m
 .../Presentation/Policies/AtestadoPolicy.php       |  20 [31m---[m
 src/Academic/Atestado/Presentation/Routes/web.php  |  10 [31m--[m
 .../Carrera/Application/DTOs/CarreraDTO.php        |  22 [31m---[m
 .../Application/UseCases/CreateCarreraUseCase.php  |  20 [31m---[m
 .../Application/UseCases/DeleteCarreraUseCase.php  |  19 [31m--[m
 .../Application/UseCases/FindCarreraUseCase.php    |  19 [31m--[m
 .../Application/UseCases/ListCarrerasUseCase.php   |  23 [31m---[m
 .../Application/UseCases/UpdateCarreraUseCase.php  |  23 [31m---[m
 .../Contracts/CarreraRepositoryInterface.php       |  16 [31m--[m
 src/Academic/Carrera/Domain/Entities/Carrera.php   |  32 [31m----[m
 .../Domain/Exceptions/CarreraNotFoundException.php |  15 [31m--[m
 .../Repositories/EloquentCarreraRepository.php     |  77 [31m--------[m
 .../Presentation/Livewire/CarreraComponent.php     | 155 [31m----------------[m
 .../Presentation/Livewire/Forms/CarreraForm.php    |  38 [31m----[m
 .../Presentation/Policies/CarreraPolicy.php        |  20 [31m---[m
 src/Academic/Carrera/Presentation/Routes/web.php   |  10 [31m--[m
 .../Application/DTOs/CatalogoVersionDTO.php        |  36 [31m----[m
 .../UseCases/CreateCatalogoVersionUseCase.php      |  29 [31m---[m
 .../UseCases/DeleteCatalogoVersionUseCase.php      |  19 [31m--[m
 .../UseCases/FindCatalogoVersionUseCase.php        |  19 [31m--[m
 .../UseCases/ListCatalogoVersionsUseCase.php       |  23 [31m---[m
 .../UseCases/UpdateCatalogoVersionUseCase.php      |  29 [31m---[m
 .../CatalogoVersionRepositoryInterface.php         |  16 [31m--[m
 .../Domain/Entities/CatalogoVersion.php            |  91 [31m----------[m
 .../CatalogoVersionNotFoundException.php           |  15 [31m--[m
 .../EloquentCatalogoVersionRepository.php          |  94 [31m----------[m
 .../Livewire/CatalogoVersionComponent.php          | 196 [31m---------------------[m
 .../Livewire/Forms/CatalogoVersionForm.php         |  68 [31m-------[m
 .../Policies/CatalogoVersionPolicy.php             |  20 [31m---[m
 .../CatalogoVersion/Presentation/Routes/web.php    |  10 [31m--[m
 src/Academic/Curso/Application/DTOs/CursoDTO.php   |  24 [31m---[m
 .../Application/UseCases/CreateCursoUseCase.php    |  28 [31m---[m
 .../Application/UseCases/DeleteCursoUseCase.php    |  22 [31m---[m
 .../Application/UseCases/FindCursoUseCase.php      |  22 [31m---[m
 .../Application/UseCases/ListCursosUseCase.php     |  33 [31m----[m
 .../Application/UseCases/UpdateCursoUseCase.php    |  29 [31m---[m
 .../Domain/Contracts/CursoRepositoryInterface.php  |  20 [31m---[m
 src/Academic/Curso/Domain/Entities/Curso.php       |  49 [31m------[m
 .../Domain/Exceptions/CursoNotFoundException.php   |  15 [31m--[m
 .../Repositories/EloquentCursoRepository.php       |  88 [31m---------[m
 .../Curso/Presentation/Livewire/CursoComponent.php | 176 [31m------------------[m
 .../Presentation/Livewire/Forms/CursoForm.php      |  51 [31m------[m
 .../Curso/Presentation/Policies/CursoPolicy.php    |  51 [31m------[m
 src/Academic/Curso/Presentation/Routes/web.php     |  10 [31m--[m
 .../Docente/Application/DTOs/DocenteDTO.php        |  33 [31m----[m
 .../Application/UseCases/CreateDocenteUseCase.php  |  35 [31m----[m
 .../Application/UseCases/DeleteDocenteUseCase.php  |  21 [31m---[m
 .../Application/UseCases/FindDocenteUseCase.php    |  21 [31m---[m
 .../Application/UseCases/ListDocentesUseCase.php   |  32 [31m----[m
 .../Application/UseCases/UpdateDocenteUseCase.php  |  35 [31m----[m
 .../Contracts/DocenteRepositoryInterface.php       |  27 [31m---[m
 src/Academic/Docente/Domain/Entities/Docente.php   |  78 [31m--------[m
 .../Domain/Exceptions/DocenteNotFoundException.php |  15 [31m--[m
 .../Repositories/EloquentDocenteRepository.example |  51 [31m------[m
 .../Repositories/EloquentDocenteRepository.php     |  91 [31m----------[m
 .../Presentation/Livewire/DocenteComponent.php     | 169 [31m------------------[m
 .../Presentation/Livewire/Forms/DocenteForm.php    |  47 [31m-----[m
 .../Presentation/Policies/DocentePolicy.php        |  51 [31m------[m
 src/Academic/Docente/Presentation/Routes/web.php   |  10 [31m--[m
 304 files changed, 71 insertions(+), 4108 deletions(-)
