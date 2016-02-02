<div class="box-content">
    <?php
    $dataBebidas->setPagination(false);
    $this->widget('zii.widgets.CListView', array(
        'dataProvider'=>$dataBebidas,
        'template' => '{items}',
        'itemView'=>'_cardProduto'
    ));
    ?>
</div>