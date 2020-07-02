<?php

if(file_exists(__DIR__.'/config/db.php')) {
    header('Location: index.php');
    die;
}

$chekerPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'components';
require_once($chekerPath . DIRECTORY_SEPARATOR. 'EdusecRequirementChecker.php');
$requirementsChecker = new EdusecRequirementChecker();

$resultsData = $requirementsChecker->getResult(); 
$summary = $resultsData['summary'];

if($summary['errors'] > 0) {
	header('Location: edusec-requirements.php');
	die;
}
defined('YII_DEBUG') or define('YII_DEBUG', true);
require(__DIR__ . '/vendor/autoload.php');
require(__DIR__ . '/vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/config/install-config.php');
(new yii\web\Application($config))->run();
?>

