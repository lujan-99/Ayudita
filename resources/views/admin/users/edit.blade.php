<x-admin-layout title="Cambiar Rol de Usuario" headerText="Módulo de Usuarios y Estudiantes">
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-on-surface-variant hover:text-primary transition-colors text-body-sm mb-2">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Volver al listado
        </a>
        <h2 class="font-display text-headline-md font-bold text-on-surface">Cambiar Rol del Usuario</h2>
        <p class="font-body-sm text-on-surface-variant">Modifica los permisos de acceso para <strong>{{ $user->name }}</strong> ({{ $user->email }}).</p>
    </div>

    <!-- Form Card -->
    <div class="glass-panel rounded-lg p-6 max-w-lg">
        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Rol -->
            <div>
                <label for="role_id" class="block text-body-sm font-medium text-on-surface mb-2">Seleccionar Rol</label>
                <div class="input-focus-ring relative rounded-lg border border-outline-variant bg-surface transition-all">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[20px]">manage_accounts</span>
                    </div>
                    <select
                        id="role_id"
                        name="role_id"
                        class="w-full rounded-lg border-none bg-transparent py-3 pl-10 pr-8 font-body-sm text-body-sm text-on-surface placeholder:text-on-surface-variant focus:ring-0 cursor-pointer appearance-none bg-none"
                        required
                    >
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }} class="bg-surface-container text-on-surface">
                                {{ ucfirst($role->nombre) }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-on-surface-variant">
                        <span class="material-symbols-outlined text-sm">arrow_drop_down</span>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
            </div>

            <!-- Warning notice if self-modifying or admin promotion -->
            <div class="p-3 bg-surface-container rounded-lg text-xs text-on-surface-variant flex gap-2">
                <span class="material-symbols-outlined text-sm text-primary">warning</span>
                <span>Al promover a un usuario al rol de <strong>Admin</strong>, este tendrá permisos completos sobre la gestión de todas las tablas de datos del sistema.</span>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border border-outline-variant text-on-surface-variant hover:bg-surface-variant/40 rounded-DEFAULT text-body-sm font-bold transition-all">
                    Cancelar
                </a>
                <button type="submit" class="px-4 py-2 bg-primary text-on-primary hover:brightness-110 font-bold rounded-DEFAULT text-body-sm transition-all">
                    Actualizar Rol
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
