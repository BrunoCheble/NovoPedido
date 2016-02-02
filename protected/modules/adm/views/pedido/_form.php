<?php
/** @var BootActiveForm $form */
Yii::app()->clientScript->registerPackage('jquery-maskmoney');
?>

<script>
    $(document).ready(function() {
        $("#Pedido_preco_total,#Pedido_preco_taxa,#Pedido_troco,#Pedido_valor_pago").maskMoney({decimal: ",", thousands: "."});
    });
</script>

<?php
/** @var BootActiveForm $form */
$model->preco_total = number_format($model->preco_total, 2, ",", ".");
$model->preco_taxa = number_format($model->preco_taxa, 2, ",", ".");
$model->troco = number_format($model->troco, 2, ",", ".");
$model->valor_pago = number_format($model->valor_pago, 2, ",", ".");
?>

<div class="row-fluid">
    <div class="span9">
        <div class="widget">
            <!-- Widget title -->
            <div class="widget-head">
                Formulário
            </div>
            <div class="widget-content">
                <br/>
                <?php
                /** @var BootActiveForm $form */
                $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id' => 'horizontalForm',
                    'type' => 'horizontal',
                ));
                ?>

                <div class="padd">
                    <?php echo $form->textFieldRow($model, 'codigo',array('disabled'=>true)); ?>
                    <?php echo $form->dropDownListRow($model, 'status', $arrayStatus); ?>
                    <?php echo $form->textFieldRow($model, 'responsavel',array('class'=>'span8')); ?>
                    <?php echo $form->textFieldRow($model, 'telefone'); ?>
                    <?php echo $form->textAreaRow($model, 'observacao', array('class'=>'span8', 'rows'=>5)); ?>
                    <hr/>
                    <br/>
                    <?php echo $form->textFieldRow($model, 'preco_total'); ?>
                    <?php echo $form->textFieldRow($model, 'valor_pago'); ?>
                    <?php echo $form->dropDownListRow($model, 'forma_pagamento_id', $arrayFormaPagamento); ?>
                    <hr/>
                    <br/>
                    <?php echo $form->textFieldRow($model, 'bairro'); ?>
                    <?php echo $form->textFieldRow($model, 'cep'); ?>
                    <?php echo $form->textFieldRow($model, 'endereco'); ?>
                    <?php echo $form->textFieldRow($model, 'numero'); ?>
                    <?php echo $form->textFieldRow($model, 'complemento'); ?>

                </div>
                <div class="widget-foot">
                    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'success', 'label' => $model->isNewRecord ? 'Cadastrar' : 'Atualizar')); ?>
                </div>

                <?php $this->endWidget(); ?>   
            </div>
        </div>
    </div>
</div>