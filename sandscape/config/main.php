<?php

$db = include 'db.php';
$params = include 'params.php';

Yii::setPathOfAlias('bootstrap', dirname(__FILE__) . '/../extensions/yiistrap');
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Sandscape',
    'defaultController' => 'sandscape',
    'import' => array(
        'application.models.*',
        'application.models.game.*',
        'application.components.*',
        'application.extensions.*',
        //
        'bootstrap.behaviors.*',
        'bootstrap.form.*',
        'bootstrap.helpers.*',
        'bootstrap.widgets.*'
    ),
    'components' => array(
        'bootstrap' => array(
            'class' => 'bootstrap.components.TbApi',
        ),
        'clientScript' => array(
            'scriptMap' => array(
                'jquery.js' => false,
                'jquery.min.js' => false,
                'jquery-ui.js' => false,
                'jquery-ui.min.js' => false,
                'jquery-ui.css' => false
            )
        ),
        'user' => array(
            'allowAutoLogin' => true,
            'class' => 'WebUser',
            'loginUrl' => array('sandscape/login'),
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'rules' => array(
                //'<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<id:\d+>/<action:\w+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>'
            ),
            'showScriptName' => false
        ),
        'db' => $db,
        'errorHandler' => array(
            'errorAction' => 'sandscape/error'
        ),
    ),
    'params' => $params
);
