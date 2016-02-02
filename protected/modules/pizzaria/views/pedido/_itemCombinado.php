<?php
$valor = $data->valor ? $data->valor : 0;
?>

<div valor="" qtd-max="" class="row-fluid">
    <div class="span9 info-promocao">
        <?= CHtml::checkBox('ItemCombinado[produto_id]',false, array('value'=>$data->id)); ?>
        <?= $data->descricao; ?>
    </div>
    <div class="span3">
        <div class="lista-cmp-item-promocao">
            <div class="cmp-item-promocao">
                <?= CHtml::textField('ItemCombinado[item_promocao_qtd]','',array('class'=>'span6','disabled'=>true));?>
                <?= CHtml::textField('ItemCombinado[item_promocao_qtd]','',array('class'=>'span6','disabled'=>true));?>
            </div>
        </div>
    </div>
</div>