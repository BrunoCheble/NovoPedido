<?php
/* @var $this ProdutoController */
/* @var $model Produto */

$this->breadcrumbs=array(
	'Tamanho'=>array('index'),
	'Editar',
);
?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>
