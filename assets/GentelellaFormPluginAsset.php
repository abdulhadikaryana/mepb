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
class GentelellaFormPluginAsset extends AssetBundle
{
    public $sourcePath = '@vendor/bower/gentelella/vendors';
    public $css = [
        'nprogress/nprogress.css',
        'iCheck/skins/flat/green.css',
        'google-code-prettify/bin/prettify.min.css',
        'select2/dist/css/select2.min.css',
        'switchery/dist/switchery.min.css',
        'starrr/dist/starrr.css'
    ];
    public $js = [
        'fastclick/lib/fastclick.js',
        'nprogress/nprogress.js',
        'bootstrap-progressbar/bootstrap-progressbar.min.js',
        'iCheck/icheck.min.js',
        'moment/min/moment.min.js',
        'bootstrap-daterangepicker/daterangepicker.js',
        'bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js',
        'jquery.hotkeys/jquery.hotkeys.js',
        'google-code-prettify/src/prettify.js',

        'gauge.js/dist/gauge.min.js',
        
        
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
        'jqvmap/dist/jquery.vmap.js',
        'jqvmap/dist/maps/jquery.vmap.world.js',
        'jqvmap/examples/js/jquery.vmap.sampledata.js',
        'jquery.tagsinput/src/jquery.tagsinput.js',
        'switchery/dist/switchery.min.js',
        'select2/dist/js/select2.full.min.js',
        'parsleyjs/dist/parsley.min.js',
        'autosize/dist/autosize.min.js',
        'devbridge-autocomplete/dist/jquery.autocomplete.min.js',
        'starrr/dist/starrr.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
