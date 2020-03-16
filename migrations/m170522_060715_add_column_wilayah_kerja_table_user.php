<?php

use yii\db\Migration;

class m170522_060715_add_column_wilayah_kerja_table_user extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'wilayah_kerja', $this->string());
    }

    public function down()
    {
        $this->dropColumn('user', 'wilayah_kerja');
        echo "m170522_060715_add_column_wilayah_kerja_table_user cannot be reverted.\n";
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
