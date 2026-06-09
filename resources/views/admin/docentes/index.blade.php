<x-admin-layout title="Gestionar Docentes" headerText="Módulo de Docentes Universitarios">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="font-display text-headline-md font-bold text-on-surface">Docentes</h2>
            <p class="font-body-sm text-on-surface-variant">Listado de docentes y calificaciones académicas.</p>
        </div>
        <a href="{{ route('admin.docentes.create') }}" class="px-4 py-2 bg-primary text-on-primary hover:brightness-110 font-bold rounded-DEFAULT text-body-sm flex items-center gap-2 transition-all">
            <span class="material-symbols-outlined text-sm">add</span>
            Añadir Docente
        </a>
    </div>

    <!-- Table Card -->
    <div class="glass-panel rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-outline-variant bg-surface-container-low text-on-surface-variant font-label-mono text-[11px] uppercase tracking-wider">
                        <th class="p-4 w-20">ID</th>
                        <th class="p-4 w-24">Foto</th>
                        <th class="p-4">Nombre Completo</th>
                        <th class="p-4 w-40">Calificación</th>
                        <th class="p-4">Detalles Básicos</th>
                        <th class="p-4 w-40 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/30 text-body-sm text-on-surface">
                    @forelse($docentes as $docente)
                        <tr class="hover:bg-surface-variant/20 transition-colors">
                            <td class="p-4 font-label-mono text-on-surface-variant">{{ $docente->id }}</td>
                            <td class="p-4">
                                @if($docente->foto)
                                    <img src="{{ asset($docente->foto) }}" alt="{{ $docente->nombre_completo }}" class="w-12 h-12 rounded-full object-cover border border-outline-variant">
                                @else
                                    <div class="w-12 h-12 rounded-full bg-primary/10 border border-outline-variant flex items-center justify-center text-primary font-bold text-sm">
                                        {{ strtoupper(substr($docente->nombre_completo, 0, 2)) }}
                                    </div>
                                @endif
                            </td>
                            <td class="p-4 font-medium">{{ $docente->nombre_completo }}</td>
                            <td class="p-4">
                                <div class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-secondary text-[18px] fill-icon">star</span>
                                    <span class="font-bold font-label-mono">{{ number_format($docente->calificacion, 2) }}</span>
                                    <span class="text-xs text-on-surface-variant">/ 5.00</span>
                                </div>
                            </td>
                            <td class="p-4 text-on-surface-variant max-w-xs truncate">{{ $docente->detalles_basicos ?? 'Sin detalles' }}</td>
                            <td class="p-4">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="{{ route('admin.docentes.edit', $docente) }}" class="text-primary hover:text-primary-container flex items-center gap-1 transition-colors">
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                        Editar
                                    </a>
                                    <form action="{{ route('admin.docentes.destroy', $docente) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este docente? Se perderán las relaciones asociadas.');" class="inline">
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
                                No hay docentes registrados en este momento.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
