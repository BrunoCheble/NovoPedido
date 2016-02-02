<?php
/* @var $this TamanhoSaborController */
/* @var $model TamanhoSabor */

$this->breadcrumbs=array(
	'Tamanho Adicionais'=>array('index'),
	'Cadastrar',
);

?>

<?php $this->renderPartial('_form', array('model'=>$model,'arrayTamanho'=>$arrayTamanho, 'arrayAdicional' => $arrayAdicional)); ?>