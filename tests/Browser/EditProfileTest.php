<?php

namespace Tests\Browser;

use Facebook\WebDriver\WebDriverBy;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class EditProfileTest extends DuskTestCase
{
    /**
     * test_EditProfile
     *
     * @return void
     */
    public function test_EditProfile()
    {
        $this->browse(function (Browser $browser) {
            $userMenuXpath =
                '/html/body/div[1]/header/nav/div[2]/ul/li[9]/a/span';
            $editProfileXpath =
                '/html/body/div[1]/header/nav/div[2]/ul/li[9]/ul/li[4]/a';
            $languageXpath =
                '/html/body/div[1]/div/section[2]/div[2]/div/div/form/div/div[1]/div[4]/div/span/span[1]/span/span[1]';
            $japaneseXpath =
                '/html/body/span/span/span[2]/ul/li[26]';
            $englishUsXpath =
                '/html/body/span/span/span[2]/ul/li[2]';

            // Login
            $browser->visit('/login')
                ->type('username', BrowserTestConst::USERNAME)
                ->type('password', BrowserTestConst::PASSWORD)
                ->press('Login')
                ->waitForText('Snipe-IT Demo');
            
            // Admin (User Name) を click してサブメニューを表示
            $browser->driver->findElement(
                WebDriverBy::xpath($userMenuXpath)
            )->click();
            $browser->waitForText('Edit Your Profile');

            // Edit Your Profile 画面へ遷移
            $browser->driver->findElement(
                WebDriverBy::xpath($editProfileXpath)
            )->click();
            $browser->waitForText('Gravatar Email Address (Private)')
                ->assertPathIs('/account/profile');

            // Language を Japanese に変更して Save
            $browser->driver->findElement(
                WebDriverBy::xpath($languageXpath)
            )->click();
            $browser->driver->findElement(
                WebDriverBy::xpath($japaneseXpath)
            )->click();
            $browser->press('Save')
                ->waitForText('プロファイルを編集')  // 日本語に変わってる
                ->assertSee('Account successfully updated')
            ;
    
            // Language を English,US に戻す
            $browser->driver->findElement(
                WebDriverBy::xpath($languageXpath)
            )->click();
            $browser->driver->findElement(
                WebDriverBy::xpath($englishUsXpath)
            )->click();
            $browser->press('保存')
                ->waitForText('Edit Your Profile')  // English,US に変わってる
                ->assertSee('Account successfully updated')
            ;
        });
    }
}
