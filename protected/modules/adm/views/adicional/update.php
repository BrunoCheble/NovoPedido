<?php
/* @var $this ProdutoController */
/* @var $model Produto */

$this->breadcrumbs=array(
	'Adicionais'=>array('index'),
	'Editar',
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>