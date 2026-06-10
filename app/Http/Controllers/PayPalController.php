<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PayPalController extends Controller
{
    public function completed(Request $request)
    {
        $request->validate([
            'orderID' => 'required|string',
            'plan' => 'required|string|in:mensual,semestral,anual',
        ]);

        $orderId = $request->input('orderID');
        $planKey = $request->input('plan');

        $plans = [
            'mensual' => [
                'price' => 1.00,
                'months' => 1,
            ],
            'semestral' => [
                'price' => 4.00,
                'months' => 6,
            ],
            'anual' => [
                'price' => 7.00,
                'months' => 12,
            ],
        ];

        $selectedPlan = $plans[$planKey];

        // 1. Authenticate with PayPal REST API
        $mode = config('services.paypal.mode', 'sandbox');
        $baseUrl = $mode === 'live' ? 'https://api-m.paypal.com' : 'https://api-m.sandbox.paypal.com';
        $clientId = config('services.paypal.client_id');
        $secret = config('services.paypal.secret');

        if (empty($clientId) || empty($secret)) {
            Log::error('PayPal credentials are not configured.');
            return response()->json(['success' => false, 'message' => 'Configuración de PayPal incompleta.'], 500);
        }

        $tokenResponse = Http::asForm()
            ->withBasicAuth($clientId, $secret)
            ->post("{$baseUrl}/v1/oauth2/token", [
                'grant_type' => 'client_credentials',
            ]);

        if ($tokenResponse->failed()) {
            Log::error('PayPal auth token request failed', ['response' => $tokenResponse->body()]);
            return response()->json(['success' => false, 'message' => 'Error de autenticación con PayPal.'], 500);
        }

        $accessToken = $tokenResponse->json()['access_token'] ?? null;

        if (!$accessToken) {
            Log::error('No access token returned from PayPal.');
            return response()->json(['success' => false, 'message' => 'Token de PayPal no válido.'], 500);
        }

        // 2. Fetch order details to verify status and amount
        $orderResponse = Http::withToken($accessToken)
            ->get("{$baseUrl}/v2/checkout/orders/{$orderId}");

        if ($orderResponse->failed()) {
            Log::error('PayPal order fetch failed', ['orderID' => $orderId, 'response' => $orderResponse->body()]);
            return response()->json(['success' => false, 'message' => 'No se pudo verificar la orden.'], 522);
        }

        $orderData = $orderResponse->json();
        $status = $orderData['status'] ?? '';

        // If the order is APPROVED but not CAPTURED yet, we should capture it from the backend.
        // This is extremely safe and recommended by PayPal.
        if ($status === 'APPROVED') {
            $captureResponse = Http::withToken($accessToken)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post("{$baseUrl}/v2/checkout/orders/{$orderId}/capture");

            if ($captureResponse->successful()) {
                $orderData = $captureResponse->json();
                $status = $orderData['status'] ?? '';
            } else {
                Log::error('PayPal order capture from backend failed', ['orderID' => $orderId, 'response' => $captureResponse->body()]);
            }
        }

        if ($status !== 'COMPLETED') {
            Log::warning('PayPal order status is not COMPLETED', ['status' => $status, 'orderID' => $orderId]);
            return response()->json(['success' => false, 'message' => 'El pago no ha sido completado.', 'status' => $status], 400);
        }

        // 3. Verify amount and currency
        $purchaseUnit = $orderData['purchase_units'][0] ?? null;
        if (!$purchaseUnit) {
            Log::error('PayPal order has no purchase units', ['orderData' => $orderData]);
            return response()->json(['success' => false, 'message' => 'Detalle de compra inválido.'], 400);
        }

        $amountValue = floatval($purchaseUnit['payments']['captures'][0]['amount']['value'] ?? $purchaseUnit['amount']['value'] ?? 0);
        $currencyCode = $purchaseUnit['payments']['captures'][0]['amount']['currency_code'] ?? $purchaseUnit['amount']['currency_code'] ?? '';

        if (strtoupper($currencyCode) !== 'USD') {
            Log::warning('PayPal order currency mismatch', ['currency' => $currencyCode, 'expected' => 'USD']);
            return response()->json(['success' => false, 'message' => 'Moneda no válida.'], 400);
        }

        // Allow some float discrepancy tolerance (e.g. check difference < 0.05)
        if (abs($amountValue - $selectedPlan['price']) > 0.05) {
            Log::warning('PayPal order amount mismatch', ['received' => $amountValue, 'expected' => $selectedPlan['price']]);
            return response()->json(['success' => false, 'message' => 'El monto pagado no coincide con el plan seleccionado.'], 400);
        }

        // 4. Upgrade user's subscription
        /** @var User $user */
        $user = Auth::user();

        $premiumRoleId = Role::query()->where('nombre', 'premium')->value('id') ?? 2;

        $baseDate = ($user->premium_until && $user->premium_until->isFuture()) 
            ? $user->premium_until 
            : now();

        $user->role_id = $premiumRoleId;
        $user->premium_until = $baseDate->addMonths($selectedPlan['months']);
        $user->paypal_subscription_id = $orderId;
        $user->save();

        Log::info('User upgraded to premium successfully', [
            'user_id' => $user->id,
            'plan' => $planKey,
            'premium_until' => $user->premium_until->toDateTimeString(),
            'order_id' => $orderId
        ]);

        return response()->json([
            'success' => true,
            'message' => '¡Suscripción premium activada con éxito!',
            'premium_until' => $user->premium_until->toDateString(),
        ]);
    }

    public function redeemPoints(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $perfil = $user->perfilEstudiante;
        
        if (!$perfil) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes un perfil de estudiante configurado.'
            ], 400);
        }
        
        if ($perfil->puntos < 10) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes suficientes puntos. Necesitas al menos 10 puntos.'
            ], 400);
        }
        
        // Deduct 10 points
        $perfil->decrement('puntos', 10);
        
        // Activate/extend premium
        $premiumRoleId = Role::query()->where('nombre', 'premium')->value('id') ?? 2;
        
        $baseDate = ($user->premium_until && $user->premium_until->isFuture()) 
            ? $user->premium_until 
            : now();
            
        $user->role_id = $premiumRoleId;
        $user->premium_until = $baseDate->addMonth(); // Add 1 month
        $user->save();
        
        Log::info('User redeemed 10 points for 1 month of premium', [
            'user_id' => $user->id,
            'remaining_puntos' => $perfil->puntos,
            'premium_until' => $user->premium_until->toDateTimeString()
        ]);
        
        return response()->json([
            'success' => true,
            'message' => '¡Canje exitoso! Se han descontado 10 puntos y tu cuenta ha sido actualizada a Pro por 1 mes.',
            'puntos' => $perfil->puntos,
            'premium_until' => $user->premium_until->toDateString()
        ]);
    }
}
