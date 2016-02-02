<?php
//configurações padrão
$commonConfig = include '_common.console.php';

$personalConfig = array(
	'components'=>array(
		'db' => array(
			'class' => 'CDbConnection',
			'connectionString' => 'pgsql:host=localhost;port=5432;dbname=mpindustrial',
			'emulatePrepare' => false,
			'username' => 'postgres',
			'password' => 'victor',
			'charset' => 'utf8',
		),
	),
);
                
return CMap::mergeArray($commonConfig,$personalConfig);
