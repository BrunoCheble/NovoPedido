<?php
/* @var $this ProdutoController */
/* @var $model Produto */

$this->breadcrumbs=array(
	'Adicionais'=>array('index'),
	'Cadastrar',
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>