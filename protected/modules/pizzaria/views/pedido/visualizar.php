
<h1 class="visible-desktop"><?= Yii::t('Pedido', 'Consulte o seu pedido'); ?></h1>

<?php

if (!isset($model->status))
{
    $heading = $naoEncontrado;
    $text    = "Caso não encontre o código, ligue para: ".Yii::app()->params['telefone1']." ou ".Yii::app()->params['telefone2'];
}
else {
    $data_pedido = new DateTime($model->data_pedido);
    $data_dif    = $data_pedido->diff(new DateTime('NOW'));
    $tipoStatus  = Status::getDescricao($model->status);
    $heading     = "Tempo de espera: ".$data_dif->h.":".$data_dif->i.":".$data_dif->s;
    $text        = "Status do pedido: ".$tipoStatus;
}

$this->beginWidget('bootstrap.widgets.TbHeroUnit', array(
'heading'=>$heading,
));

echo "<h3 style='display:inline-block;'>Número do pedido: </h3>";

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'Pedido',
    'action' => array('pedido/visualizar'),
    'htmlOptions'=> array('class'=>'form-search','style'=>'margin: 0 0 0 10px; display:inline-block')
));
echo '<div class="input-append">';
    echo $form->textField($model,'codigo',array('class'=>'input search-query','placeholder'=>'Seu pedido'));
    echo CHtml::htmlButton('<i class="icon-search"></i>',array('type' => 'submit','class'=>'btn'));
echo '</div>';

$this->endWidget();

echo "<h4>".$text."</h4>";

$this->endWidget();

?>
