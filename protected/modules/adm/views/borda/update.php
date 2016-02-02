<?php
$this->breadcrumbs=array(
	'Bordas'=>array('index'),
	$model->descricao
);
?>
<?php $this->renderPartial('_form', array('model'=>$model,'arrayTipoSabor'=>$arrayTipoSabor)); ?>