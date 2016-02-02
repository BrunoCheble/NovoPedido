<h2>Esqueci minha senha</h2>
<p class="text-warning">Já tem login e senha mas a esqueceu? Coloque seu email abaixo para enviarmos as informações da sua conta.</p>

<?php 
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'RecuperarSenhaForm',
    'htmlOptions'=>array('class'=>'well'),
)); ?>
 
<?php echo $form->textFieldRow($model, 'email', array('class'=>'input-large', 'prepend'=>'<i class="icon-envelope"></i>')); ?>
<br />
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Recuperar')); ?>
 
<?php $this->endWidget(); ?>