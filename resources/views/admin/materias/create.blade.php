<x-admin-layout title="Añadir Materia" headerText="Módulo de Materias y Asignaturas">
    <div class="mb-6">
        <a href="{{ route('admin.materias.index') }}" class="inline-flex items-center gap-2 text-on-surface-variant hover:text-primary transition-colors text-body-sm mb-2">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Volver al listado
        </a>
        <h2 class="font-display text-headline-md font-bold text-on-surface">Añadir Nueva Materia</h2>
        <p class="font-body-sm text-on-surface-variant">Registra una nueva materia en una carrera académica específica.</p>
    </div>

    <!-- Form Card -->
    <div class="glass-panel rounded-lg p-6 max-w-lg">
        <form action="{{ route('admin.materias.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Carrera -->
            <div>
                <label for="carrera_id" class="block text-body-sm font-medium text-on-surface mb-2">Carrera Relacionada</label>
                <div class="input-focus-ring relative rounded-lg border border-outline-variant bg-surface transition-all">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[20px]">school</span>
                    </div>
                    <select
                        id="carrera_id"
                        name="carrera_id"
                        class="w-full rounded-lg border-none bg-transparent py-3 pl-10 pr-8 font-body-sm text-body-sm text-on-surface placeholder:text-on-surface-variant focus:ring-0 cursor-pointer appearance-none bg-none"
                        required
                    >
                        <option value="" disabled {{ old('carrera_id') ? '' : 'selected' }} class="bg-surface-container text-on-surface">Selecciona la Carrera</option>
                        @foreach($carreras as $carrera)
                            <option value="{{ $carrera->id }}" {{ old('carrera_id') == $carrera->id ? 'selected' : '' }} class="bg-surface-container text-on-surface">
                                {{ $carrera->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-on-surface-variant">
                        <span class="material-symbols-outlined text-sm">arrow_drop_down</span>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('carrera_id')" class="mt-2" />
            </div>

            <!-- Código -->
            <div>
                <label for="codigo" class="block text-body-sm font-medium text-on-surface mb-2">Código de Asignatura</label>
                <div class="input-focus-ring relative rounded-lg border border-outline-variant bg-surface transition-all">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[20px]">tag</span>
                    </div>
                    <input
                        id="codigo"
                        class="w-full rounded-lg border-none bg-transparent py-3 pl-10 pr-3 font-body-sm text-body-sm text-on-surface placeholder:text-on-surface-variant focus:ring-0"
                        type="text"
                        name="codigo"
                        value="{{ old('codigo') }}"
                        placeholder="Ej. SIS-201"
                        required
                    >
                </div>
                <x-input-error :messages="$errors->get('codigo')" class="mt-2" />
            </div>

            <!-- Nombre -->
            <div>
                <label for="nombre" class="block text-body-sm font-medium text-on-surface mb-2">Nombre de la Materia</label>
                <div class="input-focus-ring relative rounded-lg border border-outline-variant bg-surface transition-all">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[20px]">menu_book</span>
                    </div>
                    <input
                        id="nombre"
                        class="w-full rounded-lg border-none bg-transparent py-3 pl-10 pr-3 font-body-sm text-body-sm text-on-surface placeholder:text-on-surface-variant focus:ring-0"
                        type="text"
                        name="nombre"
                        value="{{ old('nombre') }}"
                        placeholder="Ej. Álgebra Lineal"
                        required
                    >
                </div>
                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
            </div>

            <!-- Semestre -->
            <div>
                <label for="semestre" class="block text-body-sm font-medium text-on-surface mb-2">Semestre Correspondiente</label>
                <div class="input-focus-ring relative rounded-lg border border-outline-variant bg-surface transition-all">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[20px]">calendar_month</span>
                    </div>
                    <select
                        id="semestre"
                        name="semestre"
                        class="w-full rounded-lg border-none bg-transparent py-3 pl-10 pr-8 font-body-sm text-body-sm text-on-surface placeholder:text-on-surface-variant focus:ring-0 cursor-pointer appearance-none bg-none"
                        required
                    >
                        <option value="" disabled {{ old('semestre') ? '' : 'selected' }} class="bg-surface-container text-on-surface">Selecciona el Semestre</option>
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ old('semestre') == $i ? 'selected' : '' }} class="bg-surface-container text-on-surface">
                                {{ $i }}° Semestre
                            </option>
                        @endfor
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-on-surface-variant">
                        <span class="material-symbols-outlined text-sm">arrow_drop_down</span>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('semestre')" class="mt-2" />
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('admin.materias.index') }}" class="px-4 py-2 border border-outline-variant text-on-surface-variant hover:bg-surface-variant/40 rounded-DEFAULT text-body-sm font-bold transition-all">
                    Cancelar
                </a>
                <button type="submit" class="px-4 py-2 bg-primary text-on-primary hover:brightness-110 font-bold rounded-DEFAULT text-body-sm transition-all">
                    Crear Materia
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
