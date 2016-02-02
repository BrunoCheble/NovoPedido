<?php
/* @var $this PedidoController */
/* @var $model Pedido */

$this->breadcrumbs=array(
	'Pedidos'=>array('index'),
	$model->id,
);
?>

<h1>View Pedido #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'data_pedido',
		'preco_total',
		'forma_pagamento',
		'valor_pago',
		'cliente_id',
		'preco_taxa',
		'endereco',
		'status',
		'telefone',
		'bairro',
		'numero',
		'responsavel',
		'complemento',
	),
)); ?>
