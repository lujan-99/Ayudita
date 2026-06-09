<x-admin-layout title="Gestionar Materias" headerText="Módulo de Materias y Asignaturas">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="font-display text-headline-md font-bold text-on-surface">Materias</h2>
            <p class="font-body-sm text-on-surface-variant">Listado de todas las materias asignadas a carreras.</p>
        </div>
        <a href="{{ route('admin.materias.create') }}" class="px-4 py-2 bg-primary text-on-primary hover:brightness-110 font-bold rounded-DEFAULT text-body-sm flex items-center gap-2 transition-all">
            <span class="material-symbols-outlined text-sm">add</span>
            Añadir Materia
        </a>
    </div>

    <!-- Table Card -->
    <div class="glass-panel rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-outline-variant bg-surface-container-low text-on-surface-variant font-label-mono text-[11px] uppercase tracking-wider">
                        <th class="p-4 w-20">ID</th>
                        <th class="p-4">Código</th>
                        <th class="p-4">Nombre de la Asignatura</th>
                        <th class="p-4">Carrera</th>
                        <th class="p-4 text-center">Semestre</th>
                        <th class="p-4 w-40 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/30 text-body-sm text-on-surface">
                    @forelse($materias as $materia)
                        <tr class="hover:bg-surface-variant/20 transition-colors">
                            <td class="p-4 font-label-mono text-on-surface-variant">{{ $materia->id }}</td>
                            <td class="p-4 font-label-mono">{{ $materia->codigo }}</td>
                            <td class="p-4 font-medium">{{ $materia->nombre }}</td>
                            <td class="p-4 text-on-surface-variant">{{ $materia->carrera->nombre }}</td>
                            <td class="p-4 text-center font-label-mono">{{ $materia->semestre }}°</td>
                            <td class="p-4">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="{{ route('admin.materias.edit', $materia) }}" class="text-primary hover:text-primary-container flex items-center gap-1 transition-colors">
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                        Editar
                                    </a>
                                    <form action="{{ route('admin.materias.destroy', $materia) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta materia? Se perderán las relaciones asociadas.');" class="inline">
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
                                No hay materias registradas en este momento.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
