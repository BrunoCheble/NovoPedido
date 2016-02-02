<div class="alert alert-info">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Já sou cadastrado!</strong>
    Efetuando seu login suas informações já serão preenchidas automáticamente.
</div>
<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'usuario-form',
    'type'=>'vertical',
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'clientOptions' => array(
        'validationUrl' => $this->createUrl('loginForm/ajaxValidate')
    ),
)); ?>
 
<fieldset style="margin-bottom: 1em;">
    <?php echo $form->textFieldRow($loginForm, 'username'); ?>
    <?php echo $form->passwordFieldRow($loginForm, 'password'); ?>
</fieldset>
    <?= CHtml::ajaxSubmitButton(
        "Entrar",
        $this->createUrl('loginForm/ajaxLogin'),
        array('success' => 'js:function(data){
            if(data != "false"){
                showEnderecoPedido($.parseJSON(data),"Logado com sucesso!");
            }else{
                jQuery().toastmessage("showToast", {
                        text: "Login ou senha inválido(s)",
                        type: "error",
                        sticky: false,
                        stayTime: 3000,
                });
            }
        }'),
        array('class'=>'btn btn-success')
     );
    ?>
<?php $this->endWidget(); ?>    