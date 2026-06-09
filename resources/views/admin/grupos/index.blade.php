<x-admin-layout title="Gestionar Grupos Académicos" headerText="Módulo de Grupos y Cátedras">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="font-display text-headline-md font-bold text-on-surface">Grupos Académicos</h2>
            <p class="font-body-sm text-on-surface-variant">Vincular materias con docentes y registrar la calificación del grupo.</p>
        </div>
        <a href="{{ route('admin.grupos.create') }}" class="px-4 py-2 bg-primary text-on-primary hover:brightness-110 font-bold rounded-DEFAULT text-body-sm flex items-center gap-2 transition-all">
            <span class="material-symbols-outlined text-sm">add</span>
            Crear Grupo
        </a>
    </div>

    <!-- Table Card -->
    <div class="glass-panel rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-outline-variant bg-surface-container-low text-on-surface-variant font-label-mono text-[11px] uppercase tracking-wider">
                        <th class="p-4 w-20">ID</th>
                        <th class="p-4">Materia</th>
                        <th class="p-4">Docente</th>
                        <th class="p-4 w-32 text-center">Código de Grupo</th>
                        <th class="p-4 w-40">Calificación Promedio</th>
                        <th class="p-4 w-40 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/30 text-body-sm text-on-surface">
                    @forelse($grupos as $grupo)
                        <tr class="hover:bg-surface-variant/20 transition-colors">
                            <td class="p-4 font-label-mono text-on-surface-variant">{{ $grupo->id }}</td>
                            <td class="p-4">
                                <div class="font-semibold">{{ $grupo->materia->nombre }}</div>
                                <div class="text-[10px] font-label-mono text-primary uppercase tracking-wide">{{ $grupo->materia->codigo }}</div>
                            </td>
                            <td class="p-4 flex items-center gap-3">
                                @if($grupo->docente->foto)
                                    <img src="{{ asset($grupo->docente->foto) }}" alt="{{ $grupo->docente->nombre_completo }}" class="w-8 h-8 rounded-full object-cover border border-outline-variant">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-primary/10 border border-outline-variant flex items-center justify-center text-primary font-bold text-[10px]">
                                        {{ strtoupper(substr($grupo->docente->nombre_completo, 0, 2)) }}
                                    </div>
                                @endif
                                <span class="font-medium text-on-surface">{{ $grupo->docente->nombre_completo }}</span>
                            </td>
                            <td class="p-4 text-center">
                                <span class="px-2.5 py-1 text-xs font-bold font-label-mono bg-surface-container-high border border-outline-variant rounded-lg text-on-surface">
                                    {{ $grupo->grupo_codigo }}
                                </span>
                            </td>
                            <td class="p-4">
                                <div class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-secondary text-[18px] fill-icon">star</span>
                                    <span class="font-bold font-label-mono">{{ number_format($grupo->calificacion, 2) }}</span>
                                    <span class="text-xs text-on-surface-variant">/ 5.00</span>
                                </div>
                            </td>
                            <td class="p-4">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="{{ route('admin.grupos.edit', $grupo) }}" class="text-primary hover:text-primary-container flex items-center gap-1 transition-colors">
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                        Editar
                                    </a>
                                    <form action="{{ route('admin.grupos.destroy', $grupo) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este grupo académico?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-error hover:text-error-container flex items-center gap-1 transition-colors bg-transparent border-none cursor-pointer">
                                            <span class="material-symbols-outlined text-[18px]">delete</span>
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-on-surface-variant">
                                No hay grupos registrados en este momento.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
