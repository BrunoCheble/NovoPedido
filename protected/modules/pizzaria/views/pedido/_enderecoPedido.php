<div id="alert-nao-cadastrar" class="alert alert-info">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Aqui você não é obrigado a cadastrar-se.</strong>
    Preencha os campos e aperte em finalizar o pedido.
</div>
<div id="alert-sucesso-endereco" style="display: none" class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong></strong>
    Confirme os campos para a entrega do pedido e aperte em "finalizar o pedido".
</div>
<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'type'=>'vertical',
    'id' => 'form-pedido',
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'clientOptions' => array(
        'validationUrl' => $this->createUrl('pedido/ajaxValidate')
    ),
)); ?>
<fieldset style="margin-bottom: 1em;">
    <?php echo $form->textFieldRow($modelPedido, 'responsavel'); ?>
    <?php echo $form->textFieldRow($modelPedido, 'telefone'); ?>
    <?php echo $form->textFieldRow($modelPedido, 'bairro',array('disabled'=>true)); ?>
    <?php echo $form->textFieldRow($modelPedido, 'cep'); ?>
    <?php echo $form->hiddenField($modelPedido, '_endereco_id'); ?>
    <?php echo $form->textFieldRow($modelPedido, 'endereco',array('disabled'=>true)); ?>
    <?php echo $form->textFieldRow($modelPedido, 'numero'); ?>
    <?php echo $form->textFieldRow($modelPedido, 'complemento'); ?>
    <?php echo $form->textAreaRow($modelPedido, 'observacao', array('maxlength' => 255, 'rows' => 3, 'class' => 'span12','placeholder'=>'Alguma observação?')); ?>
</fieldset>

<div class="row-fluid">
<?php 
    $this->widget('bootstrap.widgets.TbButton', array(
        'label'       => 'Finalizar pedido',
        'type'        => 'success',
        'htmlOptions' => array('id'=>'confirmar-pedido')
    ));
?>
</div>

<?php $this->endWidget(); ?>    