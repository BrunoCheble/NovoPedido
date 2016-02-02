<?php
/* @var $this ProdutoController */
/* @var $model Produto */
$this->breadcrumbs=array(
	'Tamanho Tipo da massa'=>array('index'),
	'Editar',
);
?>

<?php $this->renderPartial('_form', array('model'=>$model,'arrayTamanho'=>$arrayTamanho, 'arrayTipoMassa' => $arrayTipoMassa)); ?>