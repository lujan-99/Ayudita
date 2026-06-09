<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PayPalSubscriptionTest extends TestCase
{
    use RefreshDatabase;

    private Role $freeRole;
    private Role $premiumRole;
    private Role $adminRole;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed roles
        $this->freeRole = Role::create(['nombre' => 'free']);
        $this->premiumRole = Role::create(['nombre' => 'premium']);
        $this->adminRole = Role::create(['nombre' => 'admin']);

        // Set configuration variables for testing
        config(['services.paypal.client_id' => 'test-client-id']);
        config(['services.paypal.secret' => 'test-secret']);
        config(['services.paypal.mode' => 'sandbox']);
    }

    public function test_is_premium_helper_behavior(): void
    {
        // 1. Free user
        $user = User::factory()->create(['role_id' => $this->freeRole->id]);
        $this->assertFalse($user->isPremium());

        // 2. Admin user
        $admin = User::factory()->create(['role_id' => $this->adminRole->id]);
        $this->assertTrue($admin->isPremium());

        // 3. Premium user (active)
        $premiumUser = User::factory()->create([
            'role_id' => $this->premiumRole->id,
            'premium_until' => now()->addDays(5),
        ]);
        $this->assertTrue($premiumUser->isPremium());

        // 4. Premium user (expired) - must auto downgrade
        $expiredUser = User::factory()->create([
            'role_id' => $this->premiumRole->id,
            'premium_until' => now()->subMinutes(10),
        ]);
        
        $this->assertFalse($expiredUser->isPremium());
        $expiredUser->refresh();
        $this->assertEquals($this->freeRole->id, $expiredUser->role_id);
    }

    public function test_paypal_completed_requires_authentication(): void
    {
        $response = $this->postJson(route('paypal.completed'), [
            'orderID' => 'order-123',
            'plan' => 'mensual',
        ]);

        $response->assertStatus(401);
    }

    public function test_paypal_completed_successfully_upgrades_user_mensual(): void
    {
        $user = User::factory()->create(['role_id' => $this->freeRole->id]);

        // Fake PayPal OAuth and Order endpoints
        Http::fake([
            '*/v1/oauth2/token' => Http::response(['access_token' => 'fake-token'], 200),
            '*/v2/checkout/orders/order-123/capture' => Http::response([
                'status' => 'COMPLETED',
                'purchase_units' => [
                    [
                        'payments' => [
                            'captures' => [
                                [
                                    'amount' => [
                                        'currency_code' => 'USD',
                                        'value' => '1.45',
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ], 200),
            '*/v2/checkout/orders/order-123' => Http::response([
                'status' => 'APPROVED',
                'purchase_units' => [
                    [
                        'amount' => [
                            'currency_code' => 'USD',
                            'value' => '1.45',
                        ]
                    ]
                ]
            ], 200),
        ]);

        $response = $this->actingAs($user)->postJson(route('paypal.completed'), [
            'orderID' => 'order-123',
            'plan' => 'mensual',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);

        $user->refresh();
        $this->assertEquals($this->premiumRole->id, $user->role_id);
        $this->assertEquals('order-123', $user->paypal_subscription_id);
        $this->assertNotNull($user->premium_until);
        $this->assertTrue($user->premium_until->isAfter(now()->addDays(28)));
    }

    public function test_paypal_completed_appends_time_for_active_premium_user(): void
    {
        $existingExpiry = now()->addDays(10);
        $user = User::factory()->create([
            'role_id' => $this->premiumRole->id,
            'premium_until' => $existingExpiry,
        ]);

        Http::fake([
            '*/v1/oauth2/token' => Http::response(['access_token' => 'fake-token'], 200),
            '*/v2/checkout/orders/order-999/capture' => Http::response([
                'status' => 'COMPLETED',
                'purchase_units' => [
                    [
                        'payments' => [
                            'captures' => [
                                [
                                    'amount' => [
                                        'currency_code' => 'USD',
                                        'value' => '5.80',
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ], 200),
            '*/v2/checkout/orders/order-999' => Http::response([
                'status' => 'APPROVED',
                'purchase_units' => [
                    [
                        'amount' => [
                            'currency_code' => 'USD',
                            'value' => '5.80',
                        ]
                    ]
                ]
            ], 200),
        ]);

        $response = $this->actingAs($user)->postJson(route('paypal.completed'), [
            'orderID' => 'order-999',
            'plan' => 'semestral',
        ]);

        $response->assertStatus(200);
        $user->refresh();

        // Expire date should be approximately existingExpiry + 6 months
        $expectedExpiry = $existingExpiry->copy()->addMonths(6);
        $this->assertTrue($user->premium_until->diffInMinutes($expectedExpiry) < 5);
    }

    public function test_paypal_completed_validates_currency_and_amounts(): void
    {
        $user = User::factory()->create(['role_id' => $this->freeRole->id]);

        // Wrong currency (EUR)
        Http::fake([
            '*/v1/oauth2/token' => Http::response(['access_token' => 'fake-token'], 200),
            '*/v2/checkout/orders/order-err' => Http::response([
                'status' => 'COMPLETED',
                'purchase_units' => [
                    [
                        'amount' => [
                            'currency_code' => 'EUR',
                            'value' => '1.45',
                        ]
                    ]
                ]
            ], 200),
        ]);

        $response = $this->actingAs($user)->postJson(route('paypal.completed'), [
            'orderID' => 'order-err',
            'plan' => 'mensual',
        ]);

        $response->assertStatus(400);
        $response->assertJsonPath('success', false);
        $response->assertJsonFragment(['message' => 'Moneda no válida.']);

        // Wrong amount for plan
        Http::fake([
            '*/v1/oauth2/token' => Http::response(['access_token' => 'fake-token'], 200),
            '*/v2/checkout/orders/order-amt' => Http::response([
                'status' => 'COMPLETED',
                'purchase_units' => [
                    [
                        'amount' => [
                            'currency_code' => 'USD',
                            'value' => '1.00', // expected 1.45
                        ]
                    ]
                ]
            ], 200),
        ]);

        $response = $this->actingAs($user)->postJson(route('paypal.completed'), [
            'orderID' => 'order-amt',
            'plan' => 'mensual',
        ]);

        $response->assertStatus(400);
        $response->assertJsonPath('success', false);
        $response->assertJsonFragment(['message' => 'El monto pagado no coincide con el plan seleccionado.']);
    }
}
