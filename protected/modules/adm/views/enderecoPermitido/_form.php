<?php Yii::app()->clientScript->registerPackage('jquery-maskmoney'); ?>

<script>
    $(document).ready(function() {
        $("#EnderecoPermitido_frete").maskMoney({decimal: ",", thousands: "."});
    });
</script>

<?php
$model->frete = number_format($model->frete, 2, ',', '.');
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
                    'htmlOptions' => array('enctype' => 'multipart/form-data'),
                ));
                ?>

                <div class="padd">
                    <?php echo $form->textFieldRow($model, 'local'); ?>
                    <?php echo $form->textFieldRow($model, 'bairro'); ?>
                    <?php echo $form->textFieldRow($model, 'frete'); ?>
                </div>
                <div class="widget-foot">
                    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'success', 'label' => $model->isNewRecord ? 'Cadastrar' : 'Atualizar')); ?>
                </div>



                <?php $this->endWidget(); ?>   
            </div>
        </div>
    </div>
</div>