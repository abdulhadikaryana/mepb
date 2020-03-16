<?php

use yii\db\Migration;

class m170518_163652_add_column_parent_id_to_table_user extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'parent_id', $this->integer());
        // 10 -> Admin, 20 -> UPT, 30 -> Dinas, 40 -> Penggiat
        $this->addColumn('user', 'group', $this->integer()->defaultValue(40));
    }

    public function down()
    {
        $this->dropColumn('user', 'group');
        $this->dropColumn('user', 'parent_id');
        echo "m170518_163652_add_column_parent_id_to_table_user cannot be reverted.\n";
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
