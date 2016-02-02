<script>
    $(document).ready(function(){
        
        validaAlarme = function(){
            if($('#emAberto .card-pedido').length > 0){
                $('.alert-pedido').show();
                $('#alarme').get(0).play();
            } else {
                $('.alert-pedido').hide();
                $('#alarme').get(0).stop();
            }
        }
        
        $('h1').prepend('<span style="display: none" class="alert-pedido"><i class="animated flash"></i></span>');
        if($('#emAberto .card-pedido').length > 0 && $('.icon-flat-power17').length > 0){
            $('.alert-pedido').show();
            $('#alarme').get(0).play();
        }
        
    });
</script>
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
                    status: 3,
                    entregador_id: $(this).parent('nav').find('select').val()
                },
                success: function(e){
                    if(e != '1')
                        window.location('".Yii::app()->createAbsoluteUrl('adm/usuario/login')."');
                    else{
                        $.fn.yiiListView.update('preparando');
                        $.fn.yiiListView.update('entregando');
                    }
                }
            });
        });

        $(document).on('click','.cancelar-preparando',function(e){
            
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: '".Yii::app()->createAbsoluteUrl('adm/pedido/updateStatus')."',
                data: {
                    id: $(this).attr('data-id'),
                    status: 6
                },
                success: function(e){
                    if(e != '1')
                        window.location('".Yii::app()->createAbsoluteUrl('adm/usuario/login')."');
                    else{
                        $.fn.yiiListView.update('preparando');
                    }
                }
            });
        });    

        $(document).on('click','.excluir-pedido',function(e){
            
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: '".Yii::app()->createAbsoluteUrl('adm/pedido/delete')."',
                data: {
                    id: $(this).attr('data-id')
                },
                success: function(e){
                    if(e != '1')
                        window.location('".Yii::app()->createAbsoluteUrl('adm/usuario/login')."');
                    else{
                        $.fn.yiiListView.update('emAberto');
                    }
                }
            });
        });    

        $(document).on('click','.confirmar-entrega,.cancelar-entrega',function(e){
            
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: '".Yii::app()->createAbsoluteUrl('adm/pedido/updateStatus')."',
                data: {
                    id: $(this).attr('data-id'),
                    status: $(this).hasClass('confirmar-entrega') ? 4 : 5
                },
                success: function(e){
                    if(e != '1')
                        window.location('".Yii::app()->createAbsoluteUrl('adm/usuario/login')."');
                    else{
                        $.fn.yiiListView.update('entregando');
                    }
                }
            });
        });


        setInterval(function() {

            $.fn.yiiListView.update(
                'emAberto',
                {
                    error: function(jqXHR, status) {
                            window.location.href = '".Yii::app()->createAbsoluteUrl('adm/usuario/login')."';
                        //if (status=='success'){
                            //if($('.icon-flat-power17').length > 0){
                                //validaAlarme();
                            //}
                        //}
                    }
                }
            );

            $.fn.yiiListView.update('preparando',
            {
                error: function(jqXHR, status) {

                        window.location.href = '".Yii::app()->createAbsoluteUrl('adm/usuario/login')."';
                }
            });
            
            $.fn.yiiListView.update('filaEntrega',
            {
                error: function(jqXHR, status) {

                        window.location.href = '".Yii::app()->createAbsoluteUrl('adm/usuario/login')."';
                }
            });

            $.fn.yiiListView.update('entregando',
            {
                error: function(jqXHR, status) {

                        window.location.href = '".Yii::app()->createAbsoluteUrl('adm/usuario/login')."';
                }
            });

        }, ".(Yii::app()->params['tempoValidacao']/2).");
        ", CClientScript::POS_END
    );
?>
<div class="row-fluid">

    <div class="span4">
        <div class="widget">
            <!-- Widget title -->
            <div class="widget-head">
                Novos pedidos
            </div>
            <div class="widget-content">
                <?php
                $dataPedidosAberto->setPagination(false);
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider' => $dataPedidosAberto,
                    'template' => '{items}',
                    'id' => 'emAberto',
                    'htmlOptions' => array('class'=>'cards-pedido'),
                    'itemView' => '_pedido',
                ));
                ?>
            </div>
        </div>
    </div>

    <div class="span4">
        <div class="widget">
            <!-- Widget title -->
            <div class="widget-head">
                Preparando
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
    <div class="span4">
        
        <div class="widget">
            <!-- Widget title -->
            <div class="widget-head">
                Fila de entrega
            </div>
            <div class="widget-content">
                <?php
                $dataPedidosFilaEntrega->setPagination(false);
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider' => $dataPedidosFilaEntrega,
                    'template' => '{items}',
                    'id' => 'filaEntrega',
                    'htmlOptions' => array('class'=>'cards-pedido'),
                    'itemView' => '_pedido',
                ));
                ?>
            </div>
        </div>
        <br/>
        <div class="widget">
            <!-- Widget title -->
            <div class="widget-head">
                Entregando
            </div>
            <div class="widget-content">
                <?php
                $dataPedidosEntregando->setPagination(false);
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider' => $dataPedidosEntregando,
                    'template' => '{items}',
                    'id' => 'entregando',
                    'htmlOptions' => array('class'=>'cards-pedido'),
                    'itemView' => '_pedido',
                ));
                ?>
            </div>
        </div>
    </div>
</div>

<audio id="alarme" style="display:none" controls>
  <source src="<?= Yii::app()->controller->module->getAssetsUrl().'/sound/digital_phone.mp3' ?>" type="audio/mp3">
</audio>