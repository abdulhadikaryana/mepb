<?php

use yii\db\Migration;

class m170526_073856_add_column_approve_upt_to_table_penyebarluasan extends Migration
{
    public function up()
    {
        $this->addColumn('penyebarluasan', 'setuju_status_upt', $this->integer(1));
        $this->addColumn('penyebarluasan', 'setuju_tanggal_upt', $this->integer());
        $this->addColumn('penyebarluasan', 'setuju_oleh_upt', $this->integer(3));
        
        $this->addColumn('penyebarluasan_history', 'setuju_status_upt', $this->integer(1));
        $this->addColumn('penyebarluasan_history', 'setuju_tanggal_upt', $this->integer());
        $this->addColumn('penyebarluasan_history', 'setuju_oleh_upt', $this->integer(3));
    }

    public function down()
    {
        $this->dropColumn('penyebarluasan_history', 'setuju_oleh_upt');
        $this->dropColumn('penyebarluasan_history', 'setuju_tanggal_upt');
        $this->dropColumn('penyebarluasan_history', 'setuju_status_upt');

        $this->dropColumn('penyebarluasan', 'setuju_oleh_upt');
        $this->dropColumn('penyebarluasan', 'setuju_tanggal_upt');
        $this->dropColumn('penyebarluasan', 'setuju_status_upt');

        echo "m170526_073856_add_column_approve_upt_to_table_penyebarluasan cannot be reverted.\n";
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
