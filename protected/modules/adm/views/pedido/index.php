<script>
    $(document).ready(function(){
        
        validaAlarme = function(){
            if($('.new').length > 0){
                $('.alert-pedido').show();
                $('#alarme').get(0).play();
            } else {
                $('.alert-pedido').hide();
                $('#alarme').get(0).stop();
            }
        }
        
        $('h1').prepend('<span style="display: none" class="alert-pedido"><i class="animated flash"></i></span>');
        if($('.new').length > 0){
            $('.alert-pedido').show();
            $('#alarme').get(0).play();
        }
        
    });
</script>
 <?php
   Yii::app()->clientScript->registerScript('scriptPedidos',
        "
        setInterval(function() {
        
            if($('.icon-flat-power17').length > 0){
                $.fn.yiiGridView.update(
                    'grid-pedido',
                    {
                        complete: function(jqXHR, status) {
                            if (status=='success'){
                                validaAlarme();
                            }
                        }
                    }
                );
            }
        }, ".(Yii::app()->params['tempoValidacao']/2).");
        ", CClientScript::POS_END
    );
?>
<div class="widget">
    <!-- Widget title -->
    <div class="widget-head">
        Lista de pedidos
    </div>
    <div class="widget-content">
            <?php
            $this->widget('bootstrap.widgets.TbGridView', array(
                'id'=>'grid-pedido',
                'type' => 'striped bordered condensed',
                'dataProvider' => $model->orderPrioridade()->search(),
                'filter' => $model,
                'template' => "{items}{pager}{summary}",
                'rowCssClassExpression' => '$data->status == 1 ? "new" : null',
                'columns' => array(
                    array(
                        'name' => 'codigo',
                        'htmlOptions' => array('style' => 'width: 70px','data-title'=>'Código'),
                    ),
                    array(
                        'name' => 'status',
                        'value' => 'Status::getDescricao($data->status)',
                        'filter' => $arrayStatus,
                        'htmlOptions' => array('data-title'=>'Status'),
                    ),
                    array(
                        'name' => 'data_pedido',
                        'value' => '$data->status < 4 ? $data->tempo_aguardando." atrás": date("d/m/Y H:m:s", strtotime($data->data_pedido))',
                        'htmlOptions' => array('data-title'=>'Data do pedido'),
                        'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $model,
                            'attribute' => 'data_pedido',
                            'language' => 'pt',
                            'i18nScriptFile' => 'jquery.ui.datepicker-ja.js',
                            'htmlOptions' => array(
                                'id' => 'Pedido_data_pedido',
                                'dateFormat' => 'dd-mm-yy',
                            ),
                            'options' => array(// (#3)
                                'showOn' => 'focus',
                                'dateFormat' => 'yy-mm-dd',
                                'showOtherMonths' => true,
                                'selectOtherMonths' => true,
                                'changeMonth' => true,
                                'changeYear' => true,
                                'showButtonPanel' => true,
                                'yearRange' => '2014:2020',
                            )
                                ), true),
                    ),
                    array(
                        'name' => 'bairro',
                        'htmlOptions' => array('data-title'=>'Bairro'),
                    ),
                    array(
                        'name' => 'endereco',
                        'value' => '$data->endereco.", ".$data->numero." ".$data->complemento',
                        'htmlOptions' => array('data-title'=>'Endereço'),
                    ),
                    array(
                        'name' => 'telefone',
                        'htmlOptions' => array('data-title'=>'Telefone'),
                    ),
                    array(
                        'name' => 'responsavel',
                        'htmlOptions' => array('data-title'=>'Responsável'),
                    ),
                    array(
                        'name' => 'forma_pagamento_id',
                        'filter' => $arrayFormaPagamento,
                        'value' => '$data->formaPagamentos->nome',
                        'htmlOptions' => array('data-title'=>'Formas de pagamento'),
                    ),
                    array(
                        'name' => 'preco_total',
                        'value' => '"R$ ".number_format($data->preco_total,2,",",".")',
                        'htmlOptions' => array('data-title'=>'Preço total'),
                    ),
                    array(
                        'name' => 'troco',
                        'filter' => false,
                        'value' => '"R$ ".number_format($data->troco,2,",",".")',
                        'htmlOptions' => array('style' => 'width: 70px','data-title'=>'Troco'),
                    ),
                    array(
                        'class' => 'bootstrap.widgets.TbButtonColumn',
                        'template' => '{itens}{update}{delete}',
                        'afterDelete' => 'function(link,success,data){window.location.reload();}',
                        'buttons' => array
                            (
                            'itens' => array
                                (
                                'label' => '',
                                'options' => array('class' => 'icon-shopping-cart'),
                                'url' => '$this->grid->controller->createUrl("itensPedido", array("id"=>$data->id))',
                            ),
                        ),
                        'htmlOptions' => array('style' => 'width: 50px'),
                    ),
                ),
            ));

            Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker() {
    $('#Pedido_data_pedido').datepicker($.datepicker.regional['pt']);
}
", CClientScript::POS_READY);
            ?>

    </div>
</div>

<audio id="alarme" style="display:none" controls>
  <source src="<?= Yii::app()->controller->module->getAssetsUrl().'/sound/digital_phone.mp3' ?>" type="audio/mp3">
</audio>