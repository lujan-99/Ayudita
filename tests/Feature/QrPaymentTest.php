<?php

namespace Tests\Feature;

use App\Models\QrPayment;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class QrPaymentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Seed roles
        Role::create(['nombre' => 'free']);
        Role::create(['nombre' => 'premium']);
        Role::create(['nombre' => 'admin']);
    }

    /** @test */
    public function a_student_can_submit_a_qr_payment_proof()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('premium.qr_payment.store'), [
            'plan' => 'mensual',
            'monto' => 10,
            'comprobante' => UploadedFile::fake()->create('comprobante.jpg', 100),
        ]);

        $response->assertRedirect();
        
        // Verify database entry
        $this->assertDatabaseHas('qr_payments', [
            'user_id' => $user->id,
            'plan' => 'mensual',
            'monto' => 10.00,
            'status' => 'pending',
        ]);

        // Verify storage upload
        $payment = QrPayment::first();
        Storage::disk('public')->assertExists($payment->comprobante_path);
    }

    /** @test */
    public function an_admin_can_approve_a_pending_qr_payment()
    {
        $admin = User::factory()->create();
        $adminRole = Role::where('nombre', 'admin')->first();
        $admin->role_id = $adminRole->id;
        $admin->save();

        $student = User::factory()->create();
        $freeRole = Role::where('nombre', 'free')->first();
        $student->role_id = $freeRole->id;
        $student->save();

        $payment = QrPayment::create([
            'user_id' => $student->id,
            'plan' => 'mensual',
            'monto' => 10.00,
            'comprobante_path' => 'comprobantes/fake.jpg',
            'status' => 'pending',
        ]);

        $this->actingAs($admin);

        $response = $this->post(route('admin.qr_payments.approve', $payment->id));

        $response->assertRedirect();
        
        // Verify payment is approved
        $this->assertEquals('approved', $payment->fresh()->status);

        // Verify student is promoted to premium
        $student = $student->fresh();
        $premiumRole = Role::where('nombre', 'premium')->first();
        $this->assertEquals($premiumRole->id, $student->role_id);
        $this->assertNotNull($student->premium_until);
        $this->assertTrue($student->premium_until->isFuture());
    }

    /** @test */
    public function an_admin_can_reject_a_pending_qr_payment_with_a_reason()
    {
        $admin = User::factory()->create();
        $adminRole = Role::where('nombre', 'admin')->first();
        $admin->role_id = $adminRole->id;
        $admin->save();

        $student = User::factory()->create();

        $payment = QrPayment::create([
            'user_id' => $student->id,
            'plan' => 'mensual',
            'monto' => 10.00,
            'comprobante_path' => 'comprobantes/fake.jpg',
            'status' => 'pending',
        ]);

        $this->actingAs($admin);

        $response = $this->post(route('admin.qr_payments.reject', $payment->id), [
            'mensaje_admin' => 'El comprobante subido es borroso y no se puede leer el número de transacción.',
        ]);

        $response->assertRedirect();
        
        // Verify payment is rejected
        $payment = $payment->fresh();
        $this->assertEquals('rejected', $payment->status);
        $this->assertEquals('El comprobante subido es borroso y no se puede leer el número de transacción.', $payment->mensaje_admin);
        
        // Verify student role remains free
        $this->assertNotEquals(Role::where('nombre', 'premium')->first()->id, $student->fresh()->role_id);
    }
}
