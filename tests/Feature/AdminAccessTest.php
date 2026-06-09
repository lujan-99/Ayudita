<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    private Role $freeRole;
    private Role $adminRole;

    protected function setUp(): void
    {
        parent::setUp();

        // Create roles for testing
        $this->freeRole = Role::create(['nombre' => 'free']);
        $this->adminRole = Role::create(['nombre' => 'admin']);
    }

    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/login');
    }

    public function test_non_admin_user_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->create([
            'role_id' => $this->freeRole->id,
        ]);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(403);
    }

    public function test_admin_user_can_access_admin_dashboard(): void
    {
        $user = User::factory()->create([
            'role_id' => $this->adminRole->id,
        ]);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Panel de Control General');
    }
}
