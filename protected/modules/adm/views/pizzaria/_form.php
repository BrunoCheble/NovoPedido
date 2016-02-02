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
$model->pedido_min = number_format($model->pedido_min,2,',','.');
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
                    'id' => 'Pizzaria',
                    'type' => 'horizontal',
                    'htmlOptions' => array('enctype' => 'multipart/form-data'),
                ));
                ?>

                <div class="padd">
                    <?php echo $form->textFieldRow($model, 'nome', array('class'=>'input-medium')); ?>
                    <?php echo $form->fileFieldRow($model, 'logo'); ?>
                    <?php echo $form->textFieldRow($model, 'pedido_min', array('class'=>'input-medium', 'prepend'=>'R$ ')); ?>
                    <?php echo $form->textFieldRow($model, 'tempo_espera', array('class'=>'input-medium','placeholder'=>'45min - 50min')); ?>
                    <?php echo $form->dropDownListRow($model, 'tipo_restaurante', $arrayTipoRestaurante); ?>
                    
                    <div id="dados_pizzaria" style="display: <?php echo $model->tipo_restaurante == TipoRestaurante::_TIPO_PIZZARIA_ ? 'block' : 'none'; ?>">
                        <hr/>
                        <?php echo $form->dropDownListRow($model, 'adicional_pizza',  array('Não','Sim')); ?>
                        <?php echo $form->dropDownListRow($model, 'borda_pizza',  array('Não','Sim')); ?>
                        <?php echo $form->dropDownListRow($model, 'massa_pizza',  array('Não','Sim')); ?>
                        <?php echo $form->dropDownListRow($model, 'pratos_lanches',  array('Não','Sim')); ?>
                        
                    </div>
                    <hr/>
                    <?php echo $form->textFieldRow($model, 'bairro', array('class'=>'input-medium')); ?>
                    <?php echo $form->textFieldRow($model, 'endereco', array('class'=>'input-medium')); ?>
                    <?php echo $form->textFieldRow($model, 'telefone1', array('class'=>'input-medium')); ?>
                    <?php echo $form->textFieldRow($model, 'telefone2', array('class'=>'input-medium')); ?>
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
                Sua logo
            </div>
            <div class="widget-content">
                <div class="padd">
                    <?php
                    if ($model->logo) {
                        echo "<a href='#' class='thumbnail' rel='tooltip' data-title='" . $model->nome . "'>";
                        echo CHtml::image(Yii::app()->controller->module->registerImageProtected('/clientes/' . $model->logo));
                        echo "</a>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){

        $('#Pizzaria_tipo_restaurante').change(function(){
            if($(this).val() == <?= TipoRestaurante::_TIPO_PIZZARIA_; ?>)
                $('#dados_pizzaria').show();
            else
                $('#dados_pizzaria').hide();
        })
    })
</script>