<x-admin-layout title="Dashboard Admin" headerText="Panel de Control General">
    <div class="mb-6">
        <h2 class="font-display text-headline-lg font-bold text-on-surface mb-2">Bienvenido, {{ Auth::user()->name }}</h2>
        <p class="font-body-sm text-on-surface-variant">Aquí tienes un resumen del estado actual de las tablas de datos.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-bento-gap">
        
        <!-- Carreras Card -->
        <div class="glass-panel rounded-lg p-6 flex flex-col justify-between hover:border-primary/40 transition-all duration-300">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <span class="material-symbols-outlined text-[32px] text-primary">school</span>
                    <span class="font-label-mono text-label-mono text-on-surface-variant uppercase">Carreras</span>
                </div>
                <div class="font-display text-[40px] font-bold text-on-surface leading-none mb-2">{{ $carrerasCount }}</div>
                <p class="text-xs text-on-surface-variant mb-4">Carreras registradas en la facultad.</p>
            </div>
            <a href="{{ route('admin.carreras.index') }}" class="w-full py-2 bg-surface-container border border-outline-variant hover:bg-surface-variant/40 hover:border-primary transition-all text-center rounded-DEFAULT text-body-sm font-bold text-primary block mt-auto">
                Gestionar Carreras
            </a>
        </div>

        <!-- Docentes Card -->
        <div class="glass-panel rounded-lg p-6 flex flex-col justify-between hover:border-primary/40 transition-all duration-300">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <span class="material-symbols-outlined text-[32px] text-primary">groups</span>
                    <span class="font-label-mono text-label-mono text-on-surface-variant uppercase">Docentes</span>
                </div>
                <div class="font-display text-[40px] font-bold text-on-surface leading-none mb-2">{{ $docentesCount }}</div>
                <p class="text-xs text-on-surface-variant mb-4">Docentes registrados en la base de datos.</p>
            </div>
            <a href="{{ route('admin.docentes.index') }}" class="w-full py-2 bg-surface-container border border-outline-variant hover:bg-surface-variant/40 hover:border-primary transition-all text-center rounded-DEFAULT text-body-sm font-bold text-primary block mt-auto">
                Gestionar Docentes
            </a>
        </div>

        <!-- Materias Card -->
        <div class="glass-panel rounded-lg p-6 flex flex-col justify-between hover:border-primary/40 transition-all duration-300">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <span class="material-symbols-outlined text-[32px] text-primary">menu_book</span>
                    <span class="font-label-mono text-label-mono text-on-surface-variant uppercase">Materias</span>
                </div>
                <div class="font-display text-[40px] font-bold text-on-surface leading-none mb-2">{{ $materiasCount }}</div>
                <p class="text-xs text-on-surface-variant mb-4">Materias activas y sus semestres.</p>
            </div>
            <a href="{{ route('admin.materias.index') }}" class="w-full py-2 bg-surface-container border border-outline-variant hover:bg-surface-variant/40 hover:border-primary transition-all text-center rounded-DEFAULT text-body-sm font-bold text-primary block mt-auto">
                Gestionar Materias
            </a>
        </div>

        <!-- Grupos Card -->
        <div class="glass-panel rounded-lg p-6 flex flex-col justify-between hover:border-primary/40 transition-all duration-300">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <span class="material-symbols-outlined text-[32px] text-primary">hub</span>
                    <span class="font-label-mono text-label-mono text-on-surface-variant uppercase">Grupos</span>
                </div>
                <div class="font-display text-[40px] font-bold text-on-surface leading-none mb-2">{{ $gruposCount }}</div>
                <p class="text-xs text-on-surface-variant mb-4">Grupos académicos de materias.</p>
            </div>
            <a href="{{ route('admin.grupos.index') }}" class="w-full py-2 bg-surface-container border border-outline-variant hover:bg-surface-variant/40 hover:border-primary transition-all text-center rounded-DEFAULT text-body-sm font-bold text-primary block mt-auto">
                Gestionar Grupos
            </a>
        </div>

        <!-- Usuarios Card -->
        <div class="glass-panel rounded-lg p-6 flex flex-col justify-between hover:border-primary/40 transition-all duration-300">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <span class="material-symbols-outlined text-[32px] text-primary">person_search</span>
                    <span class="font-label-mono text-label-mono text-on-surface-variant uppercase">Usuarios</span>
                </div>
                <div class="font-display text-[40px] font-bold text-on-surface leading-none mb-2">{{ $usersCount }}</div>
                <p class="text-xs text-on-surface-variant mb-4">Usuarios y estudiantes registrados.</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="w-full py-2 bg-surface-container border border-outline-variant hover:bg-surface-variant/40 hover:border-primary transition-all text-center rounded-DEFAULT text-body-sm font-bold text-primary block mt-auto">
                Gestionar Usuarios
            </a>
        </div>

        <!-- Pagos QR Card -->
        <div class="glass-panel rounded-lg p-6 flex flex-col justify-between hover:border-primary/40 transition-all duration-300 relative">
            @if($pendingQrPaymentsCount > 0)
                <span class="absolute top-2 right-2 bg-error text-on-error font-bold text-[9px] px-2 py-0.5 rounded-full animate-bounce">
                    {{ $pendingQrPaymentsCount }} Pendientes
                </span>
            @endif
            <div>
                <div class="flex items-center justify-between mb-4">
                    <span class="material-symbols-outlined text-[32px] text-primary">qr_code_scanner</span>
                    <span class="font-label-mono text-label-mono text-on-surface-variant uppercase">Pagos QR</span>
                </div>
                <div class="font-display text-[40px] font-bold text-on-surface leading-none mb-2">{{ $pendingQrPaymentsCount }}</div>
                <p class="text-xs text-on-surface-variant mb-4">Comprobantes de pago cargados por QR.</p>
            </div>
            <a href="{{ route('admin.qr_payments.index') }}" class="w-full py-2 bg-surface-container border border-outline-variant hover:bg-surface-variant/40 hover:border-primary transition-all text-center rounded-DEFAULT text-body-sm font-bold text-primary block mt-auto">
                Validar Pagos
            </a>
        </div>
        
    </div>

    <!-- Quick info / help panel -->
    <div class="glass-panel rounded-lg p-6 mt-8">
        <h3 class="font-display text-headline-md font-bold text-on-surface mb-2 flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">info</span>
            Guía de Uso del Administrador
        </h3>
        <p class="font-body-sm text-on-surface-variant mb-4">
            Este panel administrativo te permite realizar operaciones CRUD (Crear, Leer, Actualizar y Eliminar) sobre los datos de la aplicación. Todo cambio realizado aquí impactará directamente las opciones que visualizan los estudiantes al momento de registrarse y navegar en su Dashboard.
        </p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs text-on-surface-variant">
            <div class="p-3 bg-surface-container rounded-lg">
                <strong class="text-primary block mb-1">Materia &amp; Carrera</strong>
                Las materias dependen de una carrera. Asegúrate de registrar la carrera correspondiente antes de intentar añadir nuevas asignaturas.
            </div>
            <div class="p-3 bg-surface-container rounded-lg">
                <strong class="text-primary block mb-1">Control de Roles</strong>
                En la sección de usuarios puedes asignar roles para promover estudiantes a "Pro" o incluso a otros "Admin", garantizando un acceso total o extendido al sitio.
            </div>
        </div>
    </div>
</x-admin-layout>
