<?php

use yii\db\Migration;

class m170615_030341_alter_table_profile_change_column_fullname_phone_birthdate_to_null extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('profile', 'fullname', $this->string()->null());
        $this->alterColumn('profile', 'phone', $this->string()->null());
        $this->alterColumn('profile', 'birthdate', $this->date()->null());
    }

    public function safeDown()
    {
        $this->alterColumn('profile', 'fullname', $this->string()->notNull());
        $this->alterColumn('profile', 'phone', $this->string()->notNull());
        $this->alterColumn('profile', 'birthdate', $this->date()->notNull());
        echo "m170615_030341_alter_table_profile_change_column_fullname_phone_birthdate_to_null cannot be reverted.\n";
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170615_030341_alter_table_profile_change_column_fullname_phone_birthdate_to_null cannot be reverted.\n";

        return false;
    }
    */
}
