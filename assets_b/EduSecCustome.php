<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets_b;

use yii\web\AssetBundle;


class EduSecCustome extends AssetBundle
{
    public $basePath = '@webroot';
    //public $baseUrl = '@web';
    public $sourcePath = '@bower/admin-lte';
    public $css = [
		//'css/AdminLTE.css',
    ];
    public $js = [
		'js/responsive-tabs.js',
    ];
    public $jsOptions = [
    		'position' => \yii\web\View::POS_HEAD
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
	'yii\bootstrap\BootstrapPluginAsset',
    ];
}