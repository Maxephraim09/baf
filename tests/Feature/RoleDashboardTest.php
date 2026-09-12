<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_registration_assigns_the_selected_role(): void
    {
        $response = $this->post('/register', [
            'name' => 'New Beneficiary',
            'email' => 'new-beneficiary@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'role' => 'beneficiary',
        ]);

        $response->assertRedirect(route('dashboard', absolute: false));
        $this->assertAuthenticated();
        $this->assertTrue(auth()->user()->hasRole('beneficiary'));
    }

    public function test_public_registration_cannot_create_an_admin(): void
    {
        $this->from('/register')->post('/register', [
            'name' => 'Bad Admin',
            'email' => 'bad-admin@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'role' => 'superadmin',
        ])->assertRedirect('/register')->assertSessionHasErrors('role');
    }

    public function test_each_application_role_reaches_only_its_dashboard(): void
    {
        foreach (['donor', 'volunteer', 'beneficiary'] as $roleName) {
            $user = User::factory()->create();
            $user->assignRole(Role::findOrCreate($roleName, 'web'));

            $this->actingAs($user)->get('/dashboard')
                ->assertOk()
                ->assertSee(ucfirst($roleName) . ' dashboard');

            $this->actingAs($user)->get('/admin/cms')->assertForbidden();
        }
    }

    public function test_only_superadmin_reaches_the_admin_dashboard(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole(Role::findOrCreate('superadmin', 'web'));

        $this->actingAs($admin)->get('/admin')->assertOk();
    }
}