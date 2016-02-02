<?php

$this->breadcrumbs=array(
	'Combinados'=>array('index'),
	$model->nome
);
?>

<?php $this->renderPartial('_form', array('model'=>$model,'modelProduto'=>$modelProduto)); ?>