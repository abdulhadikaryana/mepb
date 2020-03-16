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
class GentelellaAdditionalProfilePluginAsset extends AssetBundle
{
    public $sourcePath = '@vendor/bower/gentelella/vendors';
    public $css = [
        'nprogress/nprogress.css',
        'bootstrap-daterangepicker/daterangepicker.css',
    ];
    public $js = [
        'fastclick/lib/fastclick.js',
        'nprogress/nprogress.js',
        'raphael/raphael.min.js',
        'morris.js/morris.min.js',
        'bootstrap-progressbar/bootstrap-progressbar.min.js',
        'moment/min/moment.min.js',
        'bootstrap-daterangepicker/daterangepicker.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
