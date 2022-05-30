<?php

use Codeception\Util\Locator;
use Users\Killbill;

class AdminInvoiceCreateCest
{
    public function AdminInvoiceCreateTesting(AcceptanceTester $I, Page\Acceptance\LoginPage $loginPage, Page\AdminMerchant\AdminMerchant $admin)
    {
        $loginPage->auth(new Killbill());
        $admin->AdminMerchant($I);
        $this->goToInvoiceCreatePage($I);
        $this->selectService($I);
        $this->selectNotification($I);
        $this->advancedFilters($I);
        $this->verifyResult($I);
    }

    private function goToInvoiceCreatePage(AcceptanceTester $I)
    {
        $I->click(Locator::combine('li.active:nth-child(3) > a:nth-child(1)', '/html/body/div/aside/section/ul[1]/li[3]/a'));
        $I->waitForText('Отправить счет на оплату', '20', '.container > h2:nth-child(1)');
    }

    private function selectService(AcceptanceTester $I)
    {
        $I->click('#service_name');
        do {
            $servicesList = $I->grabMultiple('#service_name > option', 'value');
            $service = array_rand(array_flip($servicesList), 1);
        } while (empty($service));
        $I->wait(1);
        $I->selectOption('#service_name', $service);
        $I->fillField('#orderform-amount', '777');
    }

//  На момент написания оплата через мобильного оператора не работала. Можно раскоментировать для использования оплаты через мобильного оператора.
//    private function selectPayment(AcceptanceTester $I)
//    {
////        $paymentList = $I->grabMultiple('#option > option', 'value');
////        $payment = array_rand(array_flip($paymentList), 1);
//        $I->selectOption('#option', $payment);
//    }

    private function selectSMSNotification(AcceptanceTester $I)
    {
        $I->click('#phone_tab');
        $I->wait(1);
        $I->fillField('#orderform-user_phone', '701 205 5555');
    }

    private function selectEmailNotification(AcceptanceTester $I)
    {
        $I->click('#email_tab');
        $I->wait(1);
        $I->fillField('#orderform-user_email', 'autotest@wooppay.test');
    }

    private function selectOtherNotifications(AcceptanceTester $I)
    {
        $I->click('#other_tab');
    }

    private function selectNotification(AcceptanceTester $I)
    {
        $notifications = rand(0, 2);
        switch ($notifications) {
            case 0:
                $this->selectSMSNotification($I);
                break;
            case 1:
                $this->selectEmailNotification($I);
                break;
            case 2:
                $this->selectOtherNotifications($I);
                break;
        }
    }

    private function advancedFilters(AcceptanceTester $I)
    {
        $I->click('#advanced_settings');
        $I->wait(1);
        $I->fillField('#orderform-reference_id', md5(rand(1, 999)));
        $I->fillField('#back_url', 'youtube.com');
        $I->fillField('#description', 'CreatedByAutotest');
        $I->fillField('#orderform-offer', 'www.wooppay.com');
        $I->fillField('#orderform-description', 'CreatedByAutotest');
        do {
            $deathDateList = $I->grabMultiple('#orderform-death_date > option', 'value');
            $deathDate = array_rand(array_flip($deathDateList), 1);
            $I->selectOption('#orderform-death_date', $deathDate);
        } while (empty($deathDate));
        $I->fillField('#orderform-order_number', md5(rand(1, 999)));
    }

    private function verifyResult(AcceptanceTester $I)
    {
        $I->click(Locator::combine('div.form-group:nth-child(17) > button:nth-child(1)', '/html/body/div/div/section[2]/div/div/div[1]/div/div/form/div[13]/button'));
        $I->waitForText('Ссылка для оплаты выставленного счета:', '25', '.col-md-12 > h3:nth-child(1)');
        $I->seeInCurrentUrl('/merchant_admin/invoice/create');
    }
}