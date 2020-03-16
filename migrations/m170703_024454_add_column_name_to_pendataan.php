<?php

use yii\db\Migration;

class m170703_024454_add_column_name_to_pendataan extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('pendataan', 'uuid');
        $this->addColumn('pendataan', 'name', $this->string(200));
    }

    public function safeDown()
    {
        $this->dropColumn('pendataan', 'name');
        $this->addColumn('pendataan', 'uuid', $this->string(200));
        echo "m170703_024454_add_column_name_to_pendataan cannot be reverted.\n";
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170703_024454_add_column_name_to_pendataan cannot be reverted.\n";

        return false;
    }
    */
}
