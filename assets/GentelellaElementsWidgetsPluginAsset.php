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
class GentelellaElementsWidgetsPluginAsset extends AssetBundle
{
    public $sourcePath = '@vendor/bower/gentelella/vendors';
    public $css = [
        'nprogress/nprogress.css',
        'iCheck/skins/flat/green.css',
        'bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css'
    ];
    public $js = [
        'fastclick/lib/fastclick.js',
        'nprogress/nprogress.js',
        'Chart.js/dist/Chart.min.js',
        'jquery-sparkline/dist/jquery.sparkline.min.js',
        'jquery.easy-pie-chart/dist/jquery.easypiechart.min.js',
        'bootstrap-progressbar/bootstrap-progressbar.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
