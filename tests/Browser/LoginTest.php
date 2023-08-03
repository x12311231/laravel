<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;
    use DatabaseTruncation;

    /**
     * A basic browser test example.
     * @throws \Throwable
     */
    public function test_basic_example(): void
    {
        $password = 'password';
        $user = User::factory()->create([
            'email' => 'taylor@laravel.com',
            'password' => Hash::make($password)
        ]);

        $this->assertDatabaseCount(User::class, 1);
        $this->browse(function (Browser $browser) use ($user, $password) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', $password)
//                ->press('Log in')
                    ->click('#Login')
                ->assertPathIs('/dashboard');
        });
    }
    /**
     * A Dusk test example.
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Laravel');
        });
    }
}
