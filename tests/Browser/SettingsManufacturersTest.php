<?php

namespace Tests\Browser;

use Facebook\WebDriver\WebDriverBy;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SettingsManufacturersTest extends DuskTestCase
{
    /**
     * test_settingsManufacturers
     *
     * @return void
     */
    public function test_settingsManufacturers()
    {
        $this->browse(function (Browser $browser) {
            $navigationXpath =
                '/html/body/div[1]/header/nav/a';
            $settingsXpath =
                '/html/body/div[1]/aside/section/ul/li[10]/a/span';
            $manufacturersXpath =
                '/html/body/div[1]/aside/section/ul/li[10]/ul/li[5]/a';
    
            // Login
            $browser->visit('/login')
                ->type('username', BrowserTestConst::USERNAME)
                ->type('password', BrowserTestConst::PASSWORD)
                ->press('Login')
                ->waitForText('Snipe-IT Demo');
    
            // 左上の navigation を click してサブメニューを表示
            $browser->driver->findElement(
                WebDriverBy::xpath($navigationXpath)
            )->click();
            $browser->waitForText('Requestable')
                ->assertSee('Settings');
    
            // Settings -> Manufacturers
            $browser->driver->findElement(
                WebDriverBy::xpath($settingsXpath)
            )->click();
            $browser->waitForText('Manufacturers');
            $browser->driver->findElement(
                WebDriverBy::xpath($manufacturersXpath)
            )->click();
            
            // Asset Manufacturers 画面へ遷移
            $browser
                ->waitForText('Support Email')
                ->assertPathIs('/manufacturers')
                ->assertSee('Asset Manufacturers')
            ;
        });
    }
}
