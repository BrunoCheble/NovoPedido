<div id="<?= $data->id; ?>" class="span3 <?= $data->ativo ? "ativo" : "desativado" ?>">
    <?php
        echo CHtml::image(Yii::app()->controller->module->registerImageProtected('/promocoes/' . $data->imagem));
    ?>
    <?php 
        $this->widget('bootstrap.widgets.TbButton', array(
        'label' => $status = $data->ativo ? "Desativar" : "Ativar",
        'type'  => 'inverse', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'size'  => 'null', // null, 'large', 'small' or 'mini'
        'block' => true,
        'url'   => array("updateStatus","id"=>$data->id),
        ));
    ?>
    <?php 
        $this->widget('bootstrap.widgets.TbButton', array(
        'label' => "Editar",
        'type'  => 'null', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'size'  => 'null', // null, 'large', 'small' or 'mini'
        'block' => true,
        'url'   => array("update","id"=>$data->id),
        ));
    ?>  
</div>