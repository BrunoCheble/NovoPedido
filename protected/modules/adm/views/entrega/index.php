<?php
   Yii::app()->clientScript->registerScript('scriptPedidos',
        "

        var getArrayPedidos = function(){

            itens = [];
        	$.each($('[type=\'checkbox\']:checked'),function(){
        		itens.push($(this).attr('id'));
        	});
			return itens;
        }

        $('#concluir-entregas').click(function(e){
        	e.preventDefault();         

            var pedidos = getArrayPedidos();

            if(pedidos == ''){
            	alert('Selecione os pedidos');
            	return false;
            }

            $.ajax({
                type: 'POST',
                url: '".Yii::app()->createAbsoluteUrl('adm/pedido/updateAllStatus')."',
                data: {
                	pedidos: pedidos,
                	status: '".Status::_TIPO_CONCLUIDO_."'
                },
                success: function(e){
                    if(e != '1')
                        alert(e);
                    else{
                        alert('Os Pedidos foram concluídos com sucesso.');
                    }
                }
            });
        });

        $('#devolver-entregas').click(function(e){
        	e.preventDefault();         

            var pedidos = getArrayPedidos();

            if(pedidos == ''){
            	alert('Selecione os pedidos');
            	return false;
            }

            $.ajax({
                type: 'POST',
                url: '".Yii::app()->createAbsoluteUrl('adm/pedido/updateAllStatus')."',
                data: {
                	pedidos: pedidos,
                	status: '".Status::_TIPO_DEVOLVIDO_."'
                },
                success: function(e){
                    if(e != '1')
                        alert(e);
                    else{
                        alert('Os Pedidos foram devolvidos com sucesso.');
                    }
                }
            });
        });

        $(document).on('click','#confirmar-entrega',function(e){
            e.preventDefault();         

            var pedidos = getArrayPedidos();

            if(pedidos == ''){
            	alert('Selecione os pedidos');
            	return false;
            }

            $.ajax({
                type: 'POST',
                url: '".Yii::app()->createAbsoluteUrl('adm/entrega/create')."',
                data: {
                	pedidos: pedidos,
                    entregador_id: $('#Entrega_entregador_id').val()
                },
                success: function(e){
                    if(e != '1')
                        alert(e);
                    else{
                        alert('Entrega cadastrada com sucesso!');
                        window.location.href = 'index';
                    }
                }
            });
        });

		$(document).on('click','#atualiza-entrega',function(e){
            e.preventDefault();         

            $.ajax({
                type: 'POST',
                url: '".Yii::app()->createAbsoluteUrl('adm/entrega/update')."',
                data: {
                	pedidos: getArrayPedidos(),
                	entrega_id: '".$entrega."',
                    entregador_id: $('#Entrega_entregador_id').val()
                },
                success: function(e){
                    if(e != '1')
                        alert(e);
                    else{
                        alert('Entrega atualizada com sucesso!');
                    	window.location.href = 'index';
                    }
                }
            });
        });

   		$('#Entrega_entregador_id').change(function(){
   			$.ajax({
                type: 'POST',
                url: '".Yii::app()->createAbsoluteUrl('adm/entrega/ajaxGetEntregas')."',
                data: {
                    entregador_id: $('#Entrega_entregador_id').val()
                },
                complete: function(jqXHR, textStatus){
                	var jsonData = eval('(' + jqXHR.responseText + ')');
                	$('#list_entregas').empty();
                    
                    $.each(jsonData.entregas,function(index,value){
                    	url = '".Yii::app()->createAbsoluteUrl('adm/entrega/index')."?id='+value.id;
                		$('#list_entregas').append('<li><a href='+url+'>#'+value.id+' Entrega</a></li>');
                	});
					
					if('".$entrega."' != '') {
						if('".$entregador."' != $('#Entrega_entregador_id').val())
							$('#atualiza-entrega').text('Repassar entrega');
						else
							$('#atualiza-entrega').text('Atualizar entrega');
					}
                }
            });
   		});

		$('#Entrega_entregador_id').change();

        setInterval(function() {
            
            $.fn.yiiListView.update(
                'preparando',
                {
                    complete: function(jqXHR, status) {
                        if (status=='success'){
                            validaAlarme();
                        }
                    }
                }
            );
        
        }, ".(Yii::app()->params['tempoValidacao']/2).");
        ", CClientScript::POS_END
    );
?>

