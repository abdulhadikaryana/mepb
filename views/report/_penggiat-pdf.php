<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Laporan Bulanan Penggiat Budaya</title>
        <style>
        .page{
            padding:0cm .5cm 2cm .5cm;
        }
        table{border-spacing:0; border-collapse: collapse; width: 100%;}
        table.pdf-table td, table.pdf-table th {border: 1px solid #ccc; padding: 0px 5px 0px 5px}
        .text-center{
            text-align: center;
        }
        </style>
    </head>
    <body>
        <div class="page">
            <table class="pdf-header table table-condensed">
                <tr>
                    <td width="15%"><img src="<?php echo Url::to('@web/images/logo-kemdikbud.png', true);?>"></td>
                    <td>
                        <h4>LAPORAN BULANAN PENGGIAT BUDAYA</h4>
                        <table class="table">
                            <tr>
                                <td width="15%">
                                    Nama
                                </td>
                                <td>
                                    : <?=strtoupper(Yii::$app->user->identity->fullname); ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="15%">
                                    Bulan
                                </td>
                                <td>
                                    <?php
                                        $bulan = array(
                                            '01' => 'Januari',
                                            '02' => 'Februari',
                                            '03' => 'Maret',
                                            '04' => 'April',
                                            '05' => 'Mei',
                                            '06' => 'Juni',
                                            '07' => 'Juli',
                                            '08' => 'Agustus',
                                            '09' => 'September',
                                            '10' => 'Oktober',
                                            '11' => 'November',
                                            '12' => 'December',
                                        );
                                    ?>
                                    : <?php
                                        if(!empty($period['month'] && !empty($period['year']))) {
                                            echo $bulan[$period['month']] . ' ' .$period['year'];
                                        } else {
                                            echo $bulan[date('m')] . ' ' .$period['year'];
                                        }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Penempatan
                                </td>
                                <td>
                                    : <?=\Yii::$app->user->identity->kabkota_id ? \Yii::$app->user->identity->kabkota->nama_kabkota : '-'?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Provinsi
                                </td>
                                <td>
                                    : <?=\Yii::$app->user->identity->provinsi_id ? \Yii::$app->user->identity->provinsi->nama_provinsi : '-'?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <hr/><br/>
            <table border="0" class="pdf-table">
                <tr>
                    <th valign="top">No.</th>
                    <th valign="top">Tgl</th>
                    <th valign="top">Kegiatan</th>
                    <th valign="top">Tema/Obyek/Metode</th>
                    <th valign="top">Topik/Nama/Sub Metode</th>
                    <th valign="top">Lokasi</th>
                </tr>
                <?php
                    $no = 1;
                    foreach($dataProvider->getModels() as $penggiat) {
                ?>
                <tr>
                    <td valign="top"><?=$no++;?></td>
                    <td valign="top"><?=date('d', strtotime($penggiat['tanggal_entri'])); /*Yii::$app->formatter->format($penggiat->tanggal_entri, 'date');*/?></td>
                    <td valign="top"><?=ucwords($penggiat['kegiatan']);?></td>
                    <td valign="top"><?=$penggiat['obyek'];?></td>
                    <td valign="top"><?=$penggiat['topik'];?></td>
                    <td valign="top"><?=$penggiat['kecamatan'];?></td>
                </tr>
                <?php
                    }
                ?>
            </table>
            <br/>
            <p style="text-align: right;"><?=date('d-m-Y');?></p>
            <br/>
            <table border="0">
                <tr>
                    <td style="text-align: center;">Menyetujui<br/><?=Yii::$app->user->identity->dinas ? Yii::$app->user->identity->dinas->jabatan : '-'?></td>
                    <td width="25%"></td>
                    <td style="text-align: center;">Mengetahui<br/><?=Yii::$app->user->identity->upt ? Yii::$app->user->identity->upt->jabatan : '-'?></td>
                </tr>
                <tr>
                    <td height="2 cm" style="text-align: center;"></td>
                    <td></td>
                    <td style="text-align: center;"></td>
                </tr>
                <tr>
                    <td style="text-align: center; border-bottom: 1px solid #000"><?= Yii::$app->user->identity->dinas ? Yii::$app->user->identity->dinas->fullname : '-';?></td>
                    <td width="35%"></td>
                    <td style="text-align: center; border-bottom: 1px solid #000"><?= Yii::$app->user->identity->upt ? Yii::$app->user->identity->upt->fullname : '-';?></td>
                </tr>
            </table>
        </div>
    </body>
</html>
