<?php

$this->breadcrumbs=array(
	'Promoções'=>array('index'),
	$model->id
);
?>

<?php $this->renderPartial('_form', array('model'=>$model,'modelTamanhoSabor'=>$modelTamanhoSabor,'modelProduto'=>$modelProduto)); ?>