<?php

use Codeception\Util\Locator;
use Users\Killbill;

class AdminSupportCest
{
    public function SupportTesting(AcceptanceTester $I,Page\Acceptance\LoginPage $loginPage, Page\AdminMerchant\AdminMerchant $admin)
    {
        $loginPage->auth(new Killbill());
        $admin->AdminMerchant($I);
    }

    private function invokeSupportModal(AcceptanceTester $I)
    {
        $I->click(Locator::combine('#question_button > li:nth-child(1) > a:nth-child(1) > span:nth-child(2)','/html/body/div/aside/section/ul[2]/li/a/span'));
        $I->waitForText('Обращение','10','#exampleModalLabel');
    }

    private function createSupportMessage(AcceptanceTester $I)
    {
        $I->fillField('#handling-name','AutotestCodeception');
        $I->fillField('#handling-phone','7777777777');
        $I->fillField('#handling-message','This message created by AutoTest');
    }

    private function verifyResult(AcceptanceTester $I)
    {
        $I->click('#question_form_submit_btn');
//        $I->waitForText('','',''); // Ожидает исправление (https://youtrack.wooppay.com/issue/CAB-1230)
    }
}