<style>
    .card-pedido-pizza{margin-bottom: 1em;}
    .list-view{padding-top: 0;}
</style>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<script>
    var directionsDisplay;
    var directionsService = new google.maps.DirectionsService();
    var map;

    var start = '<?= $modelPizzaria->endereco . ' - ' . $modelPizzaria->bairro; ?>';
    var end = '<?= $model->endereco . ' ' . $model->numero . ' -' . $model->bairro; ?> - Rio de janeiro - RJ';


    function initialize() {
        $('#trajeto-texto').empty();
        $('#auto-map').show();

        directionsDisplay = new google.maps.DirectionsRenderer();

        map = new google.maps.Map(document.getElementById('mapa'));
        directionsDisplay.setMap(map);
        
        calcRoute();
    }

    function calcRoute()
    {

        var request = {
            origin: start,
            destination: end,
//            waypoints: [
//            {
//              location:"Rua joaquim Martins 311 - Piedade, Rio de janeiro",
//              stopover:true
//            },
//            ],
//            optimizeWaypoints: true,
            travelMode: google.maps.TravelMode.DRIVING
        };

        directionsService.route(request, function(response, status)
        {
            if (status == google.maps.DirectionsStatus.OK) {
                $('#new-map, #nao-encontrado').hide();
                $('#show-new-map').show();
                
                directionsDisplay.setDirections(response);
                directionsDisplay.setPanel(document.getElementById("trajeto-texto"));
            } else {
                $('#new-map, #nao-encontrado').show();
                $('#auto-map, #show-new-map').hide();
            }
        });
    }

    google.maps.event.addDomListener(window, 'load', initialize);

    $(document).ready(function() {

        $('.confirmar_pedido').click(function(){
            $.ajax({
                type: 'POST',
                url: '<?= Yii::app()->createAbsoluteUrl("adm/pedido/updateStatus"); ?>',
                data: {
                    status: 2,
                    id:  <?= $model->id; ?>
                },
                success: function(e){
                    window.location.href = '<?= Yii::app()->createAbsoluteUrl("adm/pedido/dashboard"); ?>'
                }
            });
        });


        $('.cancelar_pedido').click(function(){
            $.ajax({
                type: 'POST',
                url: '<?= Yii::app()->createAbsoluteUrl("adm/pedido/updateStatus"); ?>',
                data: {
                    status: 6,
                    id:  <?= $model->id; ?>
                },
                success: function(e){
                    if(e != '1')
                        alert('Pedido atualizado com sucesso.');

                }
            });
        });

        $('#start').val(start);
        $('#end').val(end);
        
        $('#show-new-map').click(function(){
            $('#new-map').show();
            $('#auto-map').hide();
        });
        
        $('#print').click(function() {
            window.print();
        });

        $('#btn-map').click(function() {

            start = $('#start').val();
            end = $('#end').val();

            initialize();
        });
    });

</script>
<div class="row-fluid">
    <div class="span4">

        <div class="widget">
            <!-- Widget title -->
            <div class="hidden-print widget-head">

                <?php
                $this->widget('bootstrap.widgets.TbButton', array(
                    'label' => 'Exibir detalhes',
                    'type' => 'null', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                    'size' => 'null', // null, 'large', 'small' or 'mini'
                    'htmlOptions' => array(
                        'data-toggle' => 'modal',
                        'data-target' => '#detalhesPedido',
                    ),
                ));
                ?>
                <?php
                $this->widget('bootstrap.widgets.TbButton', array(
                    'label' => 'Editar pedido',
                    'url' => array('update', 'id' => $model->id),
                    'type' => 'null', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                    'size' => 'null', // null, 'large', 'small' or 'mini'
                ));
                ?>
                <?php
                $this->widget('bootstrap.widgets.TbButton', array(
                    'label' => 'Imprimir pedido',
                    'htmlOptions' => array(
                        'id' => 'print',
                    ),
                    'type' => 'null', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                    'size' => 'null', // null, 'large', 'small' or 'mini'
                ));
                ?>
            </div>
            <div class="widget-content">
                <div class="padd">    
                    <div><b>Cliente:</b> <?= $model->responsavel; ?></div>
                    <div><b>Telefone:</b> <?= $model->telefone; ?></div>
                    <div><b>Endereço:</b> <?= $model->endereco . ", " . $model->numero . " " . $model->complemento . " - " . $model->bairro; ?></div>
                    
                    <div><b>Observação:</b> <?= $model->observacao; ?></div>
                    <hr/>
                    <?php

                    if(Yii::app()->user->isAdmin()){

                        $this->widget('bootstrap.widgets.TbButton', array(
                            'label' => 'Confirmar pedido',
                            'type'  => 'success', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                            'size'  => 'mini', // null, 'large', 'small' or 'mini'
                            'htmlOptions' => array(
                                'class'    => 'confirmar_pedido',
                                'style' =>'margin-bottom: 10px;'
                            ),
                        ));

                        $this->widget('bootstrap.widgets.TbButton', array(
                            'label' => 'Cancelar pedido',
                            'type'  => 'danger', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                            'size'  => 'mini', // null, 'large', 'small' or 'mini'
                            'htmlOptions' => array(
                                'class'    => 'cancelar_pedido',
                                'style' =>'margin-bottom: 10px;'
                            ),
                        ));                           
                    }

                    ?>
                    <?php
                    $this->widget('bootstrap.widgets.TbButton', array(
                        'label' => 'Buscar outro endereço',
                        'type'  => 'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                        'size'  => 'mini', // null, 'large', 'small' or 'mini'
                        'htmlOptions' => array(
                            'id'    => 'show-new-map',
                            'style' =>'margin-bottom: 10px; display: none'
                        ),
                    ));
                    ?>
                    <div style="display:none" id='new-map'>
                        <div style="display:none" id="nao-encontrado" class='alert alert'>
                            <b>Endereço não encontrado</b>, corriga o(s) endereço(s) e clique em "Nova busca"
                        </div>
                        
                        <div>Partida: <?= CHtml::textField('start','',array('class'=>'span10')); ?></div>
                        <div>Destino <?= CHtml::textField('end','',array('class'=>'span10')); ?></div>

                        <?php
                        $this->widget('bootstrap.widgets.TbButton', array(
                            'label' => 'Nova busca',
                            'type' => 'null', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                            'size' => 'null', // null, 'large', 'small' or 'mini'
                            'block' => true,
                            'htmlOptions' => array(
                                'id' => 'btn-map',
                                'style'=>'margin-top: 10px'
                            ),
                        ));
                        ?>
                    </div>

                    <div id="auto-map">
                        <b>Mapa: </b>
                        <div id="mapa" class="hidden-print" style="height: 300px; width: 100%;"></div>
                        <b>Trajeto: </b>
                        <div id="trajeto-texto" class="hidden-print" style="width: 100%"></div>
                    </div>
                </div>
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
                        $data['dataProvider']->setPagination(false);
                        $this->widget('zii.widgets.CListView', array(
                            'dataProvider' => $data['dataProvider'],
                            'template' => '{items}',
                            'itemView' => $data['itemView'],
                        ));
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
                    $dataProdutoPedido->setPagination(false);
                    $this->widget('zii.widgets.CListView', array(
                        'dataProvider' => $dataProdutoPedido,
                        'template' => '{items}',
                        'itemView' => '_produtos',
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->renderPartial('_modalPedido', array('model' => $model)); ?>