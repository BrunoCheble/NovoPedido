<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'modal-sabores')); ?>
 
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>Escolha o(s) sabor(es) desta pizza</h4>
</div>
 
<div class="modal-body">
    <div class="modal-list-sabores"></div>
</div>
 
<div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'=>'success',
        'label'=>'Já escolhi os sabores',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal','id'=>'confirmar_sabor'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Cancelar',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal'),
    )); ?>
</div>
 
<?php $this->endWidget(); ?>

<div style="display:none" id="item-modal-sabor-modelo" class="item-sabor-modal clearfix">
    <div class="img-sabor">
        <?= CHtml::link(CHtml::image(""),"#",array('class'=>'thumbnail')); ?>
    </div>
    <div class="box-sabor clearfix">
        <div class="info-sabor">
            <h5 class="nome_sabor"></h5>
            <p class="ingredientes"></p>
        </div>
        <div class="btns-sabor">
            <span class="modal_preco_sabor"></span>
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'type'=>'success',
                'label'=>'Adicionar sabor',
                'url'=>'#',
                'block'=>true,
                'size'=>'small', // null, 'large', 'small' or 'mini'
                'htmlOptions'=>array('class'=>'add-sabor'),
            )); ?>
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'type'=>'danger',
                'label'=>'Remover sabor',
                'url'=>'#',
                'block'=>true,
                'size'=>'small', // null, 'large', 'small' or 'mini'
                'htmlOptions'=>array('class'=>'del-sabor', 'style'=>'display: none'),
            )); ?>
        </div>
    </div>
</div>