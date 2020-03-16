<?php

use yii\db\Migration;

class m170609_030602_add_column_uuid_to_table_history_activity extends Migration
{
    public function safeUp()
    {
        $this->addColumn('penyebarluasan_history', 'uuid', $this->string(200));
        $this->addColumn('konsolidasi_history', 'uuid', $this->string(200));
    }

    public function safeDown()
    {
        $this->dropColumn('konsolidasi_history', 'uuid');
        $this->dropColumn('penyebarluasan_history', 'uuid');
        echo "m170609_030602_add_column_uuid_to_table_history_activity cannot be reverted.\n";
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170609_030602_add_column_uuid_to_table_history_activity cannot be reverted.\n";

        return false;
    }
    */
}
