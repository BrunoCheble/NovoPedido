<?php
/* @var $this ProdutoController */
/* @var $model Produto */

$this->breadcrumbs=array(
	'Sabores'=>array('index'),
	'Cadastro',
);
?>

<?php $this->renderPartial('_form', array('model'=>$model,'arrayTipoSabor'=>$arrayTipoSabor)); ?>