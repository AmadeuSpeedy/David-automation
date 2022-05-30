<?php

use Codeception\Util\Locator;
use Users\Killbill;

class AdminStatisticsCest
{
    public function StatisticsTesting(AcceptanceTester $I, Page\Acceptance\LoginPage $loginPage, Page\AdminMerchant\AdminMerchant $admin)
    {
        $loginPage->auth(new Killbill());
        $admin->AdminMerchant($I);
        $this->goToStatisticPage($I);
        $this->setFilters($I);
        $this->verifyResult($I);
    }

    private function goToStatisticPage(AcceptanceTester $I)
    {
        $I->click(Locator::combine('li.active:nth-child(7) > a:nth-child(1) > span:nth-child(2)', '/html/body/div/aside/section/ul[1]/li[7]/a/span'));
        $I->wait(1);
        $I->click(Locator::combine('li.active:nth-child(7) > ul:nth-child(2) > li:nth-child(1) > a:nth-child(1)', '/html/body/div/aside/section/ul[1]/li[7]/ul/li/a'));
        $I->wait(1);
        $I->click(Locator::combine('.menu-open > li:nth-child(1) > a:nth-child(1)', '/html/body/div/aside/section/ul[1]/li[7]/ul/li/ul/li[1]/a'));
    }

    private function setFilters(AcceptanceTester $I)
    {
        $dateGroupList = $I->grabMultiple('#reportform-grouping > option', 'value');
        $dateGroupSelect = array_rand(array_flip($dateGroupList), 1);
        $I->selectOption('#reportform-grouping', $dateGroupSelect);

        $graphicTypeList = $I->grabMultiple('#reportform-charttype > option', 'value');
        $graphicTypeSelect = array_rand(array_flip($graphicTypeList), 1);
        $I->selectOption('#reportform-charttype', $graphicTypeSelect);

        $paymentTypeList = $I->grabMultiple('label.checkbox > input', 'value');
        $paymentTypeSelect = array_rand(array_flip($paymentTypeList), 1);
        $I->selectOption('div.col-md-12:nth-child(5)', (string)$paymentTypeSelect);

        $I->fillField('#reportform-datefrom', '2019-01-01');
        $I->fillField('#reportform-dateto', '2022-02-25');
    }

    private function verifyResult(AcceptanceTester $I)
    {
        $I->click('#filterHistory');
        $I->waitForElement('div.box:nth-child(2) > div:nth-child(1) > h3:nth-child(1)', '10 ');
    }
}