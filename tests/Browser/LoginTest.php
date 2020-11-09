<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * test_Login
     *
     * @return void
     */
    public function test_Login()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('username', BrowserTestConst::USERNAME)
                ->type('password', BrowserTestConst::PASSWORD)
                ->press('Login')
                ->waitForText('Snipe-IT Demo')
                ->assertSee('Snipe-IT Demo')
                ->assertSee('Dashboard')
                ->assertSee('Recent Activity')
                ->assertSee('Assets by Status')
                ->assertSee('Asset Categories')
                ;
        });
    }
}
