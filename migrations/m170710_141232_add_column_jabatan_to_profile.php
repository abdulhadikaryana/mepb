<?php

use yii\db\Migration;

class m170710_141232_add_column_jabatan_to_profile extends Migration
{
    public function safeUp()
    {
        $this->addColumn('profile', 'jabatan', $this->string(200));
    }

    public function safeDown()
    {
        $this->dropColumn('profile', 'jabatan');
        echo "m170710_141232_add_column_jabatan_to_profile cannot be reverted.\n";
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170710_141232_add_column_jabatan_to_profile cannot be reverted.\n";

        return false;
    }
    */
}
