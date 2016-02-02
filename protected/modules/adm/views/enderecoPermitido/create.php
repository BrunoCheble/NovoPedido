<?php
/* @var $this ProdutoController */
/* @var $model Produto */

$this->breadcrumbs=array(
	'Endereços permitidos'=>array('index'),
	'Cadastro',
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>