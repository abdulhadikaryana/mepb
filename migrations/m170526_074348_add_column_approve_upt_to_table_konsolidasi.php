<?php

use yii\db\Migration;

class m170526_074348_add_column_approve_upt_to_table_konsolidasi extends Migration
{
    public function up()
    {
        $this->addColumn('konsolidasi', 'setuju_status_upt', $this->integer(1));
        $this->addColumn('konsolidasi', 'setuju_tanggal_upt', $this->integer());
        $this->addColumn('konsolidasi', 'setuju_oleh_upt', $this->integer(3));
        
        $this->addColumn('konsolidasi_history', 'setuju_status_upt', $this->integer(1));
        $this->addColumn('konsolidasi_history', 'setuju_tanggal_upt', $this->integer());
        $this->addColumn('konsolidasi_history', 'setuju_oleh_upt', $this->integer(3));
    }

    public function down()
    {
        $this->dropColumn('konsolidasi_history', 'setuju_oleh_upt');
        $this->dropColumn('konsolidasi_history', 'setuju_tanggal_upt');
        $this->dropColumn('konsolidasi_history', 'setuju_status_upt');

        $this->dropColumn('konsolidasi', 'setuju_oleh_upt');
        $this->dropColumn('konsolidasi', 'setuju_tanggal_upt');
        $this->dropColumn('konsolidasi', 'setuju_status_upt');

        echo "m170526_074348_add_column_approve_upt_to_table_konsolidasi cannot be reverted.\n";
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
