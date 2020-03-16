<?php

use yii\db\Migration;

class m170609_030024_add_column_uuid_to_table_activity extends Migration
{
    public function safeUp()
    {
        $this->addColumn('penyebarluasan', 'uuid', $this->string(200));
        $this->addColumn('konsolidasi', 'uuid', $this->string(200));
        $this->addColumn('pendataan', 'uuid', $this->string(200));
    }

    public function safeDown()
    {
        $this->dropColumn('pendataan', 'uuid');
        $this->dropColumn('konsolidasi', 'uuid');
        $this->dropColumn('penyebarluasan', 'uuid');
        echo "m170609_030024_add_column_uuid_to_table_activity cannot be reverted.\n";
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170609_030024_add_column_uuid_to_table_activity cannot be reverted.\n";

        return false;
    }
    */
}
