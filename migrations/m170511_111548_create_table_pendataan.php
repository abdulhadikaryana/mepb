<?php

use yii\db\Migration;

class m170511_111548_create_table_pendataan extends Migration
{
    public function up()
    {
        $this->createTable('pendataan', [
            'id' => $this->primaryKey(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'tanggal_entri' => $this->dateTime()->notNull(),
            'lokasi' => $this->string(255)->notNull(),
            'desakel' => $this->string(255)->notNull(),
            'kecamatan' => $this->string(255)->notNull(),
            'kabupatenkota' => $this->string(255)->notNull(),
            'provinsi' => $this->string(255)->notNull(),
            'dataid' => $this->string(255),
            'obyek' => $this->string(255)->notNull(),
            'jumlah_data' => $this->integer(),
            'foto1' => 'Longtext',
            'foto2' => 'Longtext',
            'foto3' => 'Longtext',
            'latitude' => $this->decimal(20,9),
            'longitude' => $this->decimal(20,9),
            'setuju_status' => "boolean default null",
            'setuju_tanggal' => $this->integer(),
            'setuju_oleh' => $this->integer(),
            'version' => $this->integer()->defaultValue(1),
            'is_rev' => "boolean default false",
            'rev_tanggal' => $this->integer(),
            'rev_komentar' => $this->text(),
            'rev_oleh' => $this->integer(),
            'rev_no' => $this->integer(),
        ], 'ENGINE=InnoDB CHARSET=utf8');
    }

    public function down()
    {
        $this->dropTable('pendataan');
        echo "m170511_111548_create_table_pendataan cannot be reverted.\n";
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
