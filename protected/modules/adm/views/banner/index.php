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
        <div class="padd">
            <div class="row-fluid list-banner">
                <?php
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider' => $dataProvider,
                    'template' => '{items}',
                    'itemView' => '_view',
                ));
                ?>
            </div>
        </div>
    </div>
</div>
