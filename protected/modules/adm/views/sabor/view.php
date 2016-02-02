<?php

$this->breadcrumbs=array(
	'Sabores'=>array('index'),
	$model->descricao
);
?>

<h1>Sabor: <?php echo $model->descricao; ?></h1>

<div class="row-fluid">
    <div class="span9">
    <?php $this->widget('bootstrap.widgets.TbDetailView', array(
            'data'=>$model,
            'attributes'=>array(
                    'descricao',
                    array(
                        'name' => 'tipo_sabor',
                        'value'=> TipoSabor::getDescricaoTipoSabor($model->tipo_sabor),
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
                    echo CHtml::image(Yii::app()->controller->module->registerImageProtected('/sabores/'.$model->foto));
                echo "</a>";
            echo "</div>";
        }
    ?>
</div>