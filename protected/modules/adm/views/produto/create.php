<?php
/* @var $this ProdutoController */
/* @var $model Produto */

$this->breadcrumbs=array(
	'Produtos'=>array('index'),
	'Cadastro',
);
?>

<?php $this->renderPartial('_form', array(
                                    'model'=>$model,
                                    'arrayCategoria' => $arrayCategoria,
                                    'arraySubCategoria' => $arraySubCategoria
                                    )
        ); ?>