<?php
/* @var $this ProdutoController */
/* @var $model Produto */

$this->breadcrumbs=array(
	'Sub-categoria'=>array('index'),
	'Editar',
);
?>

<?php $this->renderPartial('_form', array('model'=>$model,'arrayCategoria'=>$arrayCategoria)); ?>