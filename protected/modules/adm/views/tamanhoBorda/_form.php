<?php
/** @var BootActiveForm $form */
Yii::app()->clientScript->registerPackage('jquery-maskmoney');
?>

<script>
    $(document).ready(function() {
        $("#TamanhoBorda_preco").maskMoney({decimal: ",", thousands: "."});
    });
</script>

<?php
/** @var BootActiveForm $form */
$model->preco = number_format($model->preco, 2, ',', '.');
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

                    <?php echo $form->dropDownListRow($model, 'borda_id', $arrayBorda); ?>
                    <?php echo $form->dropDownListRow($model, 'tamanho_id', $arrayTamanho); ?>
                    <?php echo $form->textFieldRow($model, 'preco', array('class' => 'input-medium', 'prepend' => 'R$ ')); ?>

                    <?php
                    if (!$model->isNewRecord)
                        echo $form->checkBoxRow($model, 'ativa', array());
                    ?>

                </div>
                <div class="widget-foot">
                    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'success', 'label' => $model->isNewRecord ? 'Cadastrar' : 'Atualizar')); ?>
                </div>

                <?php $this->endWidget(); ?>   
            </div>
        </div>
    </div>
</div>