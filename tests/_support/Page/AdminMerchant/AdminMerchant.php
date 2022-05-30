<?php

namespace Page\AdminMerchant;

use Codeception\Util\Locator;

class AdminMerchant
{
    public function AdminMerchant(\AcceptanceTester $I)
    {
        $I->click(Locator::combine('ul.nav:nth-child(2) > li:nth-child(2) > h2:nth-child(1) > a:nth-child(1)','/html/body/div[1]/div/ul/li[2]/h2/a'));
        $I->waitForText('Кабинет администратора мерчантов','25','.header');
        $I->seeInCurrentUrl('/merchant_admin');
    }
}