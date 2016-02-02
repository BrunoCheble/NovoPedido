<?php
/* @var $this TamanhoSaborController */
/* @var $model TamanhoSabor */

$this->breadcrumbs=array(
	'Tamanho Sabores'=>array('index'),
	'Cadastrar',
);

?>

<?php $this->renderPartial('_form', array('model'=>$model,'arrayTamanho'=>$arrayTamanho, 'arraySabor' => $arraySabor)); ?>