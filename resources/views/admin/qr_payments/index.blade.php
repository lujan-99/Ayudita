<x-admin-layout title="Validación de Pagos QR" headerText="Gestión de Membresías QR">
    <div class="mb-6">
        <h2 class="font-display text-headline-lg font-bold text-on-surface mb-2">Validación de Pagos por QR</h2>
        <p class="font-body-sm text-on-surface-variant">Revisa los comprobantes cargados por los estudiantes y aprueba o rechaza sus solicitudes de membresía Pro.</p>
    </div>

    @if(session('success'))
        <div class="p-4 mb-6 bg-primary/10 border border-primary/20 rounded-xl text-primary text-sm font-semibold">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 mb-6 bg-error/10 border border-error/20 rounded-xl text-error text-sm font-semibold">
            {{ session('error') }}
        </div>
    @endif

    @if(session('warning'))
        <div class="p-4 mb-6 bg-error/10 border border-error/20 rounded-xl text-error text-sm font-semibold">
            {{ session('warning') }}
        </div>
    @endif

    <div class="glass-panel rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-body-sm text-on-surface">
                <thead>
                    <tr class="bg-surface-container border-b border-outline-variant/30 text-on-surface-variant font-display font-semibold select-none">
                        <th class="p-4">Estudiante</th>
                        <th class="p-4">Plan / Monto</th>
                        <th class="p-4">Fecha de Envío</th>
                        <th class="p-4">Comprobante</th>
                        <th class="p-4">Estado</th>
                        <th class="p-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/20">
                    @forelse($payments as $payment)
                        <tr class="hover:bg-surface-container/20 transition-colors">
                            <td class="p-4">
                                <div class="font-bold">{{ $payment->user->name }}</div>
                                <div class="text-xs text-on-surface-variant">{{ $payment->user->email }}</div>
                            </td>
                            <td class="p-4">
                                <div class="font-display font-bold text-primary">{{ ucfirst($payment->plan) }}</div>
                                <div class="text-xs text-on-surface-variant">Bs {{ number_format($payment->monto, 2) }}</div>
                            </td>
                            <td class="p-4">
                                <div>{{ $payment->created_at->format('d/m/Y') }}</div>
                                <div class="text-xs text-on-surface-variant">{{ $payment->created_at->format('H:i') }}</div>
                            </td>
                            <td class="p-4">
                                <a href="{{ asset('storage/' . $payment->comprobante_path) }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs text-primary hover:underline font-bold" title="Abrir en pestaña nueva">
                                    <span class="material-symbols-outlined text-[16px]">image</span>
                                    Ver Imagen
                                </a>
                            </td>
                            <td class="p-4">
                                @if($payment->status === 'pending')
                                    <span class="px-2.5 py-0.5 rounded text-[10px] font-bold bg-amber-500/10 text-amber-500 border border-amber-500/20 uppercase tracking-wider">Pendiente</span>
                                @elseif($payment->status === 'approved')
                                    <span class="px-2.5 py-0.5 rounded text-[10px] font-bold bg-primary/10 text-primary border border-primary/20 uppercase tracking-wider">Aprobado</span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded text-[10px] font-bold bg-error/10 text-error border border-error/20 uppercase tracking-wider">Rechazado</span>
                                    @if($payment->mensaje_admin)
                                        <p class="text-[9px] text-error mt-1 max-w-[200px] truncate" title="{{ $payment->mensaje_admin }}">Razón: {{ $payment->mensaje_admin }}</p>
                                    @endif
                                @endif
                            </td>
                            <td class="p-4 text-right">
                                @if($payment->status === 'pending')
                                    <div class="flex items-center justify-end gap-3" x-data="{ openReject: false }">
                                        <!-- Approve Form -->
                                        <form action="{{ route('admin.qr_payments.approve', $payment->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas APROBAR este pago y activar la cuenta Pro?')">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 bg-primary text-on-primary text-xs font-bold rounded-DEFAULT hover:brightness-110 active:scale-[0.98] transition-all cursor-pointer border-0">
                                                Aprobar
                                            </button>
                                        </form>

                                        <!-- Reject Trigger -->
                                        <div class="relative">
                                            <button @click="openReject = !openReject" class="px-3 py-1.5 bg-surface-container border border-outline-variant hover:bg-surface-variant text-xs font-bold rounded-DEFAULT text-on-surface hover:text-error transition-all cursor-pointer">
                                                Rechazar
                                            </button>

                                            <!-- Reject Form Dropdown -->
                                            <div x-show="openReject" @click.outside="openReject = false" x-transition class="absolute right-0 mt-2 p-3 bg-surface-container border border-outline-variant rounded-xl shadow-lg z-50 w-72 text-left space-y-3">
                                                <form action="{{ route('admin.qr_payments.reject', $payment->id) }}" method="POST">
                                                    @csrf
                                                    <label class="block text-[10px] font-semibold text-on-surface-variant uppercase tracking-wider mb-1">Motivo del Rechazo</label>
                                                    <textarea name="mensaje_admin" required placeholder="Ej. Comprobante no visible, monto incorrecto..." class="w-full p-2 bg-surface text-on-surface text-xs border border-outline-variant rounded-lg focus:border-primary focus:outline-none min-h-[60px]"></textarea>
                                                    <div class="flex justify-end gap-2 mt-2">
                                                        <button type="button" @click="openReject = false" class="px-2 py-1 text-[10px] bg-surface-container border border-outline-variant rounded text-on-surface hover:bg-surface-variant cursor-pointer">
                                                            Cancelar
                                                        </button>
                                                        <button type="submit" class="px-2 py-1 text-[10px] bg-error text-on-error rounded hover:brightness-110 font-bold cursor-pointer border-0">
                                                            Confirmar
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-xs text-on-surface-variant select-none">Procesado</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-on-surface-variant select-none">
                                <span class="material-symbols-outlined text-[48px] text-primary/50 mb-2">qr_code_2</span>
                                <h3 class="font-display font-semibold text-on-surface">No se encontraron pagos por QR</h3>
                                <p class="text-xs mt-1">Los comprobantes cargados por los estudiantes aparecerán listados aquí.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($payments->hasPages())
            <div class="p-4 border-t border-outline-variant/30">
                {{ $payments->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
