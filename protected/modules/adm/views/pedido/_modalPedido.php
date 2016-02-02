
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'detalhesPedido')); ?>

<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>Detalhes do pedido</h4>
</div>

<div class="modal-body">
    <div>Status: <?= Status::getDescricao($model->status); ?></div>
<?php
$data_pedido = new DateTime($model->data_pedido);
$data_diff = $data_pedido->diff(new DateTime('NOW'));
?>
    <div>Data do pedido: <?= date("d/m/Y H:m:s", strtotime($model->data_pedido)) . " (" . $data_diff->h . ":" . $data_diff->i . ":" . $data_diff->s . ") atrás"; ?></div>
    <div>Cliente: <?= $model->responsavel; ?></div>
    <div>Telefone: <?= $model->telefone; ?></div>
    <div>Local: <?= $model->bairro . " - " . $model->endereco . ", " . $model->numero . " " . $model->complemento; ?></div>
    <div>Forma de pagamento: <?= $model->formaPagamentos->nome; ?></div>
    <div>Preço total: R$ <?= number_format($model->preco_total, 2, ',', '.'); ?></div>
    <div>Troco: R$ <?= number_format($model->troco, 2, ',', '.'); ?></div>
    <div>Observação: <?= $model->observacao; ?></div>
</div>

<div class="modal-footer">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'label' => 'Fechar',
        'url' => '#',
        'htmlOptions' => array('data-dismiss' => 'modal'),
    ));
    ?>
</div>

<?php $this->endWidget(); ?>