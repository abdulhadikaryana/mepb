<?php

use yii\db\Migration;

class m170516_155024_add_column_flag_to_table_tema extends Migration
{
    public function up()
    {
        $this->addColumn('tema', 'flag', $this->integer(2)->defaultValue(1));
    }

    public function down()
    {
        $this->dropColumn('tema', 'flag');
        echo "m170516_155024_add_column_flag_to_table_tema cannot be reverted.\n";
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
