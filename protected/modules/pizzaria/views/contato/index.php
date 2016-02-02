<h1>Contato</h1>
<!--Content-->      
<div class="row-fluid">
    <?php
    foreach (Yii::app()->user->getFlashes() as $key => $message)
        echo '<div class="alert alert-' . $key . '">' . $message . "</div>\n";


    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'contato',
        'enableClientValidation' => false,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        )
    ));

    echo $form->errorSummary($model, null, null, array('class' => 'alert alert-error'));
    ?>

    <div class="row-fluid">
        <div class="span4">
            <div class="control-group">  
                <div class="controls">
                    <?php echo $form->textField($model, 'name', array('class' => 'input-block-level', 'placeholder' => $model->getAttributeLabel('name'))); ?>
                </div>
            </div>  
            <div class="control-group">  
                <div class="controls">  
                    <?php echo $form->textField($model, 'email', array('class' => 'input-block-level', 'placeholder' => $model->getAttributeLabel('email'))); ?>
                </div>
            </div>
            <?php echo $form->textField($model, 'subject', array('class' => 'input-block-level', 'placeholder' => $model->getAttributeLabel('subject'))); ?>
        </div><!--End Span4-->

        <div class="span8">
            <div class="control-group">  
                <div class="controls">  
                    <?php echo $form->textArea($model, 'message', array('class' => 'input-block-level', 'rows' => 8, 'placeholder' => $model->getAttributeLabel('message'))); ?>
                </div>
            </div>  
            <div class="text-right">  
                <?php echo CHtml::submitButton('Enviar', array('class' => 'btn btn-success')); ?>
            </div>
        </div><!--End Span8-->
    </div>
    <?php $this->endWidget(); ?>


</div><!--End Row-->


<!--Map Section-->
<section id="map">
    <iframe style='width: 100%; height: 200px; border:1px solid #ccc; ' src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=atlanta&amp;aq=&amp;sll=32.678125,-83.178297&amp;sspn=8.89966,16.907959&amp;ie=UTF8&amp;hq=&amp;hnear=Atlanta,+Fulton,+Georgia&amp;t=m&amp;z=6&amp;iwloc=A&amp;output=embed"></iframe>
</section>