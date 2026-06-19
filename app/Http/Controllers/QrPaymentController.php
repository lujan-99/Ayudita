<?php

namespace App\Http\Controllers;

use App\Models\QrPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QrPaymentController extends Controller
{
    /**
     * Store a newly created QR payment request in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'plan' => 'required|string|in:mensual,semestral,anual',
            'monto' => 'required|numeric|min:0',
            'comprobante' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        // Check if there is already a pending payment request
        $existingPending = QrPayment::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if ($existingPending) {
            return redirect()->back()->withErrors([
                'comprobante' => 'Ya tienes un comprobante en revisión. Por favor espera a que el administrador lo apruebe o rechace.'
            ]);
        }

        // Store the receipt image file on the public disk
        $path = $request->file('comprobante')->store('comprobantes', 'public');

        QrPayment::create([
            'user_id' => $user->id,
            'plan' => $request->plan,
            'monto' => $request->monto,
            'comprobante_path' => $path,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', '¡Comprobante subido con éxito! Un administrador lo revisará a la brevedad.');
    }
}
