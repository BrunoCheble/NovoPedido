<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'modal-itemcombinado')); ?>
 
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>Escolha os itens do combinado</h4>
</div>
 
<div class="modal-body">
    <div style="display:none" class="alert alert-info" id="message-combinado">
        <p></p>
    </div>
    <div class="modal-list-itemcombinado"></div>
</div>
 
<div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'=>'success',
        'label'=>'Já escolhi os itens',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal','id'=>'confirmar_itemcombinado'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Cancelar',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal'),
    )); ?>
</div>
 
<?php $this->endWidget(); ?>

<div style="display:none" id="item-modal-itemcombinado-modelo" class="item-itemcombinado-modal clearfix">
    <div class="img-itemcombinado">
        <?= CHtml::link(CHtml::image(""),"#",array('class'=>'thumbnail')); ?>
    </div>
    <div class="box-itemcombinado clearfix">
        <div class="info-itemcombinado">
            <h5 class="nome_itemcombinado"></h5>
            <p class="descricao_itemcombinado"></p>
        </div>
        <div class="btns-itemcombinado">
            <span class="modal_preco_itemcombinado"></span>
            <div>
            <?= CHtml::textField('ItemCombinadoPedido[quantidade]','',array('class'=>'span1'));?>
            </div>
        </div>
    </div>
</div>