<?php
Yii::app()->clientScript->registerPackage('jquery-maskmoney');
?>

<script>
    $(document).ready(function() {
        $("#Combinado_preco").maskMoney({decimal: ",", thousands: "."});
    });
</script>

<?php
$model->preco = !empty($model->preco) ? number_format($model->preco, 2, ',', '.') : '';
/** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'horizontalForm',
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data')
));
?>
<div class="row-fluid">
    <div class="span6">
        <div class="widget">
            <!-- Widget title -->
            <div class="widget-head">
                Formulário
            </div>
            <div class="widget-content">
                <br/>

                <div class="padd">
                    <?php echo $form->textFieldRow($model, 'nome', array('class' => 'input-medium')); ?>
                    <?php echo $form->textFieldRow($model, 'preco', array('class' => 'input-medium', 'prepend' => 'R$ ')); ?>
                    <?php echo $form->textAreaRow($model, 'descricao', array('rows' => 6, 'cols' => 50)); ?>                    
                    <?php echo $form->fileFieldRow($model, 'foto'); ?>
                </div>                
                
                <div class="widget-foot">
                    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'success', 'label' => $model->isNewRecord ? 'Cadastrar' : 'Atualizar')); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="span6">

    	<div class="widget">
            <!-- Widget title -->
            <div class="widget-head">
                Itens disponível para o combinado
            </div>
            <div class="widget-content">
                
                <div class="padd">
                    <?php
	                    echo $form->dropDownList($model, '_produtoCombinado', $modelProduto, array('multiple'=>true,'style'=>'width: 100%; min-height: 250px'));
                    ?>
                </div>                
                
                <div class="widget-foot"></div>
            </div>
        </div>

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
                
                <div class="widget-foot"></div>
            </div>
        </div>
    </div>
    
</div>

<?php $this->endWidget(); ?>   