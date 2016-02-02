<div class="alert alert-info">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Cadastrando-se agora, </strong>
    não precisará preencher novamente suas informações.
</div>
<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'type'=>'vertical',
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'clientOptions' => array(
        'validationUrl' => $this->createUrl('cliente/ajaxValidate')
    )
)); ?>
 
<fieldset style="margin-bottom: 1em;">
    <?php echo $form->textFieldRow($modelCliente, 'nome'); ?>
    <?php echo $form->textFieldRow($modelCliente, 'telefone'); ?>
    <?php echo $form->textFieldRow($modelCliente, 'celular'); ?>
    <?php echo $form->textFieldRow($modelCliente, 'bairro',array('disabled'=>true)); ?>
    <?php echo $form->textFieldRow($modelCliente, 'cep'); ?>
    <?php echo $form->hiddenField($modelCliente, '_endereco_id'); ?>
    <?php echo $form->textFieldRow($modelCliente, 'endereco',array('disabled'=>true)); ?>
    <?php echo $form->textFieldRow($modelCliente, 'numero'); ?>
    <?php echo $form->textFieldRow($modelCliente, 'complemento'); ?>

    <?php echo $form->textFieldRow($modelUsuario, 'email'); ?>
    <?php echo $form->passwordFieldRow($modelUsuario, 'senha'); ?>
    <?php echo $form->passwordFieldRow($modelUsuario, 'senha2'); ?>
</fieldset>
 
<?=
CHtml::ajaxSubmitButton("Cadastrar", $this->createUrl('cliente/ajaxSave'), array('success' => 'js:function(html){
                    if (html.indexOf("{")==0) {
                        $("#cliente-form .errorMessage").hide();
                        var e = $.parseJSON(html);
                        $.each(e, function(key, value) {
                            $("#"+key+"_em_").show().html(value.toString());
                            $("#"+key).addClass("clsError");
                            $("label[for="+key+"]").addClass("clsError");
                        });
                    }else{
                        if(html == 1){
                            var array = [];
 
                            array["responsavel"] = $("#Cliente_nome").val();
                            array["telefone"]    = $("#Cliente_telefone").val();
                            
                            array["numero"]      = $("#Cliente_numero").val();
                            array["cep"]         = $("#Cliente_cep").val();
                            array["complemento"] = $("#Cliente_complemento").val();
                            
                            showEnderecoPedido(array,"Cadastrado com sucesso!");
                        }
                    }
                }'),
        array('class'=>'btn btn-success'));
?>

<?php $this->endWidget(); ?>    