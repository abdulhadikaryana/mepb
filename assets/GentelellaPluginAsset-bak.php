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
class GentelellaPluginAsset extends AssetBundle
{
    public $sourcePath = '@vendor/bower/gentelella/vendors';
    public $css = [
        'nprogress/nprogress.css',
        'iCheck/skins/flat/green.css',
        'bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css',
        'jqvmap/dist/jqvmap.min.css',
        'fullcalendar/dist/fullcalendar.min.css',
        'fullcalendar/dist/fullcalendar.print.css',
        'datatables.net-bs/css/dataTables.bootstrap.min.css',
        'datatables.net-buttons-bs/css/buttons.bootstrap.min.css',
        'datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css',
        'datatables.net-responsive-bs/css/responsive.bootstrap.min.css',
        'datatables.net-scroller-bs/css/scroller.bootstrap.min.css',
        'google-code-prettify/bin/prettify.min.css',
        'select2/dist/css/select2.min.css',
        'switchery/dist/switchery.min.css',
        'starrr/dist/starrr.css',
        'bootstrap-daterangepicker/daterangepicker.css',
        'normalize-css/normalize.css',
        'ion.rangeSlider/css/ion.rangeSlider.css',
        'ion.rangeSlider/css/ion.rangeSlider.skinFlat.css',
        'mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css',
        'cropper/dist/cropper.min.css',
    ];
    public $js = [
        'fastclick/lib/fastclick.js',
        'nprogress/nprogress.js',
        'echarts/dist/echarts.min.js',
        'Chart.js/dist/Chart.min.js',
        'jquery-sparkline/dist/jquery.sparkline.min.js',
        'raphael/raphael.min.js',
        'morris.js/morris.min.js',
        'gauge.js/dist/gauge.min.js',
        'bootstrap-progressbar/bootstrap-progressbar.min.js',
        'iCheck/icheck.min.js',
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
        'moment/min/moment.min.js',
        'fullcalendar/dist/fullcalendar.min.js',
        'bootstrap-daterangepicker/daterangepicker.js',
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
        'pdfmake/build/vfs_fonts.js',
        'bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js',
        'jquery.hotkeys/jquery.hotkeys.js',
        'google-code-prettify/src/prettify.js',
        'jquery.tagsinput/src/jquery.tagsinput.js',
        'switchery/dist/switchery.min.js',
        'select2/dist/js/select2.full.min.js',
        'parsleyjs/dist/parsley.min.js',
        'autosize/dist/autosize.min.js',
        'devbridge-autocomplete/dist/jquery.autocomplete.min.js',
        'starrr/dist/starrr.js',
        'ion.rangeSlider/js/ion.rangeSlider.min.js',
        'mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js',
        'jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js',
        'jquery-knob/dist/jquery.knob.min.js',
        'cropper/dist/cropper.min.js',
        'validator/validator.js',
        'jQuery-Smart-Wizard/js/jquery.smartWizard.js',
        'dropzone/dist/min/dropzone.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
