<?php
namespace models;

use app\models\PublicUser;


class AgeCalculationTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $model;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    /**
     *  Age calculation needs to return correct age
     */
    public function testAgeCalculationWithExpectedRightAge()
    {
        $user = new PublicUser();
        $user->personal_code = '37501110011';
        $age = $user->calculateAge();
        $expectedAge = date_diff(date_create('1975-01-11'), date_create(date("Y-m-d")))->format('%y');
        $this->assertTrue(!is_array($age) && $age == $expectedAge);

        $user->personal_code = '17501110011';
        $age = $user->calculateAge();
        $expectedAge = date_diff(date_create('1875-01-11'), date_create(date("Y-m-d")))->format('%y');
        $this->assertTrue(!is_array($age) && $age == $expectedAge);

        $user->personal_code = '38509170402';
        $age = $user->calculateAge();
        $expectedAge = date_diff(date_create('1985-09-17'), date_create(date("Y-m-d")))->format('%y');
        $this->assertTrue(!is_array($age) && $age == $expectedAge);
    }

    /**
     *  Wrong Century
     */
    public function testAgeCalculationWrongCenturyCode()
    {
        // Century code needs to be in [1..6]
        $user = new PublicUser();
        $user->personal_code = '77501110011';
        $age = $user->calculateAge();
        $this->assertTrue( is_array($age)
                           && isset($age['error'])
                           && strpos($age['error'], 'Wrong Century') !== FALSE
                          );

        $user->personal_code = '97501110011';
        $age = $user->calculateAge();
        $this->assertTrue( is_array($age)
                           && isset($age['error'])
                           && strpos($age['error'], 'Wrong Century') !== FALSE
                          );
    }

    /**
     *  Invalid date of birth
     */
    public function testAgeCalculationInvalidDateOfBirth()
    {

        // Invalid month
        $user = new PublicUser();
        $user->first_name = 'Test';
        // Month code is 13
        $user->personal_code = '17513110011';
        $age = $user->calculateAge();
        $this->assertTrue( is_array($age)
                           && isset($age['error'])
                           && strpos($age['error'], 'Invalid date of birth') !== FALSE
                          );

        // Invalid day - day code is 32
        $user->personal_code = '37501320011';
        $age = $user->calculateAge();
        $this->assertTrue( is_array($age)
                           && isset($age['error'])
                           && strpos($age['error'], 'Invalid date of birth') !== FALSE
                          );
    }

    /**
     *  Dead person check
     */
    public function testAgeCalculationDeadPerson()
    {
        $user = new PublicUser();
        $user->personal_code = '37501110011';
        $user->dead = TRUE;
        $age = $user->calculateAge();
        $this->assertTrue( is_array($age)
                           && isset($age['error'])
                           && strpos($age['error'], 'because person is dead') !== FALSE
                          );

    }

}