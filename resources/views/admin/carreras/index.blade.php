<x-admin-layout title="Gestionar Carreras" headerText="Módulo de Carreras Académicas">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="font-display text-headline-md font-bold text-on-surface">Carreras</h2>
            <p class="font-body-sm text-on-surface-variant">Listado de todas las carreras académicas configuradas.</p>
        </div>
        <a href="{{ route('admin.carreras.create') }}" class="px-4 py-2 bg-primary text-on-primary hover:brightness-110 font-bold rounded-DEFAULT text-body-sm flex items-center gap-2 transition-all">
            <span class="material-symbols-outlined text-sm">add</span>
            Añadir Carrera
        </a>
    </div>

    <!-- Table Card -->
    <div class="glass-panel rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-outline-variant bg-surface-container-low text-on-surface-variant font-label-mono text-[11px] uppercase tracking-wider">
                        <th class="p-4 w-20">ID</th>
                        <th class="p-4">Nombre de la Carrera</th>
                        <th class="p-4">Creado el</th>
                        <th class="p-4 w-40 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/30 text-body-sm text-on-surface">
                    @forelse($carreras as $carrera)
                        <tr class="hover:bg-surface-variant/20 transition-colors">
                            <td class="p-4 font-label-mono text-on-surface-variant">{{ $carrera->id }}</td>
                            <td class="p-4 font-medium">{{ $carrera->nombre }}</td>
                            <td class="p-4 text-on-surface-variant">{{ $carrera->created_at ? $carrera->created_at->format('d/m/Y H:i') : '-' }}</td>
                            <td class="p-4">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="{{ route('admin.carreras.import', $carrera) }}" class="text-primary hover:text-primary-container flex items-center gap-1 transition-colors">
                                        <span class="material-symbols-outlined text-[18px]">upload_file</span>
                                        Importar Plan
                                    </a>
                                    <a href="{{ route('admin.carreras.edit', $carrera) }}" class="text-primary hover:text-primary-container flex items-center gap-1 transition-colors">
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                        Editar
                                    </a>
                                    <form action="{{ route('admin.carreras.destroy', $carrera) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta carrera? Se perderán las relaciones asociadas.');" class="inline">
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
                            <td colspan="4" class="p-8 text-center text-on-surface-variant">
                                No hay carreras registradas en este momento.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
