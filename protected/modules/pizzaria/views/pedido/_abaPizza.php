<div id="list-card-pizza">
    <?php $this->renderPartial('_cardPizza',array('modelTamanho'=>$modelTamanho,'arrayTipoSabor'=>$arrayTipoSabor,'modelPizzaria' => $modelPizzaria)); ?>
</div>

<div id="modelo-thumb-sabor" style="display:none" class="thumb-sabor clearfix">
    <?= CHtml::link(CHtml::image(''),array(),array('class'=>'thumbnail hidden-phone')); ?>
    <div class="info-sabor">
        <h5 class="nome_sabor"></h5>
    </div>
</div>

<?php $this->renderPartial('_modalSabor'); ?>

<?php $this->renderPartial('_modalAdicional'); ?>

<div class="row-fluid">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>Yii::t('Pedido','Adicionar mais uma pizza'),
        'type'=>'warning', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'size'=>'null', // null, 'large', 'small' or 'mini'
        'htmlOptions' => array('class'=>'btn_add_pizza span3'),
    )); ?>
</div>