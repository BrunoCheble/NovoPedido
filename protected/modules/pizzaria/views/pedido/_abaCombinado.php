<div id="list-card-combinado">
    <?php $this->renderPartial('_cardCombinado',array('listCombinado'=>$listCombinado)); ?>
</div>

<div id="modelo-thumb-itemcombinado" style="display:none" class="span2 thumb-itemcombinado clearfix">
    <?= CHtml::link(CHtml::image(''),array(),array('class'=>'thumbnail hidden-phone')); ?>
    <div class="info-sabor">
        <h5 class="nome_itemcombinado"></h5>
        
        <div class="input-prepend">
		  <span class="add-on">Qtd.</span>
		  <input id="prependedInput" type="text" class="quantidade_itemcombinado span5">
		</div>
    </div>
</div>

<?php $this->renderPartial('_modalItemCombinado'); ?>

<div class="row-fluid">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>Yii::t('Pedido','Adicionar mais um combinado'),
        'type'=>'warning', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'size'=>'null', // null, 'large', 'small' or 'mini'
        'htmlOptions' => array('class'=>'btn_add_combinado'),
    )); ?>
</div>