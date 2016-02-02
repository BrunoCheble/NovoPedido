<div class="widget">
    <!-- Widget title -->
    <div class="widget-head">
        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
            'label' => 'Cadastrar',
            'url' => array('create'),
            'type' => 'null', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'size' => 'mini,', // null, 'large', 'small' or 'mini'
        ));
        ?>
    </div>
    <div class="widget-content">
<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped bordered condensed',
    'dataProvider'=>$model->naoExcluido()->search(),
    'filter'=>$model,
    'template'=>"{items}",
    'columns'=>array(
        'descricao',
        'tamanho',
        'max_qtd_sabor',
        array(
            'name' => 'ativo',
            'filter' => array(0 => "Não", 1 => "Sim"),
            'type' => 'raw',
            'value' => 'CHtml::link($data->ativo ? "Desativar" : "Ativar",array("updateStatus","id"=>$data->id),array("title"=>"Ativar / Desativar"))',
        ),
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{update} {delete}',
            'htmlOptions'=>array('style'=>'width: 50px'),
        ),
    ),
)); ?>


    </div>
</div>
