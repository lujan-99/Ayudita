<x-admin-layout title="Editar Carrera" headerText="Módulo de Carreras Académicas">
    <div class="mb-6">
        <a href="{{ route('admin.carreras.index') }}" class="inline-flex items-center gap-2 text-on-surface-variant hover:text-primary transition-colors text-body-sm mb-2">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Volver al listado
        </a>
        <h2 class="font-display text-headline-md font-bold text-on-surface">Editar Carrera</h2>
        <p class="font-body-sm text-on-surface-variant">Modifica los detalles de la carrera profesional seleccionada.</p>
    </div>

    <!-- Form Card -->
    <div class="glass-panel rounded-lg p-6 max-w-lg">
        <form action="{{ route('admin.carreras.update', $carrera) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nombre -->
            <div>
                <label for="nombre" class="block text-body-sm font-medium text-on-surface mb-2">Nombre de la Carrera</label>
                <div class="input-focus-ring relative rounded-lg border border-outline-variant bg-surface transition-all">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[20px]">school</span>
                    </div>
                    <input
                        id="nombre"
                        class="w-full rounded-lg border-none bg-transparent py-3 pl-10 pr-3 font-body-sm text-body-sm text-on-surface placeholder:text-on-surface-variant focus:ring-0"
                        type="text"
                        name="nombre"
                        value="{{ old('nombre', $carrera->nombre) }}"
                        placeholder="Ej. Ingeniería de Sistemas"
                        required
                        autofocus
                    >
                </div>
                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('admin.carreras.index') }}" class="px-4 py-2 border border-outline-variant text-on-surface-variant hover:bg-surface-variant/40 rounded-DEFAULT text-body-sm font-bold transition-all">
                    Cancelar
                </a>
                <button type="submit" class="px-4 py-2 bg-primary text-on-primary hover:brightness-110 font-bold rounded-DEFAULT text-body-sm transition-all">
                    Actualizar Carrera
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
