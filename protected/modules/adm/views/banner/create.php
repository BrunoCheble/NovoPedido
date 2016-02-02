<?php
/* @var $this ProdutoController */
/* @var $model Produto */

$this->breadcrumbs=array(
	'Banners'=>array('index'),
	'Cadastro',
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>