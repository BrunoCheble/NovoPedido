<div class="widget">
    <!-- Widget title -->
    <div class="widget-head">
        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
            'label' => 'Cadastrar',
            'url' => array('create'),
            'type' => 'null', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'size' => 'null,', // null, 'large', 'small' or 'mini'
        ));
        ?>
    </div>
    <div class="widget-content">
        <?php
        $this->widget('bootstrap.widgets.TbGridView', array(
            'type' => 'striped bordered condensed',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'template' => "{items}{pager}{summary}",
            'columns' => array(
                'email',
		'ultimo_acesso',
		'cliente_id',
                array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'template'=>'{update} {delete}',
                    'htmlOptions' => array('style' => 'width: 50px'),
                ),
            ),
        ));
        ?>
    </div>
</div>
