<x-admin-layout title="Editar Grupo Académico" headerText="Módulo de Grupos y Cátedras">
    <div class="mb-6">
        <a href="{{ route('admin.grupos.index') }}" class="inline-flex items-center gap-2 text-on-surface-variant hover:text-primary transition-colors text-body-sm mb-2">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Volver al listado
        </a>
        <h2 class="font-display text-headline-md font-bold text-on-surface">Editar Grupo Académico</h2>
        <p class="font-body-sm text-on-surface-variant">Modifica los detalles del grupo académico seleccionado.</p>
    </div>

    <!-- Form Card -->
    <div class="glass-panel rounded-lg p-6 max-w-lg">
        <form action="{{ route('admin.grupos.update', $grupo) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Materia -->
            <div>
                <label for="materia_id" class="block text-body-sm font-medium text-on-surface mb-2">Materia / Asignatura</label>
                <select
                    id="materia_id"
                    name="materia_id"
                    class="w-full rounded-lg border border-outline-variant bg-surface py-3 px-3 font-body-sm text-body-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary"
                    required
                >
                    @foreach($materias as $materia)
                        <option value="{{ $materia->id }}" {{ old('materia_id', $grupo->materia_id) == $materia->id ? 'selected' : '' }}>
                            {{ $materia->nombre }} ({{ $materia->codigo }})
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('materia_id')" class="mt-2" />
            </div>

            <!-- Docente (Con buscador en tiempo real) -->
            <div>
                <label for="docente_search" class="block text-body-sm font-medium text-on-surface mb-2">Docente (Escribe para buscar por nombre)</label>
                <div class="space-y-2">
                    <div class="input-focus-ring relative rounded-lg border border-outline-variant bg-surface transition-all">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-on-surface-variant">
                            <span class="material-symbols-outlined text-[20px]">search</span>
                        </div>
                        <input
                            id="docente_search"
                            class="w-full rounded-lg border-none bg-transparent py-2.5 pl-10 pr-3 font-body-sm text-body-sm text-on-surface placeholder:text-on-surface-variant focus:ring-0"
                            type="text"
                            placeholder="Ej. Juan Perez"
                            autocomplete="off"
                        >
                    </div>
                    <select
                        id="docente_select"
                        name="docente_id"
                        class="w-full rounded-lg border border-outline-variant bg-surface py-2 px-3 font-body-sm text-body-sm text-on-surface focus:border-primary focus:ring-1 focus:ring-primary h-40"
                        size="6"
                        required
                    >
                        @foreach($docentes as $docente)
                            <option value="{{ $docente->id }}" {{ old('docente_id', $grupo->docente_id) == $docente->id ? 'selected' : '' }} class="py-1.5 px-2 hover:bg-primary/20 rounded">
                                {{ $docente->nombre_completo }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <x-input-error :messages="$errors->get('docente_id')" class="mt-2" />
            </div>

            <!-- Código de Grupo -->
            <div>
                <label for="grupo_codigo" class="block text-body-sm font-medium text-on-surface mb-2">Código de Grupo (Sigla/Número)</label>
                <div class="input-focus-ring relative rounded-lg border border-outline-variant bg-surface transition-all">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[20px]">tag</span>
                    </div>
                    <input
                        id="grupo_codigo"
                        class="w-full rounded-lg border-none bg-transparent py-3 pl-10 pr-3 font-body-sm text-body-sm text-on-surface placeholder:text-on-surface-variant focus:ring-0"
                        type="text"
                        name="grupo_codigo"
                        value="{{ old('grupo_codigo', $grupo->grupo_codigo) }}"
                        placeholder="Ej. Grupo 1, Grupo A, G-2"
                        required
                    >
                </div>
                <x-input-error :messages="$errors->get('grupo_codigo')" class="mt-2" />
            </div>

            <!-- Calificación Promedio -->
            <div>
                <label for="calificacion" class="block text-body-sm font-medium text-on-surface mb-2">Calificación del Grupo / Recomendación (0.00 - 5.00)</label>
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
                        value="{{ old('calificacion', $grupo->calificacion) }}"
                        placeholder="Ej. 4.2"
                        required
                    >
                </div>
                <x-input-error :messages="$errors->get('calificacion')" class="mt-2" />
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('admin.grupos.index') }}" class="px-4 py-2 border border-outline-variant text-on-surface-variant hover:bg-surface-variant/40 rounded-DEFAULT text-body-sm font-bold transition-all">
                    Cancelar
                </a>
                <button type="submit" class="px-4 py-2 bg-primary text-on-primary hover:brightness-110 font-bold rounded-DEFAULT text-body-sm transition-all">
                    Actualizar Grupo
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const searchInput = document.getElementById('docente_search');
                const selectElement = document.getElementById('docente_select');
                
                if (searchInput && selectElement) {
                    searchInput.addEventListener('input', (e) => {
                        const term = e.target.value.toLowerCase().trim();
                        const options = selectElement.options;
                        
                        for (let i = 0; i < options.length; i++) {
                            const option = options[i];
                            
                            const text = option.text.toLowerCase();
                            if (text.includes(term)) {
                                option.style.display = '';
                            } else {
                                option.style.display = 'none';
                            }
                        }
                    });
                }
            });
        </script>
    @endpush
</x-admin-layout>
