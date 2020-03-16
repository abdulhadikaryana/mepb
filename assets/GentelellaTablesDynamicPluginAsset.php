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
class GentelellaTablesDynamicPluginAsset extends AssetBundle
{
    public $sourcePath = '@vendor/bower/gentelella/vendors';
    public $css = [
        'nprogress/nprogress.css',
        'iCheck/skins/flat/green.css',
        'datatables.net-bs/css/dataTables.bootstrap.min.css',
        'datatables.net-buttons-bs/css/buttons.bootstrap.min.css',
        'datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css',
        'datatables.net-responsive-bs/css/responsive.bootstrap.min.css',
        'datatables.net-scroller-bs/css/scroller.bootstrap.min.css'
    ];
    public $js = [
        'fastclick/lib/fastclick.js',
        'nprogress/nprogress.js',
        'iCheck/icheck.min.js',
        'datatables.net/js/jquery.dataTables.min.js',
        'datatables.net-bs/js/dataTables.bootstrap.min.js',
        'datatables.net-buttons/js/dataTables.buttons.min.js',
        'datatables.net-buttons-bs/js/buttons.bootstrap.min.js',
        'datatables.net-buttons/js/buttons.flash.min.js',
        'datatables.net-buttons/js/buttons.html5.min.js',
        'datatables.net-buttons/js/buttons.print.min.js',
        'datatables.net-fixedheader/js/dataTables.fixedHeader.min.js',
        'datatables.net-keytable/js/dataTables.keyTable.min.js',
        'datatables.net-responsive/js/dataTables.responsive.min.js',
        'datatables.net-responsive-bs/js/responsive.bootstrap.js',
        'datatables.net-scroller/js/dataTables.scroller.min.js',
        'jszip/dist/jszip.min.js',
        'pdfmake/build/pdfmake.min.js',
        'pdfmake/build/vfs_fonts.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
