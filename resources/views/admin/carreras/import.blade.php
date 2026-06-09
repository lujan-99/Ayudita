<x-admin-layout title="Importar Plan" headerText="Importador Masivo de Planes de Estudio">
    <div class="mb-6">
        <a href="{{ route('admin.carreras.index') }}" class="inline-flex items-center gap-2 text-on-surface-variant hover:text-primary transition-colors text-body-sm mb-2">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Volver al listado
        </a>
        <h2 class="font-display text-headline-md font-bold text-on-surface">Importar Plan de Estudios: {{ $carrera->nombre }}</h2>
        <p class="font-body-sm text-on-surface-variant">Importa todas las materias y prerrequisitos a la vez pegando un JSON o subiendo un archivo.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-bento-gap items-start">
        
        <!-- Form Panel -->
        <div class="lg:col-span-7 glass-panel rounded-lg p-6 space-y-6">
            <form action="{{ route('admin.carreras.import.post', $carrera) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Opción 1: Pegar Texto -->
                <div>
                    <label for="json_text" class="block text-body-sm font-medium text-on-surface mb-2">Opción A: Pegar Texto JSON</label>
                    <textarea
                        id="json_text"
                        name="json_text"
                        rows="12"
                        class="w-full rounded-lg border border-outline-variant bg-surface py-3 px-4 font-label-mono text-xs text-on-surface placeholder:text-on-surface-variant focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none"
                        placeholder="[&#10;  {&#10;    &quot;sigla&quot;: &quot;FIS100&quot;,&#10;    &quot;nombre&quot;: &quot;FÍSICA BÁSICA I&quot;,&#10;    &quot;tm&quot;: &quot;N&quot;,&#10;    &quot;curso&quot;: &quot;Curso: 1&quot;,&#10;    &quot;requisitos&quot;: []&#10;  }&#10;]"
                    >{{ old('json_text') }}</textarea>
                </div>

                <div class="relative flex py-2 items-center">
                    <div class="flex-grow border-t border-outline-variant/30"></div>
                    <span class="flex-shrink mx-4 text-xs font-label-mono text-on-surface-variant uppercase">O</span>
                    <div class="flex-grow border-t border-outline-variant/30"></div>
                </div>

                <!-- Opción 2: Subir Archivo -->
                <div>
                    <label for="json_file" class="block text-body-sm font-medium text-on-surface mb-2">Opción B: Subir Archivo (.json)</label>
                    <input
                        type="file"
                        id="json_file"
                        name="json_file"
                        accept=".json"
                        class="w-full text-body-sm text-on-surface-variant file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-body-sm file:font-semibold file:bg-surface-container file:text-primary hover:file:bg-surface-variant cursor-pointer"
                    >
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end gap-3 pt-2">
                    <a href="{{ route('admin.carreras.index') }}" class="px-4 py-2 border border-outline-variant text-on-surface-variant hover:bg-surface-variant/40 rounded-DEFAULT text-body-sm font-bold transition-all">
                        Cancelar
                    </a>
                    <button type="submit" class="px-4 py-2 bg-primary text-on-primary hover:brightness-110 font-bold rounded-DEFAULT text-body-sm transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">cloud_upload</span>
                        Importar de Golpe
                    </button>
                </div>
            </form>
        </div>

        <!-- Help / Example Panel -->
        <div class="lg:col-span-5 glass-panel rounded-lg p-6 space-y-4">
            <h3 class="font-display text-body-lg font-bold text-primary flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">help_outline</span>
                Formato del Archivo
            </h3>
            <p class="text-xs text-on-surface-variant leading-relaxed">
                El importador espera un array de objetos en formato JSON. A continuación, tienes las especificaciones técnicas de cada propiedad:
            </p>
            <ul class="text-xs text-on-surface-variant space-y-2 list-disc list-inside">
                <li><code class="text-primary">sigla</code>: Código único de la materia en esta carrera (ej. <code class="text-on-surface">MAT100</code>).</li>
                <li><code class="text-primary">nombre</code>: Nombre completo de la materia.</li>
                <li><code class="text-primary">tm</code>: Tipo de materia. <code class="text-on-surface">N</code> para Normal, <code class="text-on-surface">O</code> para Optativa.</li>
                <li><code class="text-primary">curso</code>: Cadena de la cual extraeremos el número de semestre (ej. <code class="text-on-surface">Curso: 1</code> equivale al primer semestre).</li>
                <li><code class="text-primary">requisitos</code>: Array con las siglas de las materias prerrequisito (ej. <code class="text-on-surface">["FIS100"]</code>). Estas siglas deben coincidir con otras materias del mismo JSON o ya registradas.</li>
            </ul>

            <div class="pt-4 border-t border-outline-variant/30">
                <h4 class="font-label-mono text-[10px] uppercase text-on-surface-variant mb-2">Ejemplo Completo</h4>
                <pre class="bg-surface-container-lowest p-3 rounded text-[10px] font-label-mono text-on-surface-variant overflow-x-auto max-h-48">[
  {
    "sigla": "FIS100",
    "nombre": "FÍSICA BÁSICA I",
    "tm": "N",
    "curso": "Curso: 1",
    "requisitos": []
  },
  {
    "sigla": "FIS102",
    "nombre": "FÍSICA BÁSICA II",
    "tm": "N",
    "curso": "Curso: 2",
    "requisitos": ["FIS100"]
  }
]</pre>
            </div>
        </div>

    </div>
</x-admin-layout>
