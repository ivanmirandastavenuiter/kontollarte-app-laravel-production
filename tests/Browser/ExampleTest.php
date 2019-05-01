<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->browse(function (Browser $browser) {

            $browser->visit('/login')
                        ->assertSee('Login')
                        ->type('email', 'ivanmist90@gmail.com')
                        ->type('password', 'locoloco')
                        ->click('.btn.btn-primary')
                        ->click('#account-nav')
                        ->click('#first-update-button')
                        ->pause(3000)
                        ->type('username', 'MIAMOL')
                        ->click('#accsubmit');
                        //->click('#accsubmit');
            // $browser->visit('https://www.google.com/intl/es/gmail/about/#')
            //         ->assertSee('Iniciar sesión')
            //         ->clickLink('Iniciar sesión')
        });
    }
}
