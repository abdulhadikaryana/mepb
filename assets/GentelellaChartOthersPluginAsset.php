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
class GentelellaChartOthersPluginAsset extends AssetBundle
{
    public $sourcePath = '@vendor/bower/gentelella/vendors';
    public $css = [
        'nprogress/nprogress.css',
        'iCheck/skins/flat/green.css',
        'jqvmap/dist/jqvmap.min.css'
    ];
    public $js = [
        'fastclick/lib/fastclick.js',
        'nprogress/nprogress.js',
        'jquery-sparkline/dist/jquery.sparkline.min.js',
        'jqvmap/dist/jquery.vmap.js',
        'jqvmap/dist/maps/jquery.vmap.world.js',
        'jqvmap/dist/maps/jquery.vmap.usa.js',
        'jqvmap/examples/js/jquery.vmap.sampledata.js',
        'jquery.easy-pie-chart/dist/jquery.easypiechart.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
