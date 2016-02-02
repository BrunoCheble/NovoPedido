<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'modal-adicional')); ?>
 
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>Escolha o(s) adiciona(is) para o sabor da pizza clicado</h4>
</div>
 
<div class="modal-body">
    <div class="modal-list-adicional"></div>
</div>
 
<div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'=>'success',
        'label'=>'Já escolhi os adicionais',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal','id'=>'confirmar_adicional'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Cancelar',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal'),
    )); ?>
</div>
 
<?php $this->endWidget(); ?>

<div style="display:none" id="item-modal-adicional-modelo" class="item-adicional-modal clearfix">
    <div class="img-adicional">
        <?= CHtml::link(CHtml::image(""),"",array('class'=>'thumbnail')); ?>                    
    </div>
    <div class="box-adicional clearfix">
        <div class="info-adicional">
            <h5 class="nome_adicional"></h5>
        </div>
        <div class="btns-adicional">
            <span class="modal_preco_adicional"></span>
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'type'=>'success',
                'label'=>'Adicionar adicional',
                'url'=>'#',
                'size'=>'small', // null, 'large', 'small' or 'mini'
                'htmlOptions'=>array('class'=>'add-adicional'),
            )); ?>
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'type'=>'danger',
                'label'=>'Remover adicional',
                'url'=>'#',
                'size'=>'small', // null, 'large', 'small' or 'mini'
                'htmlOptions'=>array('class'=>'del-adicional', 'style'=>'display: none'),
            )); ?>
        </div>
    </div>
</div>