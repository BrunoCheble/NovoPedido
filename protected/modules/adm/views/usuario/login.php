<?php echo Yii::app()->controller->module->registerCss('login.css'); ?>

<div class="BoxLogin">    
    <div style="clear:both;"></div>
        <div class="conteudoLogin">
            <div class="Login">
            <?php /** @var BootActiveForm $form */
                $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id'=>'verticalForm',
                    'htmlOptions'=>array('class'=>'span5 container-fluid border_radius shadow_box','id'=>'view_login'),
                    'enableClientValidation'=>false,
                        'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                        )
                )); ?>
                <fieldset class="row-fluid">
                    <legend>Login</legend>
                    <p class="InfoLogin">Já tenho login e senha.</p>
                    <?php echo $form->textFieldRow($model, 'username', array('class'=>'span10','prepend'=>'<i class="icon-user"></i>')); ?>
                    <?php echo $form->passwordFieldRow($model, 'password', array('class'=>'span10','prepend'=>'<i class="icon-lock"></i>')); ?>
                    <?php echo $form->checkBoxRow($model,'config'); ?>
                    <div class="btn_login">
                    <?php $this->widget('bootstrap.widgets.TbButton',
                        array(
                            'buttonType'=>'submit',
                            'label'=>'Entrar',
                            'type'=>'null', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                            'size'=>'small' // null, 'large', 'small' or 'mini'
                        ));
                    ?>

                    <?php echo CHtml::link('Esqueci a senha', array('esqueciASenha'), array('class'=>'btn btn-link','title'=>'Recuperar a senha','rel'=>'tooltip'))?>
                    </div>
                </fieldset>
            <?php $this->endWidget(); ?>
            <div class="clear"></div>
            </div>
        </div>
</div><!-- BoxLogin -->
    <div class="clear"></div>
<script>
    $(document).ready(function(){
        $("#LoginForm_username").focus();
    });
</script>