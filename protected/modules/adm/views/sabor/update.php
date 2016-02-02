<?php

$this->breadcrumbs=array(
	'Sabor'=>array('index'),
	$model->descricao
);
?>

<?php $this->renderPartial('_form', array('model'=>$model,'arrayTipoSabor'=>$arrayTipoSabor)); ?>