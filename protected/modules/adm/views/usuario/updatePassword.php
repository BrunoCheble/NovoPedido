<?php


$form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'usuario-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data', 'class'=>'well'),
)); 

	echo $form->passwordFieldRow($model,'senha', array('class' => 'span2'));

	echo $form->passwordFieldRow($model,'senha2', array('class' => 'span2'));
    
    echo CHtml::openTag('div',array('class'=>'form-btns'));

        $this->widget(
                'bootstrap.widgets.TbButton', 
                array(
                    'type'=>'success', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                    'size'=>'small', // null, 'large', 'small' or 'mini'
                    'buttonType'=>'submit', 
                    'label'=> $model->isNewRecord ? Yii::t('Usuario','Cadastrar') : Yii::t('Usuario','Atualizar')
                )
        ); 
        echo CHtml::link('Cancelar',array('usuario/index'),array('class'=>'link','rel'=>'tooltip','data-title'=>'Ir para a tela de exibição de todos os usuários'));

    echo CHtml::closeTag('div');
        
$this->endWidget();

?>
