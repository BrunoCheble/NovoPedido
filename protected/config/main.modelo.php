<?php

//configurações padrão
$commonConfig = include '_common.main.php';

$personalConfig = array(
    'modules' => array(
    /*
      // uncomment the following to enable the Gii tool
      'gii'=>array(
      'class'=>'system.gii.GiiModule',
      'password'=>'lal',
      // If removed, Gii defaults to localhost only. Edit carefully to taste.
      'ipFilters'=>array('127.0.0.1','::1'),
      ),
     */
    ),
    // application components
    'components' => array(
        'db' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'pgsql:host=localhost;port=5432;dbname=xm_pizzaria',
            'emulatePrepare' => false,
            'username' => 'postgres',
            'password' => 'xm3040',
            'charset' => 'utf8',
        ),
    ),
);
return CMap::mergeArray($commonConfig, $personalConfig);
