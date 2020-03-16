<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class GentelellaDashboard3PluginAsset extends AssetBundle
{
    public $sourcePath = '@vendor/bower/gentelella/vendors';
    public $css = [
        'nprogress/nprogress.css',
        'bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css',
        'bootstrap-daterangepicker/daterangepicker.css'
    ];
    public $js = [
        'fastclick/lib/fastclick.js',
        'nprogress/nprogress.js',
        'Chart.js/dist/Chart.min.js',
        'jquery-sparkline/dist/jquery.sparkline.min.js',
        'raphael/raphael.min.js',
        'morris.js/morris.min.js',
        'gauge.js/dist/gauge.min.js',
        'bootstrap-progressbar/bootstrap-progressbar.min.js',
        'skycons/skycons.js',
        'Flot/jquery.flot.js',
        'Flot/jquery.flot.pie.js',
        'Flot/jquery.flot.time.js',
        'Flot/jquery.flot.stack.js',
        'Flot/jquery.flot.resize.js',
        'flot.orderbars/js/jquery.flot.orderBars.js',
        'flot-spline/js/jquery.flot.spline.min.js',
        'flot.curvedlines/curvedLines.js',
        'DateJS/build/date.js',
        'moment/min/moment.min.js',
        'bootstrap-daterangepicker/daterangepicker.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
