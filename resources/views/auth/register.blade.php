<x-guest-layout title="Registrarse">
    <style>
        [x-cloak] { display: none !important; }
    </style>

    <div class="mb-6 flex justify-start">
        <a href="/" class="inline-flex items-center gap-2 text-xs font-label-mono text-on-surface-variant hover:text-primary transition-colors">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Volver a la landing page
        </a>
    </div>

    <div class="mb-8 text-center">
        <h2 class="mb-2 font-headline-md text-headline-md text-on-surface">Crea tu Cuenta</h2>
        <p class="font-body-sm text-body-sm text-on-surface-variant">Únete a la comunidad de Ayudita y domina el semestre</p>
    </div>

    <form method="POST" action="{{ route('register') }}" x-data="registerWizard()" class="space-y-6" novalidate>
        @csrf

        <!-- Dynamic Hidden inputs for selected subjects -->
        <template x-for="id in selectedMaterias" :key="id">
            <input type="hidden" name="cursando_materias[]" :value="id">
        </template>
        <template x-for="id in selectedMaterias" :key="'group-'+id">
            <input type="hidden" :name="'grupo_materias[' + id + ']'" :value="grupoSelections[id] || ''">
        </template>

        <!-- Step Indicator (Breadcrumbs) -->
        <div class="flex items-center justify-between mb-8 px-1 text-xs font-label-mono select-none border-b border-outline-variant/30 pb-4">
            <div class="flex items-center gap-2">
                <button type="button" @click="step >= 1 ? step = 1 : null" 
                        :class="step === 1 ? 'text-primary font-bold' : (step > 1 ? 'text-on-surface-variant hover:text-primary transition-colors cursor-pointer' : 'text-on-surface-variant/40 cursor-default')" 
                        class="flex items-center gap-1.5 focus:outline-none">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center border text-[10px] transition-colors" :class="step >= 1 ? 'border-primary bg-primary/10 text-primary font-bold' : 'border-outline-variant text-on-surface-variant/40'">1</span>
                    <span>Cuenta</span>
                </button>
            </div>
            <div class="flex-1 h-[1px] bg-outline-variant/30 mx-2"></div>
            <div class="flex items-center gap-2">
                <button type="button" @click="step >= 2 ? step = 2 : null"
                        :class="step === 2 ? 'text-primary font-bold' : (step > 2 ? 'text-on-surface-variant hover:text-primary transition-colors cursor-pointer' : 'text-on-surface-variant/40 cursor-default')" 
                        class="flex items-center gap-1.5 focus:outline-none"
                        :disabled="step < 2">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center border text-[10px] transition-colors" :class="step >= 2 ? 'border-primary bg-primary/10 text-primary font-bold' : 'border-outline-variant text-on-surface-variant/40'">2</span>
                    <span>Materias</span>
                </button>
            </div>
            <div class="flex-1 h-[1px] bg-outline-variant/30 mx-2"></div>
            <div class="flex items-center gap-2">
                <button type="button" @click="step >= 3 ? step = 3 : null"
                        :class="step === 3 ? 'text-primary font-bold' : 'text-on-surface-variant/40 cursor-default'" 
                        class="flex items-center gap-1.5 focus:outline-none"
                        :disabled="step < 3">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center border text-[10px] transition-colors" :class="step >= 3 ? 'border-primary bg-primary/10 text-primary font-bold' : 'border-outline-variant text-on-surface-variant/40'">3</span>
                    <span>Grupos</span>
                </button>
            </div>
        </div>

        <!-- STEP 1: Basic Account Info -->
        <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0" class="space-y-4">
            
            <!-- Nombre -->
            <div>
                <label for="name" class="sr-only">Nombre Completo</label>
                <div class="input-focus-ring relative rounded-lg border border-outline-variant bg-surface transition-all">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[20px]">person</span>
                    </div>
                    <input
                        id="name"
                        class="w-full rounded-lg border-none bg-transparent py-3 pl-10 pr-3 font-body-sm text-body-sm text-on-surface placeholder:text-on-surface-variant focus:ring-0"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Nombre Completo"
                        required
                        autocomplete="name"
                    >
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Correo -->
            <div>
                <label for="email" class="sr-only">Correo electrónico</label>
                <div class="input-focus-ring relative rounded-lg border border-outline-variant bg-surface transition-all">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[20px]">mail</span>
                    </div>
                    <input
                        id="email"
                        class="w-full rounded-lg border-none bg-transparent py-3 pl-10 pr-3 font-body-sm text-body-sm text-on-surface placeholder:text-on-surface-variant focus:ring-0"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="tu@correo.com"
                        required
                        autocomplete="username"
                    >
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Carnet de Identidad -->
            <div>
                <label for="carnet_identidad" class="sr-only">Carnet de Identidad</label>
                <div class="input-focus-ring relative rounded-lg border border-outline-variant bg-surface transition-all">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[20px]">badge</span>
                    </div>
                    <input
                        id="carnet_identidad"
                        class="w-full rounded-lg border-none bg-transparent py-3 pl-10 pr-3 font-body-sm text-body-sm text-on-surface placeholder:text-on-surface-variant focus:ring-0"
                        type="text"
                        name="carnet_identidad"
                        value="{{ old('carnet_identidad') }}"
                        placeholder="Carnet de Identidad"
                        required
                    >
                </div>
                <x-input-error :messages="$errors->get('carnet_identidad')" class="mt-2" />
            </div>

            <!-- Carnet Universitario -->
            <div>
                <label for="carnet_universitario" class="sr-only">Carnet Universitario</label>
                <div class="input-focus-ring relative rounded-lg border border-outline-variant bg-surface transition-all">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[20px]">assignment_ind</span>
                    </div>
                    <input
                        id="carnet_universitario"
                        class="w-full rounded-lg border-none bg-transparent py-3 pl-10 pr-3 font-body-sm text-body-sm text-on-surface placeholder:text-on-surface-variant focus:ring-0"
                        type="text"
                        name="carnet_universitario"
                        value="{{ old('carnet_universitario') }}"
                        placeholder="Carnet Universitario"
                        required
                    >
                </div>
                <x-input-error :messages="$errors->get('carnet_universitario')" class="mt-2" />
            </div>

            <!-- Contraseña -->
            <div>
                <label for="password" class="sr-only">Contraseña</label>
                <div class="input-focus-ring relative rounded-lg border border-outline-variant bg-surface transition-all">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[20px]">lock</span>
                    </div>
                    <input
                        id="password"
                        class="w-full rounded-lg border-none bg-transparent py-3 pl-10 pr-10 font-body-sm text-body-sm text-on-surface placeholder:text-on-surface-variant focus:ring-0"
                        type="password"
                        name="password"
                        placeholder="Contraseña"
                        required
                        autocomplete="new-password"
                    >
                    <button
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-on-surface-variant transition-colors hover:text-primary"
                        onclick="togglePasswordVisibility('password', 'visibility-icon-pass')"
                        type="button"
                        aria-label="Mostrar u ocultar contraseña"
                    >
                        <span class="material-symbols-outlined text-sm" id="visibility-icon-pass">visibility</span>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirmar Contraseña -->
            <div>
                <label for="password_confirmation" class="sr-only">Confirmar Contraseña</label>
                <div class="input-focus-ring relative rounded-lg border border-outline-variant bg-surface transition-all">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[20px]">lock</span>
                    </div>
                    <input
                        id="password_confirmation"
                        class="w-full rounded-lg border-none bg-transparent py-3 pl-10 pr-10 font-body-sm text-body-sm text-on-surface placeholder:text-on-surface-variant focus:ring-0"
                        type="password"
                        name="password_confirmation"
                        placeholder="Confirmar Contraseña"
                        required
                        autocomplete="new-password"
                    >
                    <button
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-on-surface-variant transition-colors hover:text-primary"
                        onclick="togglePasswordVisibility('password_confirmation', 'visibility-icon-confirm')"
                        type="button"
                        aria-label="Mostrar u ocultar contraseña"
                    >
                        <span class="material-symbols-outlined text-sm" id="visibility-icon-confirm">visibility</span>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="pt-2">
                <button type="button" @click="goNext()" class="auth-submit-btn font-body-lg text-body-lg flex items-center justify-center gap-2">
                    Siguiente
                    <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                </button>
            </div>
        </div>

        <!-- STEP 2: Academic Info & Subjects Selection -->
        <div x-show="step === 2" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0" class="space-y-4">
            
            <!-- Carrera -->
            <div>
                <label for="carrera_id" class="sr-only">Carrera</label>
                <div class="input-focus-ring relative rounded-lg border border-outline-variant bg-surface transition-all">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[20px]">school</span>
                    </div>
                    <select
                        id="carrera_id"
                        name="carrera_id"
                        x-model="selectedCarrera"
                        class="w-full rounded-lg border-none bg-transparent py-3 pl-10 pr-8 font-body-sm text-body-sm text-on-surface placeholder:text-on-surface-variant focus:ring-0 cursor-pointer appearance-none bg-none"
                        required
                    >
                        <option value="" disabled class="bg-surface-container text-on-surface">Selecciona tu Carrera</option>
                        @foreach($carreras as $carrera)
                            <option value="{{ $carrera->id }}" class="bg-surface-container text-on-surface">
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

            <!-- Semestre Actual -->
            <div>
                <label for="semestre_actual" class="sr-only">Semestre Actual</label>
                <div class="input-focus-ring relative rounded-lg border border-outline-variant bg-surface transition-all">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-on-surface-variant">
                        <span class="material-symbols-outlined text-[20px]">calendar_month</span>
                    </div>
                    <select
                        id="semestre_actual"
                        name="semestre_actual"
                        x-model="selectedSemestre"
                        class="w-full rounded-lg border-none bg-transparent py-3 pl-10 pr-8 font-body-sm text-body-sm text-on-surface placeholder:text-on-surface-variant focus:ring-0 cursor-pointer appearance-none bg-none"
                        required
                    >
                        <option value="" disabled class="bg-surface-container text-on-surface">Semestre Actual</option>
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" class="bg-surface-container text-on-surface">
                                {{ $i }}° Semestre
                            </option>
                        @endfor
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-on-surface-variant">
                        <span class="material-symbols-outlined text-sm">arrow_drop_down</span>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('semestre_actual')" class="mt-2" />
            </div>

            <!-- FIELD OF SELECTED SUBJECTS (CHIPS) -->
            <div>
                <label class="block text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-2">Materias que estás cursando:</label>
                <div class="p-3 bg-surface-container-low/60 border border-outline-variant rounded-xl min-h-[52px] flex flex-wrap gap-2 items-center">
                    <template x-if="selectedMaterias.length === 0">
                        <span class="text-xs text-on-surface-variant italic">Ninguna materia seleccionada. Marca las materias cursando de la lista inferior.</span>
                    </template>
                    <template x-for="id in selectedMaterias" :key="id">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-primary/15 border border-primary/30 text-primary rounded-full text-xs font-medium transition-all shadow-sm">
                            <span x-text="getMateriaName(id)"></span>
                            <button type="button" @click="removeMateria(id)" class="hover:text-error transition-colors flex items-center justify-center font-bold">
                                <span class="material-symbols-outlined text-xs">close</span>
                            </button>
                        </div>
                    </template>
                </div>
                <x-input-error :messages="$errors->get('cursando_materias')" class="mt-2" />
            </div>

            <!-- SEMESTER FILTER BUTTONS -->
            <div x-show="selectedCarrera" x-transition>
                <label class="block text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-2">Filtrar por Semestre:</label>
                <div class="flex flex-wrap gap-1.5 p-1 bg-surface-container-high/40 border border-outline-variant/40 rounded-xl overflow-x-auto max-w-full">
                    <button type="button" 
                            @click="filterSemester = 'all'"
                            class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all whitespace-nowrap"
                            :class="filterSemester === 'all' ? 'bg-primary text-on-primary shadow-sm' : 'text-on-surface-variant hover:bg-surface-variant/30'">
                        Todos
                    </button>
                    <template x-for="sem in getAvailableSemesters()" :key="sem">
                        <button type="button" 
                                @click="filterSemester = sem"
                                class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all whitespace-nowrap"
                                :class="filterSemester === sem ? 'bg-primary text-on-primary shadow-sm' : 'text-on-surface-variant hover:bg-surface-variant/30'">
                            <span x-text="sem + '° Sem'"></span>
                        </button>
                    </template>
                </div>
            </div>

            <!-- SUBJECT LIST SELECTION -->
            <div x-show="selectedCarrera" x-transition class="space-y-2">
                <label class="block text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Lista de Materias disponibles:</label>
                <div class="max-h-[300px] overflow-y-auto border border-outline-variant/60 rounded-xl p-3 space-y-2 bg-surface-container-lowest/30">
                    <div x-show="isLoading" class="flex items-center justify-center py-6 text-xs text-on-surface-variant">
                        <span class="material-symbols-outlined animate-spin mr-2">sync</span>
                        Cargando materias de la carrera...
                    </div>
                    
                    <template x-for="materia in materias" :key="materia.id">
                        <div x-show="filterSemester === 'all' || filterSemester === materia.semestre"
                             class="flex items-start gap-3 p-3 rounded-lg border transition-all"
                             :class="isLocked(materia.id) 
                                ? 'bg-success/5 border-success/30 opacity-90' 
                                : (selectedMaterias.includes(materia.id) ? 'bg-primary/5 border-primary/30' : 'border-outline-variant/40 hover:bg-surface-variant/20')">
                            
                            <div class="flex items-center h-5">
                                <input type="checkbox"
                                       :id="'check-' + materia.id"
                                       :checked="selectedMaterias.includes(materia.id) || isLocked(materia.id)"
                                       :disabled="isLocked(materia.id)"
                                       @change="toggleMateria(materia.id)"
                                       class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary focus:ring-1 disabled:opacity-60 disabled:bg-success/20 disabled:border-success/40">
                            </div>
                            <div class="text-xs flex-1">
                                <label :for="'check-' + materia.id" class="font-semibold text-on-surface cursor-pointer select-none block" x-text="materia.nombre"></label>
                                <div class="flex gap-2 items-center mt-1 text-[9px] font-label-mono text-on-surface-variant uppercase tracking-wider">
                                    <span x-text="materia.codigo"></span>
                                    <span>•</span>
                                    <span x-text="materia.semestre + '° Semestre'"></span>
                                    <template x-if="isLocked(materia.id)">
                                        <span class="px-1.5 py-0.5 font-bold bg-success/20 text-success border border-success/30 rounded text-[8px] tracking-wide normal-case ml-2">Aprobada (Requisito)</span>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Action buttons -->
            <div class="flex gap-4 pt-4">
                <button type="button" @click="step = 1" class="w-1/3 py-3 border border-outline-variant text-on-surface-variant hover:bg-surface-variant/40 hover:text-on-surface font-bold rounded-lg transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-sm">arrow_back</span>
                    Atrás
                </button>
                <button type="button" @click="goNextToStep3()" class="w-2/3 auth-submit-btn font-body-lg text-body-lg flex items-center justify-center gap-2">
                    Siguiente
                    <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                </button>
            </div>
        </div>

        <!-- STEP 3: Group Selection -->
        <div x-show="step === 3" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0" class="space-y-4">
            <div class="mb-4">
                <label class="block text-xs font-semibold text-on-surface-variant uppercase tracking-wider mb-2">
                    Selecciona el grupo de cada materia cursando:
                </label>
                <p class="text-[11px] text-on-surface-variant/80 mb-4">
                    Para cada una de las materias que estás llevando este semestre, elige el grupo en el cual estás inscrito para asignar el docente correspondiente.
                </p>
            </div>

            <!-- List of Selected Subjects with Groups -->
            <div class="space-y-4 max-h-[350px] overflow-y-auto pr-1 bg-surface-container-lowest/30 border border-outline-variant/30 rounded-xl p-3">
                <template x-for="materiaId in selectedMaterias" :key="materiaId">
                    <div class="p-4 bg-surface-container-low border border-outline-variant/60 rounded-xl space-y-3">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-bold text-on-surface text-sm" x-text="getMateriaName(materiaId)"></h4>
                                <span class="text-[9px] font-label-mono text-on-surface-variant uppercase tracking-wider" x-text="getMateriaCode(materiaId)"></span>
                            </div>
                        </div>

                        <!-- Groups Options -->
                        <div class="space-y-2">
                            <div class="grid grid-cols-1 gap-2">
                                <template x-for="g in getMateriaGroups(materiaId)" :key="g.id">
                                    <div @click="grupoSelections[materiaId] = g.id"
                                         class="flex items-center justify-between p-3 rounded-lg border cursor-pointer transition-all hover:bg-surface-variant/20"
                                         :class="grupoSelections[materiaId] == g.id ? 'bg-primary/5 border-primary/50 text-primary' : 'border-outline-variant/40 text-on-surface'">
                                        <div class="flex items-center gap-3">
                                            <div class="flex items-center justify-center w-4 h-4 rounded-full border"
                                                 :class="grupoSelections[materiaId] == g.id ? 'border-primary bg-primary' : 'border-outline-variant'">
                                                <div x-show="grupoSelections[materiaId] == g.id" class="w-1.5 h-1.5 rounded-full bg-on-primary"></div>
                                            </div>
                                            <div class="text-xs">
                                                <span class="font-bold" x-text="'Grupo ' + g.grupo_codigo"></span>
                                                <div class="text-[10px] text-on-surface-variant mt-0.5" x-text="g.docente ? g.docente.nombre_completo : 'Docente por asignar'"></div>
                                            </div>
                                        </div>
                                        <template x-if="g.docente && g.docente.calificacion">
                                            <div class="flex items-center gap-1 text-[10px] font-bold text-primary">
                                                <span class="material-symbols-outlined text-[12px]">star</span>
                                                <span x-text="parseFloat(g.docente.calificacion).toFixed(2)"></span>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                                <template x-if="getMateriaGroups(materiaId).length === 0">
                                    <div class="text-xs text-on-surface-variant italic p-3 bg-surface-container-high/30 border border-outline-variant/30 rounded-lg">
                                        No hay grupos programados para esta materia.
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>

                <template x-if="selectedMaterias.length === 0">
                    <div class="text-center p-6 border border-outline-variant/40 rounded-xl bg-surface-container-low/40">
                        <span class="material-symbols-outlined text-primary/60 text-[32px] mb-2">info</span>
                        <p class="text-xs text-on-surface-variant italic">
                            No has seleccionado ninguna materia a cursar en el paso anterior. Puedes registrarte directamente.
                        </p>
                    </div>
                </template>
            </div>

            <!-- Action buttons -->
            <div class="flex gap-4 pt-4">
                <button type="button" @click="step = 2" class="w-1/3 py-3 border border-outline-variant text-on-surface-variant hover:bg-surface-variant/40 hover:text-on-surface font-bold rounded-lg transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-sm">arrow_back</span>
                    Atrás
                </button>
                <button type="submit" class="w-2/3 auth-submit-btn font-body-lg text-body-lg">
                    Registrarse
                </button>
            </div>
        </div>
    </form>

    <div class="mt-8 text-center font-body-sm text-body-sm">
        <span class="text-on-surface-variant">¿Ya tienes una cuenta?</span>
        <a class="ml-1 font-medium text-primary transition-colors hover:text-primary-container" href="{{ route('login') }}">
            Inicia sesión
        </a>
    </div>

    @push('scripts')
        <script>
            function togglePasswordVisibility(inputId, iconId) {
                const input = document.getElementById(inputId);
                const icon = document.getElementById(iconId);

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.textContent = 'visibility_off';
                } else {
                    input.type = 'password';
                    icon.textContent = 'visibility';
                }
            }

            function registerWizard() {
                return {
                    // Boots automatically into Step 3 if group_materias had errors, otherwise Step 2 if academic info had errors, otherwise Step 1
                    step: {{ ($errors->has('grupo_materias') || $errors->has('grupo_materias.*')) ? 3 : (($errors->has('carrera_id') || $errors->has('semestre_actual') || $errors->has('cursando_materias')) ? 2 : 1) }},
                    selectedCarrera: '{{ old('carrera_id', '') }}',
                    selectedSemestre: '{{ old('semestre_actual', '') }}',
                    materias: [],
                    selectedMaterias: [],
                    grupoSelections: {},
                    filterSemester: 'all',
                    isLoading: false,

                    init() {
                        if (this.selectedCarrera) {
                            this.fetchMaterias(this.selectedCarrera);
                        }
                        this.$watch('selectedCarrera', (value) => {
                            this.fetchMaterias(value);
                        });
                    },

                    fetchMaterias(carreraId) {
                        if (!carreraId) return;
                        this.isLoading = true;
                        fetch(`/api/carreras/${carreraId}/materias`)
                            .then(r => r.json())
                            .then(data => {
                                this.materias = data;
                                this.isLoading = false;
                            })
                            .catch(err => {
                                console.error(err);
                                this.isLoading = false;
                            });
                    },

                    getAvailableSemesters() {
                        const sems = new Set(this.materias.map(m => m.semestre));
                        return Array.from(sems).sort((a, b) => a - b);
                    },

                    toggleMateria(id) {
                        if (this.isLocked(id)) return;
                        const idx = this.selectedMaterias.indexOf(id);
                        if (idx > -1) {
                            this.selectedMaterias.splice(idx, 1);
                        } else {
                            this.selectedMaterias.push(id);
                        }
                    },

                    removeMateria(id) {
                        this.toggleMateria(id);
                    },

                    getMateriaName(id) {
                        const m = this.materias.find(m => m.id === id);
                        return m ? m.nombre : '';
                    },

                    getPrereqsRecursive(materiaId, visited = new Set()) {
                        const m = this.materias.find(item => item.id === materiaId);
                        if (!m || !m.prerequisitos) return visited;

                        m.prerequisitos.forEach(p => {
                            if (!visited.has(p.id)) {
                                visited.add(p.id);
                                this.getPrereqsRecursive(p.id, visited);
                            }
                        });
                        return visited;
                    },

                    isLocked(id) {
                        for (let selectedId of this.selectedMaterias) {
                            const prereqs = this.getPrereqsRecursive(selectedId);
                            if (prereqs.has(id)) {
                                return true;
                            }
                        }
                        return false;
                    },

                    getMateriaCode(id) {
                        const m = this.materias.find(m => m.id === id);
                        return m ? m.codigo : '';
                    },

                    getMateriaGroups(id) {
                        const m = this.materias.find(m => m.id === id);
                        if (!m) return [];
                        return m.grupos_materia_docente || m.gruposMateriaDocente || [];
                    },

                    goNext() {
                        const name = document.getElementById('name');
                        const email = document.getElementById('email');
                        const ci = document.getElementById('carnet_identidad');
                        const cu = document.getElementById('carnet_universitario');
                        const pass = document.getElementById('password');
                        const passConfirm = document.getElementById('password_confirmation');

                        if (!name.reportValidity() || 
                            !email.reportValidity() || 
                            !ci.reportValidity() || 
                            !cu.reportValidity() || 
                            !pass.reportValidity() || 
                            !passConfirm.reportValidity()) {
                            return;
                        }

                        if (pass.value !== passConfirm.value) {
                            alert('Las contraseñas no coinciden.');
                            return;
                        }

                        this.step = 2;
                    },

                    goNextToStep3() {
                        const carrera = document.getElementById('carrera_id');
                        const semestre = document.getElementById('semestre_actual');

                        if (!carrera.reportValidity() || !semestre.reportValidity()) {
                            return;
                        }

                        // Initialize group selections for any selected materias that don't have one
                        this.selectedMaterias.forEach(id => {
                            if (!this.grupoSelections[id]) {
                                const groups = this.getMateriaGroups(id);
                                if (groups.length > 0) {
                                    // Auto-select the first group as a friendly default
                                    this.grupoSelections[id] = groups[0].id;
                                } else {
                                    this.grupoSelections[id] = '';
                                }
                            }
                        });

                        this.step = 3;
                    }
                };
            }
        </script>
    @endpush
</x-guest-layout>
