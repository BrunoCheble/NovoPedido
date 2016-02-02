<?php
/* @var $this TipoMassaController */
/* @var $model TipoMassa */

$this->breadcrumbs=array(
	'Tipo Massas'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TipoMassa', 'url'=>array('index')),
	array('label'=>'Create TipoMassa', 'url'=>array('create')),
	array('label'=>'Update TipoMassa', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TipoMassa', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TipoMassa', 'url'=>array('admin')),
);
?>

<h1>View TipoMassa #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'descricao',
		'ativa',
		'excluida',
	),
)); ?>
