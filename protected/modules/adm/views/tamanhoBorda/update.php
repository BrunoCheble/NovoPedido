<?php
/* @var $this ProdutoController */
/* @var $model Produto */
$this->breadcrumbs=array(
	'Tamanho Borda'=>array('index'),
	'Editar',
);
?>

<?php $this->renderPartial('_form', array('model'=>$model,'arrayTamanho'=>$arrayTamanho, 'arrayBorda' => $arrayBorda)); ?>