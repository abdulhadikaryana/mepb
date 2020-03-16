<?php

use yii\db\Migration;

class m170710_124540_add_column_provid_kabid_to_user extends Migration
{
    public function safeUp()
    {
        $this->addColumn('user', 'provinsi_id', $this->integer());
        $this->addColumn('user', 'kabkota_id', $this->integer());
    }

    public function safeDown()
    {
        $this->dropColumn('user', 'kabkota_id');
        $this->dropColumn('user', 'provinsi_id');
        echo "m170710_124540_add_column_provid_kabid_to_user cannot be reverted.\n";
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170710_124540_add_column_provid_kabid_to_user cannot be reverted.\n";

        return false;
    }
    */
}
