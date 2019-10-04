<?php

use yii\db\Schema;
use yii\db\Migration;

defined('_SEPERATOR_') or define('_SEPERATOR_', '/');
defined('_ROOT_') or define('_ROOT_', __DIR__ . '/../');
/**
 * Class m170911_093407_setup
 */
class m170911_093407_setup extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => Schema::TYPE_PK,
            'first_name' => Schema::TYPE_TEXT . ' NOT NULL',
            'last_name' => Schema::TYPE_TEXT . ' NOT NULL',
            'email' => Schema::TYPE_TEXT . ' NOT NULL',
            'personal_code' => Schema::TYPE_BIGINT . ' NOT NULL',
            'phone' => Schema::TYPE_BIGINT . ' NOT NULL',
            'active' => Schema::TYPE_BOOLEAN,
            'dead' => Schema::TYPE_BOOLEAN,
            'lang' => Schema::TYPE_TEXT
        ]);

        //TODO (03.10.2019) Deniz KAYA - referencial integrity for user_id needs to be add.?
        $this->createTable('loan', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_BIGINT . ' NOT NULL',
            'amount' => 'NUMERIC( 10, 2 ) NOT NULL',
            'interest' => 'NUMERIC( 10, 2 ) NOT NULL',
            'duration' => Schema::TYPE_INTEGER . ' NOT NULL',
            'start_date' => Schema::TYPE_DATE . ' NOT NULL',
            'end_date' => Schema::TYPE_DATE . ' NOT NULL',
            'campaign' => Schema::TYPE_INTEGER . ' NOT NULL',
            'status' => Schema::TYPE_BOOLEAN
        ]);


        /*
            Load users to the database from file.
        */
        //TODO (03.10.2019) Deniz KAYA - does personal_code check needs to be add here?
        if ( $users = $this->getJsonFile(_ROOT_. 'users.json')){
            foreach($users as $key => $user){
                $this->insert('user', [
                    'id'   => $user['id'],
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                    'email' => $user['email'],
                    'personal_code' => $user['personal_code'],
                    'phone' => $user['phone'],
                    'active' => $user['active'],
                    'dead' => $user['dead'],
                    'lang' => $user['lang'],
                ]);

            }
        }

        /*
            Load loans to the database from file.
        */
        if ( $loans = $this->getJsonFile(_ROOT_. 'loans.json')){
            foreach($loans as $key => $loan){
                $this->insert('loan', [
                    'id'   => $loan['id'],
                    'user_id' => $loan['user_id'],
                    'amount' => $loan['amount'],
                    'interest' => $loan['interest'],
                    'duration' => $loan['duration'],
                    'start_date' =>  date('Y-m-d h:m:s', $loan['start_date']),
                    'end_date' => date('Y-m-d h:m:s', $loan['end_date']),
                    'campaign' => $loan['campaign'],
                    'status' => $loan['status'],
                ]);
            }
        }

    }

    /**
     * @inheritdoc
     */

    public function getJsonFile($filename){

        if (!file_exists($filename)){
            echo $filename . ' does not exists...!';
            return false;
        }
        return json_decode(file_get_contents($filename), true);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('user');
        $this->dropTable('loan');
    }
}
