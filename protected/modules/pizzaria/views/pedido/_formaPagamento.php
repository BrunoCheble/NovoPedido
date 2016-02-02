<div id="forma-pagamento">
    <div id='dinheiro'>
        <h5 class='sub_titulo'>Precisa de troco?</h5>
        <div class="control-group">
        <span>Troco para: R$</span> 
        <?= CHtml::textField('Pedido[troco]', '', array('class' => 'span3')); ?>
        <?= CHtml::numberField('Pedido[troco]', '', array('class' => 'span3')); ?>
        <span style="font-size: .8em">(se não precisar, deixe como 0)</span>
        </div>
    </div>
</div>