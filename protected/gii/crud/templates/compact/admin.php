<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php
echo "<?php\n";
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	Yii::t('" . $this->modelClass . "', '$label')=>array('index'),
	Yii::t('site', 'Gerenciar'),
);\n";
?>

$this->menu=array(
	array('label' => Yii::t('<?php echo $this->modelClass; ?>', '<?php echo $this->pluralize($this->class2name($this->modelClass)); ?>'), 'url'=>array('index')),
	array('label' => Yii::t('<?php echo $this->modelClass; ?>', 'Novo <?php echo $this->class2name($this->modelClass); ?>'), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('<?php echo $this->class2id($this->modelClass); ?>-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo "<?php echo Yii::t('site', 'Gerenciar') . ' ' . Yii::t('" .$this->modelClass . "', '" . $this->pluralize($this->class2name($this->modelClass)) . "'); ?>"; ?></h1>

<p>
<?php echo "<?php echo Yii::t('site', 'Você pode opcionalmente digitar um operador de comparação'); ?>"; ?> (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
<?php echo "<?php echo Yii::t('site', 'ou'); ?>"; ?> <b>=</b>) <?php echo "<?php echo Yii::t('site', 'no começo de cada valor de sua busca para especificar como a comparação deve ser feita'); ?>"; ?>.
</p>

<?php echo "<?php echo CHtml::link(Yii::t('site', 'Busca Avançada'),'#',array('class'=>'search-button')); ?>"; ?>

<div class="search-form" style="display:none">
<?php echo "<?php \$this->renderPartial('_search',array(
	'model'=>\$model,
)); ?>\n"; ?>
</div><!-- search-form -->

<?php echo "<?php"; ?> $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'<?php echo $this->class2id($this->modelClass); ?>-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
<?php
$count=0;
foreach($this->tableSchema->columns as $column)
{
	if(++$count==7)
		echo "\t\t/*\n";
	echo "\t\t'".$column->name."',\n";
}
if($count>=7)
	echo "\t\t*/\n";
?>
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
