<?php

use yii\db\Migration;

class m170609_031019_create_ulang_trigger_konsolidasi extends Migration
{
    public function safeUp()
    {
        $trigger = <<<EOT
            DROP TRIGGER IF EXISTS before_update_konsolidasi;
            CREATE TRIGGER before_update_konsolidasi
                BEFORE UPDATE ON konsolidasi
                FOR EACH ROW
            BEGIN
                INSERT INTO konsolidasi_history VALUES (NULL, OLD.id, OLD.created_by, OLD.updated_by, OLD.created_at, OLD.updated_at, OLD.tanggal_entri, 
                OLD.lokasi, OLD.desakel, OLD.kecamatan, OLD.kabupatenkota, OLD.provinsi, OLD.metode, OLD.sub_metode,
                OLD.deskripsi, OLD.solusi, OLD.foto1, OLD.foto2, OLD.foto3, OLD.latitude, OLD.longitude,
                OLD.setuju_status, OLD.setuju_tanggal, OLD.setuju_oleh, OLD.version, OLD.is_rev, OLD.rev_tanggal,
                OLD.rev_komentar, OLD.rev_oleh, OLD.rev_no, OLD.setuju_status_upt, OLD.setuju_tanggal_upt, OLD.setuju_oleh_upt, OLD.uuid);

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

    public function safeDown()
    {
        $droptrigger = <<<EOT
            DROP TRIGGER IF EXISTS before_update_konsolidasi;
EOT;
        $this->execute($droptrigger);
        echo "m170609_031019_create_ulang_trigger_konsolidasi cannot be reverted.\n";
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170609_031019_create_ulang_trigger_konsolidasi cannot be reverted.\n";

        return false;
    }
    */
}
