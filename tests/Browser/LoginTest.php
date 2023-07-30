<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
//    use DatabaseMigrations;
//    use DatabaseTruncation;

    /**
     * A basic browser test example.
     */
//    public function test_basic_example(): void
//    {
//        $user = User::factory()->create([
//            'email' => 'taylor@laravel.com',
//        ]);
//
//        $this->browse(function (Browser $browser) use ($user) {
//            $browser->visit('/login')
//                ->type('email', $user->email)
//                ->type('password', 'password')
//                ->press('Login')
//                ->assertPathIs('/home');
//        });
//    }
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
