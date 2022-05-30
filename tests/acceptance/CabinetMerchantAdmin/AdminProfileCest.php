<?php

use Codeception\Util\Locator;
use Users\Killbill;

class AdminProfileCest
{
    public function AdminProfileTesting(AcceptanceTester $I,Page\Acceptance\LoginPage $loginPage, Page\AdminMerchant\AdminMerchant $admin)
    {
        $loginPage->auth(new Killbill());
        $admin->AdminMerchant($I);
        $this->goToProfilePage($I);
        $this->verifyPage($I);
        $this->uploadAvatar($I);
    }

    private function goToProfilePage(AcceptanceTester $I)
    {
        $I->click(Locator::combine('.active > a:nth-child(1)', '/html/body/div/aside/section/ul[1]/li[6]/a'));
        $I->waitForText('Настройки профиля', '10', 'div.content-header > h1:nth-child(1)');
    }

    private function verifyPage(AcceptanceTester $I)
    {
        $I->see('Аватар', 'div.box:nth-child(1) > div:nth-child(1)');
        $I->see('Общая информация', 'div.box:nth-child(2) > div:nth-child(1)');
        $I->see('Настройки почты', 'div.box:nth-child(3) > div:nth-child(1)');
        $I->see('Настройки авторизации', 'div.box:nth-child(4) > div:nth-child(1)');
    }

    private function uploadAvatar(AcceptanceTester $I)
    {
        $I->attachFile('#imageFile', 'autotestspicture.jpg');
        $I->click('#submitAva');
        $I->wait(3);
        $I->see('Аватар успешно обновлен', '.alert');
    }
}