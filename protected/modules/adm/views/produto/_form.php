<?php
/** @var BootActiveForm $form */
Yii::app()->clientScript->registerPackage('jquery-maskmoney');
?>

<script>
    $(document).ready(function() {
        $("#Produto_preco").maskMoney({decimal: ",", thousands: "."});
    });
</script>
<?php
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
                    'htmlOptions' => array('enctype' => 'multipart/form-data'),
                ));
                ?>

                <div class="padd">

                    <?php echo $form->textFieldRow($model, 'nome'); ?>
                    <?php echo $form->textFieldRow($model, 'preco', array('class' => 'input-medium', 'prepend' => 'R$ ')); ?>
                    <?php echo $form->checkBoxRow($model, 'preco_embalagem', array()); ?>
                    <?php echo $form->dropDownListRow($model, 'sub_categoria_id', $arraySubCategoria, array()); ?>
                    <?php echo $form->textAreaRow($model, 'descricao',array('class'=>'span5','rows'=>3)); ?>
                    <?php echo $form->fileFieldRow($model, 'foto'); ?>
                    
                </div>
                <div class="widget-foot">
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'success', 'label' => $model->isNewRecord ? 'Cadastrar' : 'Atualizar')); ?>
                </div>



<?php $this->endWidget(); ?>   
            </div>
        </div>
    </div>
    <div class="span3">
        <div class="widget">
            <!-- Widget title -->
            <div class="widget-head">
                Foto
            </div>
            <div class="widget-content">
                <div class="padd">
                    <?php
                    if ($model->foto) {
                        echo "<a href='#' class='thumbnail' rel='tooltip' data-title='" . $model->descricao . "'>";
                        echo CHtml::image(Yii::app()->controller->module->registerImageProtected('/produtos/' . $model->foto));
                        echo "</a>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>