<?php

$this->breadcrumbs=array(
	'Pedidos'=>array('index'),
	'Editar',
);
?>

<?php $this->renderPartial('_form', array('model'=>$model,'arrayStatus'=>$arrayStatus,'arrayFormaPagamento'=>$arrayFormaPagamento)); ?>