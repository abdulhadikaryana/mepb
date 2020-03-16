<?php

/**
 * @package   yii2-grid
 * @author    Kartik Visweswaran <kartikv2@gmail.com>
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2016
 * @version   3.1.3
 */

namespace app\controllers;

use Yii;
use yii\helpers\HtmlPurifier;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Response;
use kartik\grid\GridView;
use kartik\mpdf\Pdf;

/**
 * ExportController manages actions for downloading the [[GridView]] tabular content in various export formats.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class ExportController extends Controller
{
    /**
     * Download the exported file
     *
     * @return mixed
     */
    public function actionDownload()
    {
        $request = Yii::$app->request;
        $type = $request->post('export_filetype', 'html');
        $name = $request->post('export_filename', 'export');
        $content = $request->post('export_content', 'No data found');
        $mime = $request->post('export_mime', 'text/plain');
        $encoding = $request->post('export_encoding', 'utf-8');
        $bom = $request->post('export_bom', true);
        $config = $request->post('export_config', '{}');
        if ($type == GridView::PDF) {
            $config = Json::decode($config);
            $this->generatePDF($content, "{$name}.pdf", $config);
            /** @noinspection PhpInconsistentReturnPointsInspection */
            return;
        }  elseif ($type == GridView::HTML) {
            $content = HtmlPurifier::process($content);
        } elseif (($type == GridView::CSV || $type == GridView::TEXT) && $encoding == 'utf-8' && $bom) {
            $content = chr(239) . chr(187) . chr(191) . $content; // add BOM
        }
        $this->setHttpHeaders($type, $name, $mime, $encoding);
        return $content;
    }

    /**
     * Generates the PDF file
     *
     * @param string $content the file content
     * @param string $filename the file name
     * @param array  $config the configuration for yii2-mpdf component
     *
     * @return void
     */
    protected function generatePDF($content, $filename, $config = [])
    {
        // $pdf = new Pdf([
        //     'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
        //     'content' => $content,
        //     'filename' => 'Laporan-penggiat-satu-bulan.pdf',
        //     // 'destination' => Pdf::DEST_DOWNLOAD,
        //     'destination' => Pdf::DEST_BROWSER,
        //     'format' => Pdf::FORMAT_A4,
        //     'orientation' => Pdf::ORIENT_PORTRAIT,
        //     // 'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
        //     'cssFile' => '@app/web/css/kv-mpdf-bootstrap.css',
        //     'cssInline' => '.kv-heading-1{font-size: 18px}',
        //     'options' => [
        //         'title' => 'Laporan Penggiat Budaya satu bulan',
        //         'subject' => 'Laporan Penggiat Budaya satu bulan'
        //     ],
        //     'methods' => [
        //         'SetHeader' => ['Dibuat oleh: penggiatbudaya.kemdikbud.go.id||Pada: ' . date("d M Y H:m:s")],
        //         'SetFooter' => ['|Hal {PAGENO}|'],
        //     ]
        // ]);

        unset($config['contentBefore'], $config['contentAfter']);
        $config['filename'] = $filename;
        $config['methods']['SetAuthor'] = ['Direktorat Jenderal Kebudayaan - Kementerian Pendidikan dan Kebudayaan'];
        $config['methods']['SetCreator'] = ['Direktorat Jenderal Kebudayaan'];
        $config['methods']['SetHeader'] = ['Dibuat oleh: penggiatbudaya.kemdikbud.go.id||Pada: ' . date("d M Y H:m:s")];
        $config['methods']['SetFooter'] = ['|Hal {PAGENO}|'];
        $config['content'] = $content;
        $pdf = new Pdf($config);
        echo $pdf->render();
    }

    /**
     * Sets the HTTP headers needed by file download action.
     *
     * @param string $type the file type
     * @param string $name the file name
     * @param string $mime the mime time for the file
     * @param string $encoding the encoding for the file content
     *
     * @return void
     */
    protected function setHttpHeaders($type, $name, $mime, $encoding = 'utf-8')
    {
        Yii::$app->response->format = Response::FORMAT_RAW;
        if (strstr($_SERVER["HTTP_USER_AGENT"], "MSIE") == false) {
            header("Cache-Control: no-cache");
            header("Pragma: no-cache");
        } else {
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Pragma: public");
        }
        header("Expires: Sat, 26 Jul 1979 05:00:00 GMT");
        header("Content-Encoding: {$encoding}");
        header("Content-Type: {$mime}; charset={$encoding}");
        header("Content-Disposition: attachment; filename={$name}.{$type}");
        header("Cache-Control: max-age=0");
    }
}