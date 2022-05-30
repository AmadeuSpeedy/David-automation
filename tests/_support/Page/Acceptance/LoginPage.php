<?php
namespace Page\Acceptance;

use AcceptanceTester;
use Users\Merchant;
use Codeception\Util\Locator;

class LoginPage
{
    // include url of current page
    public static $URL = '/welcome/site/login';

    /**
     * Declare UI map for this page here. CSS or XPath allowed.
     * public static $usernameField = '#username';
     * public static $formSubmitButton = "#mainForm input[type=submit]";
     */
    public $loginField = "#loginform-login";
    public $passwordField = "#loginform-password";

    /**
     * @var AcceptanceTester;
     */
    protected $acceptanceTester;

    public function __construct(\AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;
    }

    public function auth(Merchant $merchant)
    {
        $I = $this->acceptanceTester;

        $I->amOnPage(self::$URL);
        $I->wait(3);
        $I->fillField($this->loginField, $merchant->name);
        $I->fillField($this->passwordField, $merchant->password);
        $I->click(Locator::combine('.btn','/html/body/div[1]/div/div/div/form/div[2]/button'));
        $I->wait(5);
    }
}
