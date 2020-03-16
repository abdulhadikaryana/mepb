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
class GentelellaElementsPluginAsset extends AssetBundle
{
    public $sourcePath = '@vendor/bower/gentelella/vendors';
    public $css = [
        'nprogress/nprogress.css',
        'iCheck/skins/flat/green.css',
        'bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css',
        'pnotify/dist/pnotify.css',
        'pnotify/dist/pnotify.buttons.css',
        'pnotify/dist/pnotify.nonblock.css'
    ];
    public $js = [
        'fastclick/lib/fastclick.js',
        'nprogress/nprogress.js',
        'bootstrap-progressbar/bootstrap-progressbar.min.js',
        'iCheck/icheck.min.js',
        'pnotify/dist/pnotify.js',
        'pnotify/dist/pnotify.buttons.js',
        'pnotify/dist/pnotify.nonblock.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
