<?php
/* @var $this SubCategoriaController */
/* @var $model SubCategoria */

$this->breadcrumbs=array(
	'Sub Categorias'=>array('index'),
	'Cadastrar',
);
?>

<?php $this->renderPartial('_form', array('model'=>$model,'arrayCategoria'=>$arrayCategoria)); ?>