<?php

use Codeception\Util\Locator;
use Users\Killbill;
use Facebook\WebDriver\WebDriverKeys;

class AdminHistoryCest
{
    public function AdminHistoryPageTesting(AcceptanceTester $I, Page\Acceptance\LoginPage $loginPage, Page\AdminMerchant\AdminMerchant $admin)
    {
        $loginPage->auth(new Killbill());
        $admin->AdminMerchant($I);
        $this->goToHistoryPage($I);
        $this->filterTesting($I);
        $this->verifyResult($I);
    }

    private function goToHistoryPage(AcceptanceTester $I)
    {
        $I->click(Locator::combine('span .treeview-menu-item-container', '/html/body/div[1]/aside/section/ul[1]/li[2]/a/span'));
        $I->waitForText('Кабинет администратора мерчантов', '25', '.header');
    }

    private function filterTesting(AcceptanceTester $I)
    {
        $status = $I->grabMultiple('#reportform-statuses > option', 'value');
        $statusSelect = array_rand(array_flip($status), 1);
        $services = $I->grabMultiple('label.checkbox > input', 'value');
        $selectService = array_rand(array_flip($services), 1);
        $I->fillField('#reportform-datefrom', '2021-01-01');
        $I->fillField('#reportform-dateto', '2022-02-18');
        $I->pressKey('#reportform-datefrom', WebDriverKeys::ESCAPE);
        $I->pressKey('#reportform-dateto', WebDriverKeys::ESCAPE);
        $I->selectOption('.field-reportform-services', (string)$selectService);
        $I->selectOption('#reportform-statuses', (string)$statusSelect);
    }

    private function verifyResult(AcceptanceTester $I)
    {
        $I->click('#filterHistory');
        $I->waitForElement('div.box:nth-child(2) > div:nth-child(1)', '25');
        $attribute = $I->grabAttributeFrom('.table > tbody:nth-child(2) > tr:nth-child(1)', 'data-key');
        if (is_null($attribute)) {
            $I->see('Ничего не найдено.', '.empty');
        } else
            $I->SeeElement('.table > tbody:nth-child(2) > tr:nth-child(1) > td:nth-child(2) > data-key', $attribute);
    }
}
