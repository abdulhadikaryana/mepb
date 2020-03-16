<?php
use yii\helpers\Url;

use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\services\DirectionsWayPoint;
use dosamigos\google\maps\services\TravelMode;
use dosamigos\google\maps\overlays\PolylineOptions;
use dosamigos\google\maps\services\DirectionsRenderer;
use dosamigos\google\maps\services\DirectionsService;
use dosamigos\google\maps\overlays\InfoWindow;
use dosamigos\google\maps\overlays\Marker;
use dosamigos\google\maps\Map;
use dosamigos\google\maps\services\DirectionsRequest;
use dosamigos\google\maps\overlays\Polygon;
use dosamigos\google\maps\layers\BicyclingLayer;

use app\assets\MapmarkerAsset;
use yii\web\JsExpression;

MapmarkerAsset::register($this);

$this->title = 'Contoh Maps Google';
?>
<div class="site-dashboard1">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <?php

                $center = new LatLng(['lat' => -1.802608, 'lng' => 117.692088]);
                $map = new Map([
                    'center' => $center,
                    'zoom' => 5,
                    'width' => '100%',
                    'height' => 500
                ]);

                $html = '
                    <div class="container" style="width:400px;max-width:400px;">
                        <div class="row">
                            <div class="col-sm-3"><img src="http://via.placeholder.com/75x75" width="75" height="75" /></div>
                            <div class="col-sm-7">
                                <h3 style="font-size:14px;margin-top:0;margin-bottom:5px;">Nama Tempat</h3>
                                <p style="font-size:11px;text-align:justify;">Deskripsi Tempat</p>
                            </div>
                        </div>
                        <div class="row" style="margin-top:10px;">
                            <div class="col-sm-6" style="text-align:center;"><a class="btn btn-brcustom btn-brgreen btn-lg" style="margin:5px auto;width:150px!important;height:auto!important;" href="#">VIEW BENEFIT</a></div>
                            <div class="col-sm-6" style="text-align:center;"><a class="btn btn-brcustom btn-brblack btn-lg" style="margin:5px auto;width:150px!important;height:auto!important;" href="#">GET STARTED</a></div>
                        </div>
                    </div>
                ';

                $coord = new LatLng(['lat' => -6.238584, 'lng' => 106.824075]);
                // Lets add a marker now
                $marker = new Marker([
                    'map' => $map,
                    'position' => $coord,
                    'title' => 'Titik Temu',
                    'icon' => Url::to('@web/images/konsolidasi-mark.png')
                ]);

                // Provide a shared InfoWindow to the marker
                $marker->attachInfoWindow(
                    new InfoWindow([
                        'content' => $html
                    ])
                );

                // Add marker to the map
                $map->addOverlay($marker);
                
                // Display the map -finally :)
                echo $map->display();

            ?>
        </div>
    </div>
</div>