<?php
$promocao = $data->promocao ? '<div class="span2 promocao"><i class="icon-flat-offer"></i></div>' : '';
?>
<div class="card-pedido-produto row-fluid">
    <div class="span3 hidden-print">
        <?= CHtml::image(Yii::app()->controller->module->registerImageProtected('/produtos/' . $data->produtos->foto),'',array()); ?>
    </div>
    <div class="span7">
        <div><b><span class="qtd_item"><?= $data->quantidade;?></span> - <?= $data->produtos->nome; ?></b></div>
        <div><?= $data->produtos->descricao; ?></div>
    </div>
     <?=$promocao;?>
</div>
