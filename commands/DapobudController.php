<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\httpclient\Client;
use yii\helpers\Json;
use yii\db\Query;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class DapobudController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex()
    {
        $connection = \Yii::$app->db;	
        
        $service_url = 'https://penggiat.dapobud.kemdikbud.go.id/web/mobile-api';
        $client = new Client(['baseUrl' => $service_url]);
        // $tanggal = '2017-07-01';
        $tanggal = date('Y-m-d');
        $response = $client->createRequest()
                    ->setMethod('get')
                    ->setUrl('api/data-by-date')
                    ->setData(['date' => $tanggal])
                    ->addHeaders(['content-type' => 'application/json'])
                    ->send();
        
        if($response->isOk) {
            $datas = Json::decode($response->content);
            $i = 0;
            // var_dump($datas);die();
            foreach($datas as $data) {
                $user = \app\models\User::findOne(['email' => $data['email']]);
                $time = strtotime($data['tanggal_entri']);
                // var_dump($user);die();
                $cekmodel = \app\models\Pendataan::findOne(['dataid' => $data['dataid'], 'obyek' => $data['jenis'], 'created_by' => $user->id]);
                // var_dump($cekmodel);die();
                if(empty($cekmodel)) {
                    $model = new \app\models\Pendataan;
                    $model->created_by = $user ? $user->id : 1;
                    $model->updated_by = $user ? $user->id : 1;
                    $model->created_at = $time;
                    $model->updated_at = $time;
                    $model->tanggal_entri = $data['tanggal_entri'];
                    $model->name = $data['nama'] ? $data['nama'] : '-';
                    $model->lokasi = $data['desakel'] ? $data['desakel'] : '-';
                    $model->desakel = $data['desakel'] ? $data['desakel'] : '-';
                    $model->kecamatan = $data['kecamatan'] ? $data['kecamatan'] : '-';
                    $model->kabupatenkota = $data['kabupatenkota'] ? $data['kabupatenkota'] : '-';
                    $model->provinsi = $data['provinsi'] ? $data['provinsi'] : '-';
                    $model->dataid = $data['dataid'];
                    $model->obyek = $data['jenis'] ? $data['jenis'] : '-';
                    $model->jumlah_data = 1;
                    $model->latitude = $data['latitude'];
                    $model->longitude = $data['longitude'];

                    $model->save(false);
                    $i++;
                }
            }
            echo "Insert data di tanggal " . $tanggal . " sebanyak " . $i . ' dari ' . count($datas) . " data selesai\r\n";
        } else {
            echo "Insert data di tanggal ". $tanggal . " Gagal. Response Server: " . $response->statusCode . "\r\n";
        }
    }

    public function actionManual($tanggal)
    {
        $connection = \Yii::$app->db;	
        
        $service_url = 'https://penggiat.dapobud.kemdikbud.go.id/web/mobile-api';
        $client = new Client(['baseUrl' => $service_url]);
        // $tanggal = '2017-07-01';
        // $tanggal = date('Y-m-d');
        $response = $client->createRequest()
                    ->setMethod('get')
                    ->setUrl('api/data-by-date')
                    ->setData(['date' => $tanggal])
                    ->addHeaders(['content-type' => 'application/json'])
                    ->send();
        
        if($response->isOk) {
            $datas = Json::decode($response->content);
            $i = 0;
            foreach($datas as $data) {
                $user = \app\models\User::findOne(['email' => $data['email']]);
                $time = strtotime($data['tanggal_entri']);
                // var_dump($user);die();
                $cekmodel = \app\models\Pendataan::findOne(['dataid' => $data['dataid'], 'obyek' => $data['jenis']]);
                // var_dump($cekmodel);die();
                if(empty($cekmodel)) {
                    $model = new \app\models\Pendataan;
                    $model->created_by = $user ? $user->id : 1;
                    $model->updated_by = $user ? $user->id : 1;
                    $model->created_at = $time;
                    $model->updated_at = $time;
                    $model->tanggal_entri = $data['tanggal_entri'];
                    $model->name = $data['nama'] ? $data['nama'] : '-';
                    $model->lokasi = $data['desakel'] ? $data['desakel'] : '-';
                    $model->desakel = $data['desakel'] ? $data['desakel'] : '-';
                    $model->kecamatan = $data['kecamatan'] ? $data['kecamatan'] : '-';
                    $model->kabupatenkota = $data['kabupatenkota'] ? $data['kabupatenkota'] : '-';
                    $model->provinsi = $data['provinsi'] ? $data['provinsi'] : '-';
                    $model->dataid = $data['dataid'];
                    $model->obyek = $data['jenis'] ? $data['jenis'] : '-';
                    $model->jumlah_data = 1;
                    $model->latitude = $data['latitude'];
                    $model->longitude = $data['longitude'];

                    $model->save(false);
                    $i++;
                }
            }
            echo "Insert data di tanggal " . $tanggal . " sebanyak " . $i . ' dari ' . count($datas) . " data selesai\n\r";
        } else {
            echo "Insert data di tanggal ". $tanggal . " Gagal. Response Server: " . $response->statusCode. "\r\n";
        }
    }
}
