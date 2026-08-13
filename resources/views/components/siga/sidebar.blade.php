<aside class="sidebar" x-persist="sidebar" :class="{ 'mobile-open': mobileOpen, 'collapsed': collapsed }" id="sidebar">
    <div class="logo-row" id="logoRow">
        <div class="logo-wrap" id="logoWrap">
            <img src="{{ asset('images/logo-utn.avif') }}" alt="UTN" class="logo-img">
        </div>
        <div class="logo-text" id="logoText" data-labels>
            <span class="logo-title">{{ __('UTN System') }}</span>
            <span class="logo-sub">{{ __('Academic Management') }}</span>
        </div>
    </div>

    <nav class="nav-scroll">
        <div class="nav-group">
            <span class="nav-label" data-labels>{{ __('MAIN') }}</span>
            <a href="{{ route('dashboard') }}" wire:navigate wire:current="active" class="nav-item">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7" rx="1.5"></rect>
                    <rect x="14" y="3" width="7" height="7" rx="1.5"></rect>
                    <rect x="14" y="14" width="7" height="7" rx="1.5"></rect>
                    <rect x="3" y="14" width="7" height="7" rx="1.5"></rect>
                </svg>
                <span class="nav-text" data-labels>{{ __('Main Panel') }}</span>
            </a>
        </div>

        <div class="nav-group">
            <span class="nav-label" data-labels>{{ __('SYSTEM ADMINISTRATION') }}</span>

            @can('viewAny', \Src\IdentityAccess\Role\Domain\Entities\Role::class)
            <a href="{{ route('identityaccess.role.index') }}" wire:navigate wire:current="active" class="nav-item">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    <path d="M9 12l2 2 4-4"></path>
                </svg>
                <span class="nav-text" data-labels>{{ __('Roles') }}</span>
            </a>
            @endcan

            @can('viewAny', \Src\IdentityAccess\Permission\Domain\Entities\Permission::class)
            <a href="{{ route('identityaccess.permission.index') }}" wire:navigate wire:current="active" class="nav-item">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="10" rx="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
                <span class="nav-text" data-labels>{{ __('Permissions') }}</span>
            </a>
            @endcan
        </div>

        <div class="nav-group">
            <span class="nav-label" data-labels>{{ __('ACADEMIC') }}</span>

            @can('viewAny', \Src\Academic\Docente\Domain\Entities\Docente::class)
            <a href="{{ route('academic.docente.index') }}" wire:navigate wire:current="active" class="nav-item">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"></path>
                    <circle cx="10" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <span class="nav-text" data-labels>{{ __('Teachers') }}</span>
            </a>
            @endcan

            @can('viewAny', \Src\Academic\Curso\Domain\Entities\Curso::class)
            <a href="{{ route('academic.curso.index') }}" wire:navigate wire:current="active" class="nav-item">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                    <path d="M8 7h8"></path>
                    <path d="M8 11h6"></path>
                    <path d="M8 15h4"></path>
                </svg>
                <span class="nav-text" data-labels>{{ __('Courses') }}</span>
            </a>
            @endcan

            @can('viewAny', \Src\Academic\Carrera\Domain\Entities\Carrera::class)
            <a href="{{ route('academic.carrera.index') }}" wire:navigate wire:current="active" class="nav-item">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span class="nav-text" data-labels>{{ __('Careers') }}</span>
            </a>
            @endcan

            @can('viewAny', \Src\Academic\Atestado\Domain\Entities\Atestado::class)
            <a href="{{ route('academic.atestado.index') }}" wire:navigate wire:current="active" class="nav-item">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                    <circle cx="12" cy="11" r="2"></circle>
                    <path d="M10 15c.667-.667 1.333-1 2-1s1.333.333 2 1"></path>
                </svg>
                <span class="nav-text" data-labels>{{ __('Academic records') }}</span>
            </a>
            @endcan

            @can('viewAny', \Src\Academic\CatalogoVersion\Domain\Entities\CatalogoVersion::class)
            <a href="{{ route('academic.catalogo-version.index') }}" wire:navigate wire:current="active" class="nav-item">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
                <span class="nav-text" data-labels>{{ __('Atinence catalog') }}</span>
            </a>
            @endcan
        </div>

        <div class="nav-group">
            <span class="nav-label" data-labels>{{ __('TRACKING') }}</span>

            <a href="#" @click.prevent="setSection('riesgos')" class="nav-item">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 3 2 20h20L12 3z"></path>
                    <line x1="12" y1="9.5" x2="12" y2="14"></line>
                    <circle cx="12" cy="16.7" r="0.9" fill="currentColor" stroke="none"></circle>
                </svg>
                <span class="nav-text" data-labels>{{ __('Risks') }}</span>
            </a>

            <div x-data="{ open: false }" x-on:livewire:navigated.window="open = false">
                <div class="nav-item nav-parent" @click="open = !open; setSection('reportes', currentSub || 'reporte1')">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="8" y1="13" x2="16" y2="13"></line>
                        <line x1="8" y1="17" x2="12" y2="17"></line>
                    </svg>
                    <span class="nav-text" data-labels>{{ __('Reports') }}</span>
                    <svg class="nav-chevron chevron-toggle" :class="{ 'open': open }" data-labels width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </div>
                <div class="nav-children" :class="{ 'open': open }" data-labels>
                    <a href="#" class="nav-child" @click.prevent="setSection('reportes', 'reporte1')">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <polyline points="9 6 15 12 9 18"></polyline>
                        </svg>
                        <span>{{ __('Report 1') }}</span>
                    </a>
                    <a href="#" class="nav-child" @click.prevent="setSection('reportes', 'reporte2')">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <polyline points="9 6 15 12 9 18"></polyline>
                        </svg>
                        <span>{{ __('Report 2') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>
</aside>