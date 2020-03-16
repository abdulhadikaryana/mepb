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
class GentelellaFormAdvancedPluginAsset extends AssetBundle
{
    public $sourcePath = '@vendor/bower/gentelella/vendors';
    public $css = [
        'nprogress/nprogress.css',
        'bootstrap-daterangepicker/daterangepicker.css',
        'normalize-css/normalize.css',
        'ion.rangeSlider/css/ion.rangeSlider.css',
        'ion.rangeSlider/css/ion.rangeSlider.skinFlat.css',
        'mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css',
        'cropper/dist/cropper.min.css'
    ];
    public $js = [
        'fastclick/lib/fastclick.js',
        'nprogress/nprogress.js',
        'moment/min/moment.min.js',
        'bootstrap-daterangepicker/daterangepicker.js',
        'ion.rangeSlider/js/ion.rangeSlider.min.js',
        'mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js',
        'jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js',
        'jquery-knob/dist/jquery.knob.min.js',
        'cropper/dist/cropper.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
