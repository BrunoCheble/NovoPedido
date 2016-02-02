<?php
//configurações padrão
$commonConfig = include '_common.console.php';

$personalConfig = array(
	'components'=>array(
		'db' => array(
			'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;port=3306;dbname=xmphp_pizzaria',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
		),
	),
);
                
return CMap::mergeArray($commonConfig,$personalConfig);
