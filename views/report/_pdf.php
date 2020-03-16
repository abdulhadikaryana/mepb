<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Laporan Bulanan Penggiat Budaya Berdasarkan Jumlah Data Input</title>
        <style>
        .page{
            padding:0cm 1cm 2cm 1cm;
        }
        table{border-spacing:0; border-collapse: collapse; width: 100%;}
        table.pdf-table td, table.pdf-table th {border: 1px solid #ccc;}
        .text-center{
            text-align: center;
        }
        </style>
    </head>
    <body>
        <div class="page">
            <table class="pdf-header table table-condensed">
                <tr>
                    <td width="18%"><img src="<?php echo Url::to('@web/images/logo-kemdikbud.png', true);?>"></td>
                    <td class="text-center">
                        <h4>KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN</h4>
                        <h5>DIREKTORAT JENDERAL KEBUDAYAAN</h6>
                        <p>
                            Komplek Kemdikbud Gedung E Lantai IV Jl. Jenderal Sudirman, Senayan Jakarta 10270<br />
                            Telp: (021) 5725035, 5731062 Faksimili: (021) 5725578, 5731063<br/>
                            http://kebudayaan.kemdikbud.go.id email: kebudayaan@kemdikbud.go.id
                        </p>
                    </td>
                </tr>
            </table>
            <hr/><br/>
            <table border="0" class="pdf-table">
                <tr>
                    <th>No.</th>
                    <th>Penggiat</th>
                    <th>Penyebarluasan</th>
                    <th>Konsolidasi</th>
                    <th>Pendataan</th>
                </tr>
                <?php
                    $no = 1;
                    foreach($dataProvider->getModels() as $penggiat) {
                ?>
                <tr>
                    <td><?=$no++;?></td>
                    <td><?=$penggiat['fullname'] == null ? $penggiat['username'] : $penggiat['fullname'];?></td>
                    <td><?=$penggiat['penyebarluasan'];?></td>
                    <td><?=$penggiat['konsolidasi'];?></td>
                    <td><?=$penggiat['pendataan'];?></td>
                </tr>
                <?php
                    }
                ?>
            </table>
        </div>
    </body>
</html>
