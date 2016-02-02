<?php
    $attributes = array(
            'tempo_espera',
            array(
                'name'=>'pedido_min',
                'value'=>"R$ ".number_format($model->pedido_min,2,',','.')
            ),
            array(
                'name'=>'pratos_lanches',
                'value'=>$model->pratos_lanches ? 'Sim' : 'Não'
            ),
            array(
                'name'=>'ultimo_atualizacao',
                'value'=>!empty($model->ultimo_atualizacao) ? date("d/m/Y H:m:s", strtotime($model->ultimo_atualizacao)) : ""
            )
        );

    if($model->tipo_restaurante == TipoRestaurante::_TIPO_PIZZARIA_) {

        $attributes[] = array(
            'name'=>'borda_pizza',
            'value'=>$model->borda_pizza ? 'Sim' : 'Não'
        );

        $attributes[] = array(
            'name'=>'adicional_pizza',
            'value'=>$model->adicional_pizza ? 'Sim' : 'Não'
        );

        $attributes[] = array(
            'name'=>'massa_pizza',
            'value'=>$model->massa_pizza ? 'Sim' : 'Não'
        );
    }

    $this->widget('bootstrap.widgets.TbDetailView', array(
        'data'=>$model,
        'attributes'=> $attributes,
    ));

    $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Editar',
        'url' => array('update','id'=>$model->id),
        'type'=>'null', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'size'=>'null,', // null, 'large', 'small' or 'mini'
    ));

?>