<?php
/* @var $this SubCategoriaController */
/* @var $model SubCategoria */

$this->breadcrumbs=array(
	'Tamanho'=>array('index'),
	'Cadastrar',
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>