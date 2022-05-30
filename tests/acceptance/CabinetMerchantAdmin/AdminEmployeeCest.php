<?php

use Users\Killbill;
use Codeception\Util\Locator;

class AdminEmployeeCest
{
    public function EmployeeTesting(AcceptanceTester $I, Page\Acceptance\LoginPage $loginPage, Page\AdminMerchant\AdminMerchant $admin)
    {
        $I->openNewTab();
        $I->switchToNextTab(2);
        $loginPage->auth(new Killbill());
        $admin->AdminMerchant($I);
        $this->goToEmployeePage($I);
        $this->CreateEmployee($I);
        $this->deleteEmployee($I);
    }

    private function goToEmployeePage(AcceptanceTester $I)
    {
        $I->click(Locator::combine('.active > a:nth-child(1)','/html/body/div/aside/section/ul[1]/li[8]/a'));
        $I->waitForText('Сотрудники','10','.box-title');
    }

    private function CreateEmployee(AcceptanceTester $I)
    {
        $I->click(Locator::combine('.container-fluid > div:nth-child(1) > div:nth-child(1) > button:nth-child(1)','/html/body/div/div/section[2]/div/div/div[1]/div/div/button'));
        $I->fillField('#employeeform-login','CreatedByAutotest');
        $I->fillField('#employeeform-password','Wwwqqq111');
        $roleList = $I->grabMultiple('#employeeform-usertype > option','value');
        $roleSelect = array_rand(array_flip($roleList),1);
        $I->selectOption('#employeeform-usertype',(string)$roleSelect);
        $I->click(Locator::combine('#create_employee_form > div:nth-child(5) > div:nth-child(1) > button:nth-child(1)','/html/body/div[1]/div/section[2]/div/div/div[1]/div/div/div/div/div/div[2]/div/form/div[4]/div/button'));
    }

    private function deleteEmployee(AcceptanceTester $I)
    {
        do{
            $employeeList = $I->grabMultiple('.table > tbody > tr > td > a','href');
            $employeeSelect = array_rand(array_flip($employeeList),1);
        }while(preg_match('/CreatedByAutotest/',$employeeSelect) == false);

        $I->amOnPage($employeeSelect);
        $I->waitForText('Сотрудник успешно удален','10','.alert');
        $I->closeTab();
    }
}