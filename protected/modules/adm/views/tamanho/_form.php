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
                    <?php echo $form->textFieldRow($model, 'descricao'); ?>
                    <?php echo $form->textFieldRow($model, 'tamanho'); ?>
                    <?php echo $form->dropDownListRow($model, 'max_qtd_sabor',array(1=>1,2=>2,3=>3,4=>4)); ?>
                </div>
                <div class="widget-foot">
                    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'success', 'label' => $model->isNewRecord ? 'Cadastrar' : 'Atualizar')); ?>
                </div>



                <?php $this->endWidget(); ?>   
            </div>
        </div>
    </div>
    
</div>