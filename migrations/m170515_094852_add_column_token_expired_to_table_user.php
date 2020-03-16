<?php

use yii\db\Migration;

class m170515_094852_add_column_token_expired_to_table_user extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'token_expired', 'string');
    }

    public function down()
    {
        $this->dropColumn('user', 'token_expired');
        echo "m170515_094852_add_column_token_expired_to_table_user cannot be reverted.\n";
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
