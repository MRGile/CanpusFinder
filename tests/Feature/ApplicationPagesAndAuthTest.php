<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ApplicationPagesAndAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_catalog_pages_render_and_unknown_programs_return_not_found(): void
    {
        foreach (['/program-studi', '/blog'] as $path) {
            $this->get($path)->assertOk();
        }

        $this->get('/program-studi/teknik-informatika')->assertNotFound();
    }

    public function test_dashboard_pages_redirect_guests_to_login(): void
    {
        foreach (['/dashboard', '/favorit', '/profil', '/notifikasi', '/pengaturan'] as $path) {
            $this->get($path)->assertRedirect('/masuk');
        }
    }

    public function test_dashboard_pages_render_for_authenticated_users(): void
    {
        $this->actingAs(User::factory()->create());

        foreach (['/dashboard', '/favorit', '/profil', '/notifikasi', '/pengaturan'] as $path) {
            $this->get($path)->assertOk();
        }
    }

    public function test_registration_creates_user_and_starts_authenticated_session(): void
    {
        $response = $this->post('/daftar', [
            'first_name' => 'Rina',
            'last_name' => 'Putri',
            'email' => 'rina@example.test',
            'phone' => '08123456789',
            'password' => 'secure-pass-123',
            'role' => 'admin',
            'agree' => '1',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'name' => 'Rina Putri',
            'email' => 'rina@example.test',
            'phone' => '08123456789',
            'role' => 'pengguna',
        ]);
    }

    public function test_registration_rejects_missing_required_fields(): void
    {
        $response = $this->from('/daftar')->post('/daftar', []);

        $response->assertRedirect('/daftar');
        $response->assertSessionHasErrors(['first_name', 'email', 'password', 'agree']);
        $this->assertGuest();
    }

    public function test_valid_credentials_sign_in_and_logout(): void
    {
        $user = User::factory()->create([
            'email' => 'rina@example.test',
            'password' => Hash::make('secure-pass-123'),
        ]);

        $this->post('/masuk', [
            'email' => $user->email,
            'password' => 'secure-pass-123',
        ])->assertRedirect('/dashboard');

        $this->assertAuthenticatedAs($user);
        $this->get('/profil')->assertOk()->assertSee($user->name);

        $this->post('/keluar')->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_invalid_credentials_do_not_sign_in(): void
    {
        User::factory()->create([
            'email' => 'rina@example.test',
            'password' => Hash::make('secure-pass-123'),
        ]);

        $response = $this->from('/masuk')->post('/masuk', [
            'email' => 'rina@example.test',
            'password' => 'wrong-password',
        ]);

        $response->assertRedirect('/masuk');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
