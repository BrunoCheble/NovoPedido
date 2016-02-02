<div produto-id="<?= $data->id; ?>" class="item-produto row-fluid">
    <div class="span2 thumb-produto">        
        <?php
        $img = '<img data-src="'.Yii::app()->controller->module->registerImageProtected('/produtos/'.$data->foto).'" />';
        echo CHtml::link($img,'#',array('class'=>'thumbnail'));
        ?>
    </div>
    <div class="span10 info-produto">
        <span style="float: right;" class="preco-produto">R$ <?= number_format($data->preco,2,',','.'); ?> </span>
        <h4><?= empty($data->sub_categoria_id) ? '' : $data->subCategorias->descricao.': '; ?><?= $data->nome; ?></h4>
        <p class="peso"><?= $data->descricao; ?></p>
        <?= CHtml::dropDownList('Produtos[quantidade]', '', array(
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
            5 => 5,
        ),array('empty'=>'Nenhum','style'=>'width: 100px; display:inline-block;')); ?>
        
    </div>
</div>
