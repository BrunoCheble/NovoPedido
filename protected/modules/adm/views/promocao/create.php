<?php
/* @var $this ProdutoController */
/* @var $model Produto */

$this->breadcrumbs=array(
	'Promoções'=>array('index'),
	'Cadastro',
);
?>

<?php $this->renderPartial('_form', array('model'=>$model,'modelTamanhoSabor'=>$modelTamanhoSabor,'modelProduto'=>$modelProduto)); ?>