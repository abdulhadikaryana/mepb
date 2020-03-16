<?php

use yii\db\Migration;

class m170522_053200_add_column_kode_table_lokasi extends Migration
{
    public function up()
    {
        $this->addColumn('provinsi', 'kode_provinsi', $this->string());
        $this->addColumn('kabupatenkota', 'kode_kabkota', $this->string());
        $this->addColumn('kecamatan', 'kode_kecamatan', $this->string());
    }

    public function down()
    {
        $this->dropColumn('kecamatan', 'kode_kecamatan');
        $this->dropColumn('kebupatenkota', 'kode_kabkota');
        $this->dropColumn('provinsi', 'kode_provinsi');
        echo "m170522_053200_add_column_kode_table_lokasi cannot be reverted.\n";
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
