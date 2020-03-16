<?php

use yii\db\Migration;

class m170511_093411_create_table_lokasi extends Migration
{
    public function up()
    {
        $this->createTable('provinsi', [
            'id' => $this->primaryKey(),
            'nama_provinsi' => $this->string(255)->notNull()
        ], 'ENGINE=InnoDB CHARSET=utf8');

        $this->createTable('kabupatenkota', [
            'id' => $this->primaryKey(),
            'nama_kabkota' => $this->string(255)->notNull(),
            'tipe' => "ENUM('Kabupaten','Kota')",
            'provinsi_id' => $this->integer(),
        ], 'ENGINE=InnoDB CHARSET=utf8');

        $this->createTable('kecamatan', [
            'id' => $this->primaryKey(),
            'nama_kecamatan' => $this->string(255)->notNull(),
            'kabkota_id' => $this->integer(),
        ], 'ENGINE=InnoDB CHARSET=utf8');

        // Add foreign key for table `kabupatenkota`
        $this->addForeignKey(
            'fk-kabupatenkota-provinsi_id',
            'kabupatenkota',
            'provinsi_id',
            'provinsi',
            'id',
            'CASCADE'
        );

        // Add foreign key for table `kecamatan`
        $this->addForeignKey(
            'fk-kecamatan-kabkota_id',
            'kecamatan',
            'kabkota_id',
            'kabupatenkota',
            'id',
            'CASCADE'
        );

        // Add foreign key for table `profile`
        $this->addForeignKey(
            'fk-profile-kecamatan_id',
            'profile',
            'kecamatan_id',
            'kecamatan',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-profile-kabkota_id',
            'profile',
            'kabkota_id',
            'kabupatenkota',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-profile-provinsi_id',
            'profile',
            'provinsi_id',
            'provinsi',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-profile-provinsi_id',
            'profile'
        );
        $this->dropForeignKey(
            'fk-profile-kabkota_id',
            'profile'
        );
        $this->dropForeignKey(
            'fk-profile-kecamatan_id',
            'profile'
        );

        // drops foreign key for table `kecamatan`
        $this->dropForeignKey(
            'fk-kecamatan-kabkota_id',
            'kecamatan'
        );

        // drops foreign key for table `kabupatenkota`
        $this->dropForeignKey(
            'fk-kabupatenkota-provinsi_id',
            'kabupatenkota'
        );

        $this->dropTable('kecamatan');
        $this->dropTable('kabupatenkota');
        $this->dropTable('provinsi');

        echo "m170511_093411_create_table_lokasi cannot be reverted.\n";
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
