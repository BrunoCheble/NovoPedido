<div class="box-content">
    <?php
    $dataPratosLanche->setPagination(false);
    $this->widget('zii.widgets.CListView', array(
        'dataProvider'=>$dataPratosLanche,
        'template' => '{items}',
        'itemView'=>'_cardProduto'
    ));
    ?>
</div>