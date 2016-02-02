<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'feedback')); ?>

<?php
$modelFeedback = new Feedback;
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'type'                   => 'vertical',
    'id'                     => 'Feedback',
    'enableAjaxValidation'   => true,
    'enableClientValidation' => false,
    'clientOptions'          => array('validationUrl' => $this->createUrl('feedback/create')),
    'htmlOptions'            => array('style' => 'margin: 0')
    ));
?>

<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>Ajude-nos a fazer um bom serviço para você.</h4>
</div>

<div class="modal-body">
    <?php
    echo $form->textFieldRow($modelFeedback, 'nome', array('class' => '', 'placeholder' => 'Anônimo'));
    echo $form->dropDownListRow($modelFeedback, 'tipo', array('Erro', 'Sugestão', 'Outro'), array());
    echo $form->textAreaRow($modelFeedback, 'mensagem', array('rows' => 3, 'placeholder' => 'Descreva sua experiência e do que sentiu mais falta.'));
    ?>
</div>

<div class="modal-footer">
<?php
echo CHtml::ajaxSubmitButton("Enviar", $this->createUrl('feedback/ajaxSave'), array('success' => 'js:function(html){alert("Obrigado =)");}'), array('data-dismiss' => 'modal', 'class' => 'btn btn-success'));
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => 'Cancelar',
    'url' => '#',
    'htmlOptions' => array('data-dismiss' => 'modal'),
));
?>
</div>

<?php
$this->endWidget();
$this->endWidget();
?>