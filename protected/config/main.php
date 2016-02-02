<?php
$db = explode('.',$_SERVER['SERVER_NAME'])[0];

$con['localhost'] = array(
        'class' => 'CDbConnection',
        'connectionString' => 'mysql:host=localhost;port=3306;dbname=pedidos',
        'emulatePrepare' => true,
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
);

//configurações padrão
$commonConfig = include '_common.main.php';

$personalConfig = array(
    'modules' => array(

          // uncomment the following to enable the Gii tool
          'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'123mudar',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters'=>array('127.0.0.1','::1'),
          ),

    ),
    // application components

    'components' => array(
        'db' => $con[$db]
    ),
);
return CMap::mergeArray($commonConfig, $personalConfig);
