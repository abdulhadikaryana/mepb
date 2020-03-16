<?php

use yii\db\Migration;

class m170515_140852_add_column_twitter_to_table_profile extends Migration
{
    public function up()
    {
        $this->addColumn('profile', 'twitter', 'string');
    }

    public function down()
    {
        $this->dropColumn('profile', 'twitter');
        echo "m170515_140852_add_column_twitter_to_table_profile cannot be reverted .\n";
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
