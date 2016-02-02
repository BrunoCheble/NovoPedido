<style>
    .card-pedido-pizza{margin-bottom: 1em;}
    .list-view{padding-top: 0;}
</style>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>

<?php
   Yii::app()->clientScript->registerScript('scriptPedidos',
        "

        $(document).on('click','.confirmar-preparando',function(e){
            e.preventDefault();

            //if($(this).parent('nav').find('select').val() == ''){
                //alert('Selecione um entregador');
                //return false;
            //}

            $.ajax({
                type: 'POST',
                url: '".Yii::app()->createAbsoluteUrl('adm/pedido/updateStatus')."',
                data: {
                    id: $(this).attr('data-id'),
                    status: ".Status::_TIPO_FILA_ENTREGA_."
                },
                success: function(e){
                    if(e != '1')
                        alert(e);
                    else{
                        window.location.href = 'cozinha';
                    }
                }
            });
        });

        setInterval(function() {
            
            $.fn.yiiListView.update(
                'preparando',
                {
                    error: function(jqXHR, status) {

                            window.location.href = '".Yii::app()->createAbsoluteUrl('adm/usuario/login')."';
                    }
                }
            );
        
        }, ".(Yii::app()->params['tempoValidacao']/2).");
        ", CClientScript::POS_END
    );
?>

<div class="row-fluid">
    <div class="span4">

        <div class="widget">
            <!-- Widget title -->
            <div class="hidden-print widget-head">
                Pedidos em aberto
            </div>
            <div class="widget-content">
                <?php
                $dataPedidosPreparando->setPagination(false);
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider' => $dataPedidosPreparando,
                    'template' => '{items}',
                    'id' => 'preparando',
                    'htmlOptions' => array('class'=>'cards-pedido'),
                    'itemView' => '_pedido',
                ));
                ?>                
            </div>
        </div>

    </div>

    <?php

    if($modelPizzaria->tipo_restaurante == TipoRestaurante::_TIPO_PIZZARIA_) {
        $data = array('dataProvider' => $dataPizzas,'itemView' => '_pizza', 'title'=>'Lista de pizzas');
    }
    else
        $data = array('dataProvider' => $dataCombinados,'itemView' => '_combinado', 'title'=>'Lista de combinados');


    ?>
    <div class="span4">
        <div class="widget">
            <!-- Widget title -->
            <div class="widget-head">
                <?= $data['title']; ?>
            </div>
            <div class="widget-content">
                <div id="list-pizza" class="padd">
                    <?php
                        if(!empty($model)){

                            $data['dataProvider']->setPagination(false);
                            $this->widget('zii.widgets.CListView', array(
                                'dataProvider' => $data['dataProvider'],
                                'template' => '{items}',
                                'itemView' => $data['itemView'],
                            ));
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="span4">
        <div class="widget">
            <!-- Widget title -->
            <div class="widget-head">
                Lista de lanches e bebidas
            </div>
            <div class="widget-content">
                <div class="padd">
                    <?php
                        if(!empty($model)){
                            $dataProdutoPedido->setPagination(false);
                            $this->widget('zii.widgets.CListView', array(
                                'dataProvider' => $dataProdutoPedido,
                                'template' => '{items}',
                                'itemView' => '_produtos',
                            ));
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>