<x-admin-layout title="Añadir Docente" headerText="Módulo de Docentes Universitarios">
    <div class="mb-6">
        <a href="{{ route('admin.docentes.index') }}" class="inline-flex items-center gap-2 text-on-surface-variant hover:text-primary transition-colors text-body-sm mb-2">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Volver al listado
        </a>
        <h2 class="font-display text-headline-md font-bold text-on-surface">Añadir Nuevo Docente</h2>
        <p class="font-body-sm text-on-surface-variant">Registra un nuevo docente universitario con foto, detalles y calificación.</p>
    </div>

    <!-- Form Card -->
    <div class="glass-panel rounded-lg p-6 max-w-lg">
        <form action="{{ route('admin.docentes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Nombre Completo -->
            <div>
                <label for="nombre_completo" class="block text-body-sm font-medium text-on-surface mb-2">Nombre Completo</label>
                <div class="input-focus-ring relative rounded-lg border border-outline-variant bg-surface transition-all">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[20px]">person</span>
                    </div>
                    <input
                        id="nombre_completo"
                        class="w-full rounded-lg border-none bg-transparent py-3 pl-10 pr-3 font-body-sm text-body-sm text-on-surface placeholder:text-on-surface-variant focus:ring-0"
                        type="text"
                        name="nombre_completo"
                        value="{{ old('nombre_completo') }}"
                        placeholder="Ej. Dr. Juan Perez"
                        required
                        autofocus
                    >
                </div>
                <x-input-error :messages="$errors->get('nombre_completo')" class="mt-2" />
            </div>

            <!-- Foto de Perfil -->
            <div>
                <label for="foto_file" class="block text-body-sm font-medium text-on-surface mb-2">Foto de Perfil</label>
                <input
                    id="foto_file"
                    class="block w-full text-body-sm text-on-surface file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-body-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 file:cursor-pointer cursor-pointer border border-outline-variant rounded-lg bg-surface-container-low"
                    type="file"
                    name="foto_file"
                    accept="image/*"
                >
                <p class="text-[10px] text-on-surface-variant mt-1.5">Formatos aceptados: JPEG, PNG, JPG, GIF, WEBP. Tamaño máx: 2MB.</p>
                <x-input-error :messages="$errors->get('foto_file')" class="mt-2" />
            </div>

            <!-- Calificación -->
            <div>
                <label for="calificacion" class="block text-body-sm font-medium text-on-surface mb-2">Calificación (0.00 - 5.00)</label>
                <div class="input-focus-ring relative rounded-lg border border-outline-variant bg-surface transition-all">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[20px]">star</span>
                    </div>
                    <input
                        id="calificacion"
                        class="w-full rounded-lg border-none bg-transparent py-3 pl-10 pr-3 font-body-sm text-body-sm text-on-surface placeholder:text-on-surface-variant focus:ring-0"
                        type="number"
                        step="0.01"
                        min="0"
                        max="5"
                        name="calificacion"
                        value="{{ old('calificacion', '0.00') }}"
                        placeholder="Ej. 4.5"
                        required
                    >
                </div>
                <x-input-error :messages="$errors->get('calificacion')" class="mt-2" />
            </div>

            <!-- Detalles Básicos -->
            <div>
                <label for="detalles_basicos" class="block text-body-sm font-medium text-on-surface mb-2">Detalles Básicos</label>
                <textarea
                    id="detalles_basicos"
                    class="w-full rounded-lg border border-outline-variant bg-surface py-3 px-3 font-body-sm text-body-sm text-on-surface placeholder:text-on-surface-variant focus:border-primary focus:ring-1 focus:ring-primary min-h-[100px]"
                    name="detalles_basicos"
                    placeholder="Detalles sobre su trayectoria, asignaturas dictadas, horarios o recomendaciones..."
                >{{ old('detalles_basicos') }}</textarea>
                <x-input-error :messages="$errors->get('detalles_basicos')" class="mt-2" />
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('admin.docentes.index') }}" class="px-4 py-2 border border-outline-variant text-on-surface-variant hover:bg-surface-variant/40 rounded-DEFAULT text-body-sm font-bold transition-all">
                    Cancelar
                </a>
                <button type="submit" class="px-4 py-2 bg-primary text-on-primary hover:brightness-110 font-bold rounded-DEFAULT text-body-sm transition-all">
                    Registrar Docente
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
