<?php
namespace models;
use app\models\PublicUser;

class UserLoanAcceptanceTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    /**
     *  User is allowed to take a loan
     */
    public function testUserAllowedToTakeLoan()
    {
        // 44 years old person
        $user = new PublicUser();
        $user->personal_code = '37501010011';
        $user->dead = FALSE;
        $this->assertTrue($user->isAllowedToTakeLoan() === TRUE);
    }

    /**
     *  Age less than 18 User not allowed to take a loan
     */
    public function testAgeLessThan18UserNotAllowedToTakeLoan()
    {
        // 8 years old person
        $user = new PublicUser();
        $user->personal_code = '61101010011';
        $this->assertTrue($user->isAllowedToTakeLoan() === FALSE);
    }

    /**
     *  User not allowed to take a loan with wrong date format
     */
    public function testUserNotAllowedToTakeLoanWrongCentury()
    {
        // century code normally must be in [1..6]
        $user = new PublicUser();
        $user->personal_code = '77501110011';
        $this->assertTrue($user->isAllowedToTakeLoan() === FALSE);
    }
    /**
     *  User not allowed to take a loan with wrong date format
     */
    public function testUserNotAllowedToTakeLoanInvalidDateOfBirth()
    {
        // Wrong Date of birth is set as 1975-33-50
        $user = new PublicUser();
        $user->personal_code = '37533500011';
        $this->assertTrue($user->isAllowedToTakeLoan() === FALSE);
    }

    /**
     *  Dead User not allowed to take a loan
     */
    public function testUserDeadUserNotAllowedToTakeLoan()
    {
        // Wrong Date of birth is set as 1975-33-50
        $user = new PublicUser();
        $user->personal_code = '37533500011';
        $user->dead = TRUE;
        $this->assertTrue($user->isAllowedToTakeLoan() === FALSE);
    }
}