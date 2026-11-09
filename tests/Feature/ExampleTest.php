<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_guests_can_open_the_dashboard_without_logging_in(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('AKSES TAMU')
            ->assertSee('Laporan')
            ->assertSee('Login')
            ->assertDontSee('Andi Pratama');
        $this->assertGuest();
    }
}
