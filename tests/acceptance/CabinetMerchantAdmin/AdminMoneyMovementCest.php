<?php

use Codeception\Util\Locator;
use Users\Killbill;

class AdminMoneyMovementCest
{
    public function MoneyMovementTesting(AcceptanceTester $I, Page\Acceptance\LoginPage $loginPage, Page\AdminMerchant\AdminMerchant $admin)
    {
        $loginPage->auth(new Killbill());
        $admin->AdminMerchant($I);
        $this->goToMoneyMovementPage($I);
        $this->filterTesting($I);
        $this->verifyResult($I);
    }

    private function goToMoneyMovementPage(AcceptanceTester $I)
    {
        $I->click(Locator::combine('ul.sidebar-menu:nth-child(1) > li:nth-child(4) > a:nth-child(1)', '/html/body/div/aside/section/ul[1]/li[4]/a'));
        $I->waitForText('Движение денежных средств по кошельку', '10', 'div.content-header > h1:nth-child(1)');
    }

    private function filterTesting(AcceptanceTester $I)
    {
        $servicesList = $I->grabMultiple('label.checkbox > input', 'value');
        $service = array_rand(array_flip($servicesList), 1);
        $I->selectOption('div.col-md-12:nth-child(4) > div:nth-child(1)', (string)$service);
        $I->fillField('#w0', '2021-01-01');
        $I->fillField('#w1', '2022-02-24');
    }

    private function verifyResult(AcceptanceTester $I)
    {
        $I->click(Locator::combine('.box-footer > button:nth-child(1)', '/html/body/div/div/section[2]/div/div/div[2]/div[1]/form/div[2]/button[1]'));
        $I->waitForElement('div.box-body:nth-child(2)', '10');
    }
}