<?php
/* @var $this ProdutoController */
/* @var $model Produto */

$this->breadcrumbs=array(
	'Produtos'=>array('index'),
	'Editar o produto: '.$model->nome,
);
?>

<?php $this->renderPartial('_form', array(
                                    'model'=>$model,
                                    'arrayCategoria' => $arrayCategoria,
                                    'arraySubCategoria' => $arraySubCategoria
                                    )
        ); ?>