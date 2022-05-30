<?php

use Users\Killbill;
use Codeception\Util\Locator;

class AdminCustomizeInvoiceCest
{
    public function CustomizeInvoiceTesting(AcceptanceTester $I, Page\Acceptance\LoginPage $loginPage, Page\AdminMerchant\AdminMerchant $admin)
    {
        $loginPage->auth(new Killbill());
        $admin->AdminMerchant($I);
        $this->goToCustomizeInvoicePage($I);
        $this->selectService($I);
        $this->customizeInvoice($I);
    }

    private function goToCustomizeInvoicePage(AcceptanceTester $I)
    {
        $I->click(Locator::combine('ul.sidebar-menu:nth-child(1) > li:nth-child(5) > a:nth-child(1)', '/html/body/div/aside/section/ul[1]/li[5]/a'));
        $I->waitForText('Стилизация инвойса', '10', 'div.content-header > h1:nth-child(1)');
    }

    private function selectService(AcceptanceTester $I)
    {
        do {
//            $merchantList = $I->grabMultiple('#child_id > option', 'value');
//            $merchant = array_rand(array_flip($merchantList), 1);
            $I->selectOption('#child_id', '361172');
            $serviceList = $I->grabMultiple('#service_name > option', 'value');
            $service = array_rand(array_flip($serviceList), 1);
            $I->selectOption('#service_name', $service);
        } while (empty($service));
        $I->waitForElement('#custom_invoice_block', 20);
    }

    private function customizeInvoice(AcceptanceTester $I)
    {
        $I->fillField('#custominvoiceform-backgroundcolor', '#8b00ff');
        $I->click('#submit_invoice_customization');
        $I->waitForText('Стилизация инвойса успешно обновлена!', '15', '.alert');
    }

}