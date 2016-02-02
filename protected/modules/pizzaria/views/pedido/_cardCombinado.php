<section card-id="1" qtd-sabor-max="" class="card-combinado">
    <div class="border-top titulo_combinado bg-red">
    	<div class="row-fluid">
	    	<div class="span10">
	        	<?= CHtml::dropDownList('Pedido[combinado_id]', '', $listCombinado,array('empty'=>'Combinado personalizado', 'class'=>'span12')); ?>
	        </div>
	        <div class="preco_combinado span2">R$ 0,00</div>
        </div>
    </div>
    <div class="content-combinado">
	    <?php
		    $this->widget('bootstrap.widgets.TbButton', array(
		        'label'=>'Escolher itens para o combinado',
		        'type'=>'success', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
		        'block'=>true,
		        'htmlOptions'=>array(
		        	'class' => 'btn_escolher_itemcombinado',
		            'data-toggle' => 'modal',
		            'data-target' => '#modal-itemcombinado',
		        )
		    ));
	    ?>
        <div preco="" class="list-itemcombinado vazio row-fluid"></div>
    </div>
</section>