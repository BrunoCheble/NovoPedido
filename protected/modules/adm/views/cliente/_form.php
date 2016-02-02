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
                    <?php echo $form->textFieldRow($model, 'nome'); ?>
                    <?php echo $form->textFieldRow($model, 'telefone'); ?>
                    <?php echo $form->textFieldRow($model, 'celular'); ?>
                    <?php echo $form->textFieldRow($model, 'bairro'); ?>
                    <?php echo $form->textFieldRow($model, 'cep'); ?>
                    <?php echo $form->textFieldRow($model, 'endereco'); ?>
                    <?php echo $form->textFieldRow($model, 'numero'); ?>
                    <?php echo $form->textFieldRow($model, 'complemento'); ?>

                    <hr/>
                    <?php echo $form->textFieldRow($modelUsuario, 'email'); ?>
                    <?php echo $form->passwordFieldRow($modelUsuario, 'senha'); ?>
                    <?php echo $form->passwordFieldRow($modelUsuario, 'senha2'); ?>
                    
                </div>
                <div class="widget-foot">
                    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'success', 'label' => $model->isNewRecord ? 'Cadastrar' : 'Atualizar')); ?>
                </div>



                <?php $this->endWidget(); ?>   
            </div>
        </div>
    </div>
</div>