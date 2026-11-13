<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_existing_user_can_log_in_with_an_email_and_password(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $this->post(route('login.store'), [
            'identifier' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_login_accepts_any_identifier_and_password_and_creates_a_user(): void
    {
        $this->post(route('login.store'), [
            'identifier' => 'staf bebas #42',
            'password' => 'kata sandi ! bebas',
        ])->assertRedirect(route('dashboard'));

        $user = User::where('name', 'staf bebas #42')->firstOrFail();
        $this->assertSame('user', $user->role);
        $this->assertStringEndsWith('@accounts.ruanggaji.invalid', $user->email);
        $this->assertAuthenticatedAs($user);
        $this->assertTrue(Hash::check('kata sandi ! bebas', $user->password));
    }

    public function test_email_identifier_is_displayed_as_a_name_not_an_email(): void
    {
        $this->post(route('login.store'), [
            'identifier' => 'jane.doe+payroll@example.test',
            'password' => 'any-password',
        ])->assertRedirect(route('dashboard'));

        $user = User::where('email', 'jane.doe+payroll@example.test')->firstOrFail();
        $this->assertSame('Jane Doe', $user->displayName());

        $this->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Jane Doe')
            ->assertDontSee('jane.doe+payroll@example.test');
    }

    public function test_existing_accounts_still_require_the_correct_password(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->post(route('login.store'), [
            'identifier' => $admin->email,
            'password' => 'incorrect-password',
        ])->assertSessionHasErrors('identifier');

        $this->assertGuest();
        $this->assertSame(1, User::where('role', 'admin')->count());
    }

    public function test_admin_can_process_payroll_and_the_result_is_saved_in_session(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->postJson(route('payroll.process'), [
            'period' => 'September 2026',
            'employees' => [
                ['name' => 'Ayu', 'basic_salary' => 5000000, 'allowance' => 500000, 'deduction' => 250000],
                ['name' => 'Budi', 'basic_salary' => 7000000, 'allowance' => 0, 'deduction' => 500000],
            ],
        ])->assertOk()->assertJson([
            'count' => 2,
            'total' => 11750000,
            'status' => 'Selesai',
        ])->assertSessionHas('processedPayroll.total', 11750000);
    }

    public function test_admin_dashboard_contains_employee_management_and_private_employee_data(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->get(route('dashboard'))
            ->assertOk()
            ->assertSee('ADMINISTRATOR')
            ->assertSee('Data pegawai')
            ->assertSee('Andi Pratama')
            ->assertSee('Absensi')
            ->assertSee('Pengaturan')
            ->assertSee('Tambah pegawai')
            ->assertSee('Proses penggajian')
            ->assertSee('<form class="topbar-logout-form" method="POST" action="'.route('logout').'">', false)
            ->assertSee('aria-label="Keluar dari akun"', false);
    }

    public function test_regular_user_cannot_process_payroll(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $this->actingAs($user)->postJson(route('payroll.process'), [
            'period' => 'September 2026',
            'employees' => [['name' => 'Ayu', 'basic_salary' => 5000000]],
        ])->assertForbidden();
    }

    public function test_regular_user_can_view_reports_without_admin_controls(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $this->actingAs($user)->get(route('dashboard'))
            ->assertOk()
            ->assertSee('USER')
            ->assertSee('Laporan')
            ->assertSee('Cetak PDF')
            ->assertDontSee('Andi Pratama')
            ->assertDontSee('Direktori pegawai')
            ->assertDontSee('Absensi')
            ->assertDontSee('Pengaturan')
            ->assertDontSee('Proses penggajian')
            ->assertDontSee('Tambah pegawai');
    }

    public function test_visitors_can_use_the_dashboard_without_logging_in(): void
    {
        $this->post(route('guest.start'))->assertRedirect(route('dashboard'));

        $this->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Tamu')
            ->assertSee('AKSES TAMU')
            ->assertSee('Laporan')
            ->assertDontSee('Andi Pratama')
            ->assertDontSee('Proses penggajian')
            ->assertDontSee('Tambah pegawai');

        $this->assertGuest();
    }

    public function test_guest_can_leave_the_dashboard_and_return_to_login(): void
    {
        $this->withSession(['guest_mode' => true])
            ->post(route('guest.exit'))
            ->assertRedirect(route('login'));

        $this->assertGuest();
    }

    public function test_guest_dashboard_has_a_clear_logout_action(): void
    {
        $this->withSession(['guest_mode' => true])
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('aria-label="Keluar dari mode tamu"', false)
            ->assertSee('action="'.route('guest.exit').'"', false)
            ->assertSee('>Keluar</button>', false);
    }

    public function test_admin_can_log_out(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->post(route('logout'))
            ->assertRedirect(route('login'));

        $this->assertGuest();
    }

    public function test_visitor_can_cancel_login_and_return_to_the_dashboard(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Batal, kembali ke website')
            ->assertSee('href="'.route('dashboard').'"', false);
    }

    public function test_anyone_can_register_as_a_user_but_not_as_an_admin(): void
    {
        $this->post(route('register.store'), [
            'name' => 'Dina Putri',
            'email' => 'dina@example.test',
            'password' => 'personal-password',
            'password_confirmation' => 'personal-password',
            'role' => 'admin',
        ])->assertRedirect(route('dashboard'));

        $user = User::where('email', 'dina@example.test')->firstOrFail();
        $this->assertSame('user', $user->role);
        $this->assertAuthenticatedAs($user);
    }
}