<div class="row-fluid">
	<div class="span2">
	    <div class="widget">
	        <!-- Widget title -->
	        <div class="widget-head">
	            Entregador
	        </div>
	        <div class="widget-content">
	        	<div class="padd">	    
	        	<?php
                $this->widget('bootstrap.widgets.TbButton', array(
                    'label' => 'Entregas pendentes',
                    'type'  => 'null', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                    'block' => true,
                    'url'	=> array('index'),
                    'htmlOptions' => array(
                    	'id'	=> 'btn_entregas_pendentes',
                        'style' =>'margin-bottom: 10px;'
                    ),
                ));
                ?>    
	            <?php
	            	echo CHtml::dropDownList('Entrega[entregador_id]',$entregador, $arrayEntregadores,array('style'=>'width: 100%'))
	            ?>

	            <ul id="list_entregas">
	            	<?php
				    	if(!empty($entregador)){
				    		foreach ($modelEntregador->entregas as $entregas) {
				    			$qtd_pedidos = $entregas->qtdPedidos().' pedido(s)';
				    			echo '<li>'.CHtml::link('#'.$entregas->id.' Entrega',array('index',"id"=>$entregas->id),array('title'=>'Visualizar itens')).'</li>';
				    		}
				    	}
				    ?>
	            </ul>

	            </div>
	        </div>
	    </div>
	</div>
	<div class="span10">
	    <div class="widget">
	        <!-- Widget title -->
	        <div class="widget-head">
	            Pedidos
	        </div>
	        <div class="widget-content">
		        <?php
		        $this->widget('bootstrap.widgets.TbGridView', array(
		            'type' => 'striped bordered condensed',
		            'dataProvider' => $modelPedidoAll,
		            'template' => "{items}{pager}{summary}",
		            'columns' => array(
		            	array(
		            		'header' => '',
		            		'type' => 'raw',
							'value' => 'CHtml::checkBox("Pedido[\'entrega_id\']", !empty($data->entrega_id), array("value"=>"1", "id"=>"$data->id"))'
	            		),
		                array(
	                        'name' => 'codigo',
	                        'header'=>'Código',
	                        'htmlOptions' => array('style' => 'width: 70px','data-title'=>'Código'),
	                    ),
	                    array(
	                        'header'=>'Status',
	                        'value' => 'Status::getDescricao($data->status)',
	                        'htmlOptions' => array('style' => 'width: 70px','data-title'=>'Status'),
	                    ),
	                    array(
	                        'name' => 'data_pedido',
	                        'header'=>'Data do pedido',
	                        'value' => '$data->status < 4 ? $data->tempo_aguardando." atrás": date("d/m/Y H:m:s", strtotime($data->data_pedido))',
	                        'htmlOptions' => array('data-title'=>'Data do pedido','style'=>'width: 100px'),
	                    ),
	                    array(
	                        'name' => 'bairro',
	                        'header'=>'Bairro',
	                        'htmlOptions' => array('data-title'=>'Bairro'),
	                    ),
	                    array(
	                        'name' => 'endereco',
	                        'header'=>'Endereço',
	                        'value' => '$data->endereco.", ".$data->numero." ".$data->complemento',
	                        'htmlOptions' => array('data-title'=>'Endereço'),
	                    ),
	                    array(
	                        'name' => 'responsavel',
	                        'header'=>'Nome do cliente',
	                        'htmlOptions' => array('data-title'=>'Responsável'),
	                    ),
	                    array(
	                    	'header' => 'Forma de pagamento',
	                        'name' => 'forma_pagamento_id',
	                        'filter' => $arrayFormaPagamento,
	                        'value' => '$data->formaPagamentos->nome',
	                        'htmlOptions' => array('data-title'=>'Formas de pagamento'),
	                    ),
	                    array(
	                    	'header' => 'Preço total',
	                        'name' => 'preco_total',
	                        'value' => '"R$ ".number_format($data->preco_total,2,",",".")',
	                        'htmlOptions' => array('data-title'=>'Preço total','style'=>'width: 100px'),
	                    ),
	                    array(
	                    	'header'=>'Troco',
	                        'name' => 'troco',
	                        'filter' => false,
	                        'value' => '"R$ ".number_format($data->troco,2,",",".")',
	                        'htmlOptions' => array('style' => 'width: 70px','data-title'=>'Troco'),
	                    ),
	                    array(
	                        'class' => 'bootstrap.widgets.TbButtonColumn',
	                        'template' => '{update}',
	                        'buttons' => array(
	                        	'update' => array (
	                                'label' => '',
	                                'options' => array('class' => 'icon-pencil'),
	                                'url' => '$this->grid->controller->createUrl("pedido/update",array("id"=>$data->id))',
                            	),
                            ),
	                        'htmlOptions' => array('style' => 'width: 30px'),
	                    )
		            ),
		        ));
		        ?>	

	        </div>
	        <hr/>
	        <div class="widget-footer" style="padding:0 10px 10px">
	        	<?php
                if(!empty($entrega)) {

	                $this->widget('bootstrap.widgets.TbButton', array(
	                    'label' => 'Atualizar entrega',
	                    'htmlOptions' => array(
	                        'id' => 'atualiza-entrega',
	                    ),
	                    'type' => 'success', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
	                    'size' => 'null', // null, 'large', 'small' or 'mini'
	                ));

	                echo '<div class="pull-right">';
		                $this->widget('bootstrap.widgets.TbButton', array(
		                    'label' => 'Concluir pedidos selecionados',
		                    'htmlOptions' => array(
		                        'id' => 'concluir-entregas',
		                    ),
		                    'type' => 'info', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
		                    'size' => 'null', // null, 'large', 'small' or 'mini'
		                ));
		                echo ' ';
		                $this->widget('bootstrap.widgets.TbButton', array(
		                    'label' => 'Devolver pedidos para cozinha',
		                    'htmlOptions' => array(
		                        'id' => 'devolver-entregas',
		                    ),
		                    'type' => 'warning', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
		                    'size' => 'null', // null, 'large', 'small' or 'mini'
		                ));
	                echo '</div>';
                }
                else {

	                $this->widget('bootstrap.widgets.TbButton', array(
	                    'label' => 'Cadastrar entrega',
	                    'htmlOptions' => array(
	                        'id' => 'confirmar-entrega',
	                    ),
	                    'type' => 'success', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
	                    'size' => 'null', // null, 'large', 'small' or 'mini'
	                ));
                }
                
                ?>
	        </div>
	    </div>
	</div>
</div>
