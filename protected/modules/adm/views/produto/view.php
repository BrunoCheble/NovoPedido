<?php
/* @var $this ProdutoController */
/* @var $model Produto */

$this->breadcrumbs=array(
	'Produtos'=>array('index'),
	$model->descricao
);
?>

<h1>Produto: <?php echo $model->descricao." (".$model->quantidade.")"; ?></h1>

<div class="row-fluid">
    <div class="span9">
    <?php $this->widget('bootstrap.widgets.TbDetailView', array(
            'data'=>$model,
            'attributes'=>array(
                    'descricao',
                    array(
                        'name' => 'preco',
                        'value' => "R$ ".number_format($model->preco,2,",","."),
                    ),
                    array(
                        'name' => 'preco_embalagem',
                        'value'=> $model->preco_embalagem == 1 ? 'Sim' : 'Não'
                    ),
                    'quantidade',
                    array(
                        'name' => 'sub_categoria_id',
                        'value'=> $model->subCategorias->descricao
                    ),
                    array(
                        'name' => 'ativa',
                        'value'=> $model->ativa == 1 ? 'Sim' : 'Não'
                    ),
            ),
    )); ?>
    </div>
    <?php
        if($model->foto){
            echo "<div class='span3'>";
                echo "<a href='#' class='thumbnail' rel='tooltip' data-title='".$model->descricao."'>";
                    echo CHtml::image(Yii::app()->controller->module->registerImageProtected('/produtos/'.$model->foto));
                echo "</a>";
            echo "</div>";
        }
    ?>
</div>
