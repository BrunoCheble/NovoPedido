<div class="alert alert">
    Selecione apenas a(s) promoção(ões) que seu pedido tem direito
</div>
<div class="box-content">
    <?php
    $dataPromocao->setPagination(false);
    $this->widget('zii.widgets.CListView', array(
        'dataProvider' => $dataPromocao,
        'template' => '{items}',
        'itemView' => '_promocoes',
        'htmlOptions' => array('style' => 'padding-top: 0', 'class' => 'list-promocao')
    ));
    ?>
</div>