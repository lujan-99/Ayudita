<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QrPayment;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class QrPaymentController extends Controller
{
    /**
     * Display a listing of the QR payments.
     */
    public function index()
    {
        $payments = QrPayment::with('user')
            ->latest()
            ->paginate(15);

        return view('admin.qr_payments.index', compact('payments'));
    }

    /**
     * Approve the specified QR payment.
     */
    public function approve($id)
    {
        $payment = QrPayment::findOrFail($id);

        if ($payment->status !== 'pending') {
            return redirect()->back()->with('error', 'Este pago ya ha sido procesado.');
        }

        $payment->status = 'approved';
        $payment->mensaje_admin = null;
        $payment->save();

        $user = $payment->user;
        
        // Find the premium role
        $premiumRole = Role::where('nombre', 'premium')->first();
        if ($premiumRole) {
            $user->role_id = $premiumRole->id;
        }

        // Determine expiration date based on the plan
        $now = Carbon::now();
        if ($payment->plan === 'mensual') {
            $user->premium_until = $now->addMonth();
        } elseif ($payment->plan === 'semestral') {
            $user->premium_until = $now->addMonths(6);
        } elseif ($payment->plan === 'anual') {
            $user->premium_until = $now->addYear();
        }

        $user->save();

        return redirect()->back()->with('success', "¡Pago aprobado con éxito! El usuario {$user->name} ahora tiene membresía Premium.");
    }

    /**
     * Reject the specified QR payment.
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'mensaje_admin' => 'required|string|max:500',
        ]);

        $payment = QrPayment::findOrFail($id);

        if ($payment->status !== 'pending') {
            return redirect()->back()->with('error', 'Este pago ya ha sido procesado.');
        }

        $payment->status = 'rejected';
        $payment->mensaje_admin = $request->mensaje_admin;
        $payment->save();

        return redirect()->back()->with('warning', "El comprobante de pago fue rechazado. Se notificó al usuario.");
    }
}
