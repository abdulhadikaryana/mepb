<?php

use yii\db\Migration;

class m170710_144454_edit_view_kegiatan extends Migration
{
    public function safeUp()
    {
        $view = <<<EOT
            CREATE OR REPLACE VIEW view_kegiatan AS
(SELECT 'penyebarluasan informasi' AS kegiatan, penyebarluasan.id, DATE_FORMAT(penyebarluasan.tanggal_entri, '%Y-%m-%d') AS tanggal_entri, penyebarluasan.lokasi, penyebarluasan.desakel AS desakel, penyebarluasan.kecamatan AS kecamatan, penyebarluasan.created_by, penyebarluasan.tema AS obyek, penyebarluasan.topik AS topik, user.username, user.id as userid, profile.fullname from user LEFT JOIN profile ON profile.user_id = user.id LEFT JOIN penyebarluasan ON penyebarluasan.created_by = user.id WHERE user.group=40) 
UNION (SELECT 'konsolidasi masalah' AS kegiatan, konsolidasi.id, DATE_FORMAT(konsolidasi.tanggal_entri, '%Y-%m-%d') AS tanggal_entri, konsolidasi.lokasi, konsolidasi.desakel AS desakel, konsolidasi.kecamatan AS kecamatan, konsolidasi.created_by, konsolidasi.metode AS obyek, konsolidasi.sub_metode AS topik, user.username, user.id as userid, profile.fullname from user LEFT JOIN profile ON profile.user_id = user.id LEFT JOIN konsolidasi ON konsolidasi.created_by = user.id WHERE user.group=40) 
UNION (SELECT 'pendataan' AS kegiatan, pendataan.id, DATE_FORMAT(pendataan.tanggal_entri, '%Y-%m-%d') AS tanggal_entri, pendataan.lokasi, pendataan.desakel AS desakel, pendataan.kecamatan AS kecamatan, pendataan.created_by, pendataan.obyek AS obyek, pendataan.name AS topik, user.username, user.id as userid, profile.fullname from user LEFT JOIN profile ON profile.user_id = user.id LEFT JOIN pendataan ON pendataan.created_by = user.id WHERE user.group=40)
ORDER BY kegiatan,id,tanggal_entri
EOT;
        $this->execute($view);
    }

    public function safeDown()
    {
        $dropview = <<<EOT
            DROP VIEW IF EXISTS view_kegiatan;
EOT;
        $this->execute($dropview);
        echo "m170710_144454_edit_view_kegiatan cannot be reverted.\n";
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170710_144454_edit_view_kegiatan cannot be reverted.\n";

        return false;
    }
    */
}
