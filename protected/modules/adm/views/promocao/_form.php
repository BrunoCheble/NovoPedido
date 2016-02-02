<?php
Yii::app()->clientScript->registerPackage('jquery-maskmoney');
?>

<script>
    $(document).ready(function() {
        $("#Promocao_valor_min,#Promocao_valor").maskMoney({decimal: ",", thousands: "."});
    });
</script>

<?php
$model->valor = number_format($model->valor, 2, ',', '.');
$model->valor_min = number_format($model->valor_min, 2, ',', '.');
/** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'horizontalForm',
    'type' => 'horizontal',
));
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

                <div class="padd">
                    <?php echo $form->textFieldRow($model, 'valor', array('class' => 'input-medium', 'prepend' => 'R$ ')); ?>
                    <?php echo $form->textFieldRow($model, 'valor_min', array('class' => 'input-medium', 'prepend' => 'R$ ')); ?>
                    <?php echo $form->textFieldRow($model, 'quantidade', array('class' => 'input-medium')); ?>
                    <?php echo $form->textAreaRow($model, 'descricao', array('rows' => 6, 'cols' => 50)); ?>
                </div>                
                
                <div class="widget-foot">
                    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'success', 'label' => $model->isNewRecord ? 'Cadastrar' : 'Atualizar')); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="span3">
        <div class="widget">
            <!-- Widget title -->
            <div class="widget-head">
                Itens disponível para a promoção
            </div>
            <div class="widget-content">
                
                <div class="padd">
                    <?php
                    $itemProduto = $form->dropDownList($model, '_produtoPromocao', $modelProduto, array('multiple'=>true,'style'=>'width: 100%; min-height: 250px'));
                    
                    $tabs = array(
                            array('label'=>'Pratos, Lanches e bebidas', 'content'=>$itemProduto, 'active'=>true),
                    );

                    if(!empty($modelTamanhoSabor)){
                        $itemPizza   = $form->dropDownList($model, '_pizzaPromocao', $modelTamanhoSabor, array('multiple'=>true,'style'=>'width: 100%; min-height: 250px'));
                        $tabs[] = array('label'=>'Pizzas', 'content'=>$itemPizza);
                    }

                    $this->widget('bootstrap.widgets.TbTabs', array(
                        'type' => 'tabs',
                        'tabs' => $tabs,
                    )); ?>
                </div>                
                
                <div class="widget-foot"></div>
            </div>
        </div>
    </div>
    
</div>

<?php $this->endWidget(); ?>   