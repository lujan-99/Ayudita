<x-admin-layout title="Gestionar Usuarios" headerText="Módulo de Usuarios y Estudiantes">
    <div class="mb-6">
        <h2 class="font-display text-headline-md font-bold text-on-surface">Usuarios</h2>
        <p class="font-body-sm text-on-surface-variant">Listado de todos los estudiantes y administradores en la plataforma.</p>
    </div>

    <!-- Table Card -->
    <div class="glass-panel rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-outline-variant bg-surface-container-low text-on-surface-variant font-label-mono text-[11px] uppercase tracking-wider">
                        <th class="p-4 w-20">ID</th>
                        <th class="p-4">Nombre</th>
                        <th class="p-4">Correo</th>
                        <th class="p-4">Carrera / Semestre</th>
                        <th class="p-4">Rol</th>
                        <th class="p-4 w-40 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/30 text-body-sm text-on-surface">
                    @forelse($users as $user)
                        <tr class="hover:bg-surface-variant/20 transition-colors">
                            <td class="p-4 font-label-mono text-on-surface-variant">{{ $user->id }}</td>
                            <td class="p-4 font-medium">{{ $user->name }}</td>
                            <td class="p-4 font-label-mono text-xs text-on-surface-variant">{{ $user->email }}</td>
                            <td class="p-4">
                                @if($user->perfilEstudiante)
                                    <span class="text-on-surface font-medium">{{ $user->perfilEstudiante->carrera->nombre }}</span>
                                    <span class="text-on-surface-variant block text-xs">{{ $user->perfilEstudiante->semestre_actual }}° Semestre</span>
                                @else
                                    <span class="text-on-surface-variant italic text-xs">Sin perfil (Admin/Docente)</span>
                                @endif
                            </td>
                            <td class="p-4">
                                @if($user->role->nombre === 'admin')
                                    <span class="px-2 py-1 text-[10px] font-bold bg-primary/20 text-primary border border-primary/30 rounded uppercase tracking-wide">Admin</span>
                                @elseif($user->role->nombre === 'premium')
                                    <span class="px-2 py-1 text-[10px] font-bold bg-purple-500/20 text-purple-400 border border-purple-500/30 rounded uppercase tracking-wide">Pro ✨</span>
                                @else
                                    <span class="px-2 py-1 text-[10px] font-bold bg-secondary/20 text-secondary border border-secondary/30 rounded uppercase tracking-wide">Free</span>
                                @endif
                            </td>
                            <td class="p-4">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="text-primary hover:text-primary-container flex items-center gap-1 transition-colors">
                                        <span class="material-symbols-outlined text-[18px]">manage_accounts</span>
                                        Cambiar Rol
                                    </a>
                                    @if($user->id !== Auth::id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este usuario de forma permanente? Se borrará su perfil y toda su información.');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-error hover:text-error-container flex items-center gap-1 transition-colors bg-transparent border-none cursor-pointer">
                                                <span class="material-symbols-outlined text-[18px]">person_remove</span>
                                                Eliminar
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-on-surface-variant">
                                No hay usuarios registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
