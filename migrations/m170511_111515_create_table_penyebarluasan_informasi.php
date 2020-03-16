<?php

use yii\db\Migration;

class m170511_111515_create_table_penyebarluasan_informasi extends Migration
{
    public function up()
    {
        $this->createTable('penyebarluasan', [
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
            'metode' => "ENUM('Langsung', 'Tidak Langsung')",
            'tema' => $this->string(255)->notNull(),
            'topik' => $this->string(255)->notNull(),
            'audiens' => $this->integer(3),
            'deskripsi' => $this->text(),
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

        $this->createTable('penyebarluasan_history', [
            'id' => $this->primaryKey(),
            'penyebarluasan_id' => $this->integer(),
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
            'metode' => "ENUM('Langsung', 'Tidak Langsung')",
            'tema' => $this->string(255)->notNull(),
            'topik' => $this->string(255)->notNull(),
            'audiens' => $this->integer(3),
            'deskripsi' => $this->text(),
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

        // add foreign key for table `hpenyebarluasan_history`
        $this->addForeignKey(
            'fk-history_penyebarluasan-penyebarluasan_id',
            'penyebarluasan_history',
            'penyebarluasan_id',
            'penyebarluasan',
            'id',
            'CASCADE'
        );

        // Trigger

        $trigger = <<<EOT
            DROP TRIGGER IF EXISTS before_update_penyebarluasan;
            CREATE TRIGGER before_update_penyebarluasan
                BEFORE UPDATE ON penyebarluasan
                FOR EACH ROW
            BEGIN
                INSERT INTO penyebarluasan_history VALUES (NULL, OLD.id, OLD.created_by,
                    OLD.updated_by, OLD.created_at, OLD.updated_at, OLD.tanggal_entri, OLD.lokasi, OLD.desakel,
                    OLD.kecamatan, OLD.kabupatenkota, OLD.provinsi, OLD.metode, OLD.tema, OLD.topik, OLD.audiens, 
                    OLD.deskripsi, OLD.foto1, OLD.foto2, OLD.foto3, OLD.latitude, OLD.longitude, OLD.setuju_status, OLD.setuju_tanggal, 
                    OLD.setuju_oleh, OLD.version, OLD.is_rev, OLD.rev_tanggal, OLD.rev_komentar, OLD.rev_oleh,
                    OLD.rev_no);

                IF NEW.is_rev = TRUE THEN
                    IF OLD.rev_no IS NULL THEN 
                    	SET NEW.rev_no = 1;
                    ELSE 
                    	SET NEW.rev_no = OLD.rev_no + 1;
                    END IF;
                END IF;

                IF OLD.deskripsi <> NEW.deskripsi THEN 
                    SET NEW.version = OLD.version + 1;
                    SET NEW.is_rev = FALSE;
                    SET NEW.rev_tanggal = NULL;
                    SET NEW.rev_komentar = NULL;
                    SET NEW.rev_oleh = NULL;
                    SET NEW.rev_no = OLD.rev_no;
                END IF;

            END
EOT;

        $this->execute($trigger);  
    }

    public function down()
    {
        $droptrigger = <<<EOT
            DROP TRIGGER IF EXISTS before_update_penyebarluasan;
EOT;
        $this->execute($droptrigger);    
        $this->dropForeignKey(
            'fk-history_penyebarluasan-penyebarluasan_id',
            'penyebarluasan_history'
        );
        $this->dropTable('penyebarluasan_history');
        $this->dropTable('penyebarluasan');
        echo "m170511_111515_create_table_penyebarluasan_informasi cannot be reverted.\n";
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
