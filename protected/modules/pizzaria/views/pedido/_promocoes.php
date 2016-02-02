<?php
$valor = $data->valor ? $data->valor : 0;
?>

<div valor="<?= $valor; ?>" qtd-max="<?= $data->quantidade; ?>" valor-min="<?= $data->valor_min; ?>" desconto="<?= $data->desconto; ?>" class="row-fluid item-promocao">
    <div class="span8 info-promocao">
        <?= CHtml::checkBox('Promocao[id]',false, array('value'=>$data->id)); ?>
        <?= $data->descricao; ?>
    </div>
    <div class="span4">
        <div class="lista-cmp-item-promocao">
            <div class="cmp-item-promocao">
                <?php
                    $span = $data->quantidade == 0 ? 'span12' : 'span9';

                    echo CHtml::dropDownList('Pedido[item_promocao_id]', '',$data->getArrayItensPromocao(),array('class'=>$span,'disabled'=>true));

                    $visible = $data->quantidade > 0 ? '' : 'none';

                    echo CHtml::textField('Pedido[item_promocao_qtd]',$data->quantidade,array('class'=>'span3','disabled'=>true,'style'=>'display: '.$visible));

                ?>
            </div>
        </div>
        <?php
            if($data->quantidade > 0){
                $this->widget('bootstrap.widgets.TbButton', array(
                    'type'=>'null',
                    'label'=>'Dividir promoção',
                    'url'=>'#',
                    'block'=>true,
                    'size'=>'small', // null, 'large', 'small' or 'mini'
                    'htmlOptions'=>array('class'=>'div-promocao')
                ));
            }
            
        ?>
        <?php
            $this->widget('bootstrap.widgets.TbButton', array(
                'type'=>'success',
                'label'=>'Repetir promoção',
                'url'=>'#',
                'block'=>true,
                'size'=>'small', // null, 'large', 'small' or 'mini'
                'htmlOptions'=>array('class'=>'add-promocao'),
            ));
        ?>
    </div>
</div>