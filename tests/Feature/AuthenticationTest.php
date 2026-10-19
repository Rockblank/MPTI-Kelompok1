<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_each_role_login_page_submits_to_the_authentication_endpoint(): void
    {
        foreach ([
            'anggota.login',
            'bendahara.login',
            'psdi.login',
            'presbem.login',
        ] as $routeName) {
            $response = $this->get(route($routeName));

            $response->assertOk()
                ->assertSee('method="POST"', false)
                ->assertSee('action="'.route('login.post').'"', false)
                ->assertSee('name="_token"', false);
        }
    }

    public function test_users_are_authenticated_and_redirected_to_their_role_dashboard(): void
    {
        $roleDashboards = [
            'anggota' => 'anggota.dashboard',
            'bendahara' => 'bendahara.dashboard',
            'adkeu' => 'bendahara.dashboard',
            'psdi' => 'psdi.dashboard',
            'presbem' => 'presbem.dashboard',
        ];

        foreach ($roleDashboards as $role => $dashboardRoute) {
            $password = 'correct-password';
            $user = User::factory()->create([
                'role' => $role,
                'password' => $password,
            ]);

            $this->post(route('login.post'), [
                'email' => $user->email,
                'password' => $password,
            ])->assertRedirect(route($dashboardRoute));

            $this->assertAuthenticatedAs($user);
            $this->post(route('logout'));
        }
    }

    public function test_a_demo_password_for_another_role_does_not_authenticate_the_user(): void
    {
        $user = User::factory()->create([
            'role' => 'bendahara',
            'password' => 'correct-password',
        ]);

        $this->from(route('bendahara.login'))
            ->post(route('login.post'), [
                'email' => $user->email,
                'password' => 'psdi123',
            ])
            ->assertRedirect(route('bendahara.login'))
            ->assertSessionHas('error');

        $this->assertGuest();
    }

    public function test_users_cannot_access_another_roles_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'anggota']);

        $this->actingAs($user)
            ->withSession(['last_activity_at' => now()->timestamp])
            ->get(route('bendahara.dashboard'))
            ->assertRedirect(route('anggota.dashboard'))
            ->assertSessionHas('error');
    }

    public function test_authenticated_user_can_log_out_using_post(): void
    {
        $user = User::factory()->create(['role' => 'anggota']);

        $this->actingAs($user)
            ->withSession(['last_activity_at' => now()->timestamp])
            ->post(route('logout'))
            ->assertRedirect(route('anggota.login'))
            ->assertSessionHas('success');

        $this->assertGuest();
    }

    public function test_logout_does_not_accept_get_requests(): void
    {
        $this->get(route('logout'))->assertMethodNotAllowed();
    }

    public function test_inactive_user_is_logged_out_after_idle_timeout(): void
    {
        $user = User::factory()->create(['role' => 'anggota']);

        $this->actingAs($user)
            ->withSession(['last_activity_at' => now()->subMinutes(31)->timestamp])
            ->get(route('anggota.dashboard'))
            ->assertRedirect(route('anggota.login'))
            ->assertSessionHas('error', 'Sesi Anda berakhir karena tidak aktif. Silakan masuk kembali.');

        $this->assertGuest();
    }

    public function test_authenticated_activity_refreshes_idle_timer(): void
    {
        $user = User::factory()->create(['role' => 'anggota']);

        $this->actingAs($user)
            ->withSession(['last_activity_at' => now()->subMinutes(29)->timestamp])
            ->get(route('anggota.dashboard'))
            ->assertOk()
            ->assertSessionHas('last_activity_at', now()->timestamp);
    }
}
