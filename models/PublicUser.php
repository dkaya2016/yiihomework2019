<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "public.user".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property int $personal_code
 * @property int $phone
 * @property bool $active
 * @property bool $dead
 * @property string $lang
 */
class PublicUser extends \yii\db\ActiveRecord
{
    private $allowedLoanAge = 18;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'public.user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'personal_code', 'phone'], 'required'],
            [['first_name', 'last_name', 'email', 'lang'], 'string'],
            [['personal_code', 'phone'], 'default', 'value' => null],
            [['personal_code', 'phone'], 'integer'],
            [['active', 'dead'], 'boolean'],
            ['email', 'email'],
            ['personal_code', 'number'],
            ['personal_code', 'validatePersonalCode'],
        ];
    }

    /**
     * It gets the age from personal code. If the date format is correct and the date of birth
     * less than today, it return the age. Otherwise return -
     */

    public function getAge() {
        if ( ($age = $this->calculateAge()) && is_numeric($age) )
            return $age;
        return '-';
    }

    /**
     * It calculates the age from personal code. If the date format is not correct and date of birth
     * greater than today, ['error' => 'YXYX'] it return the an error message. Otherwise return the age.
     */

    public function calculateAge() {

        // Dead person control
        if ($this->dead)
            return [ 'error' => 'Unable to calculate because person is dead.'];

        // Length control
        if ((strlen($this->personal_code)) != 11)
            return [ 'error' => 'Personal Id length must be 11'];

        // Century control
        switch (substr($this->personal_code,0,1)){
            case '1':
            case '2':
                 $yearTag = '18';
                 break;
            case '3':
            case '4':
                 $yearTag = '19';
                 break;
            case '5':
            case '6':
                 $yearTag = '20';
                 break;
            default:
                return [ 'error' => 'Wrong Century. Century Id = ' . substr($this->personal_code,0,1) . ' must be on     of the number in [1,2,3,4,5,6]'];
        }

        $dateOfBirth  = $yearTag . substr($this->personal_code,1,2)
                        . '-' . substr($this->personal_code,3,2)
                        . '-' . substr($this->personal_code,5,2);

        // Date validity control
        if ( ( $date = \DateTime::createFromFormat('Y-m-d', $dateOfBirth))
             && ( $date_errors = \DateTime::getLastErrors())
             && (($date_errors['warning_count'] + $date_errors['error_count'] > 0)) ){
             return [ 'error' => 'Invalid date of birth in personal id. [ ' . $dateOfBirth . ']'];
        }

        // Date of birth needs to be less than or equal to current time
        if ( $dateOfBirth > date("Y-m-d")){
            return [ 'error' => 'Date of birth in personal id is greater than today..[ ' . $dateOfBirth . ']'];
        }
        // return the age
        return date_diff(date_create($dateOfBirth), date_create(date("Y-m-d")))->format('%y');
    }

    /**
     * It validates the personal code only for age perspective.
     */

    public function validatePersonalCode($attribute, $params, $validator){
        if ( ($age = $this->calculateAge()) && !is_numeric($age) ) {
            $this->addError($attribute, $age['error']);
        }
    }


    /**
     * It checks the age from personal code and if the date is valid according to age perspective and
     * age is equal and greater than allowedLoanAge it returns true. If the for date format is wrong or
     * age is less than allowedLoanAge return false.
     */

    public function isAllowedToTakeLoan(){
        if ( ($age = $this->calculateAge()) && is_numeric($age) && ($age >= $this->allowedLoanAge)) {
            return TRUE;
        }
        return FALSE;
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'personal_code' => 'Personal Code',
            'phone' => 'Phone',
            'active' => 'Active',
            'dead' => 'Dead',
            'lang' => 'Lang',
            'age' => 'Age'
        ];
    }
}
