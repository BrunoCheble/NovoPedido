<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php
echo "<?php\n";
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	Yii::t('{$this->modelClass}', '$label') => array('index'),
	\$model->{$nameColumn},
);\n";
?>

$this->menu=array(
	array('label' => Yii::t('<?php echo $this->modelClass; ?>', '<?php echo $label; ?>'), 'url'=>array('index')),
	array('label' => Yii::t('<?php echo $this->modelClass; ?>', 'Novo <?php echo $this->modelClass; ?>'), 'url'=>array('create')),
	array('label' => Yii::t('<?php echo $this->modelClass; ?>', 'Editar <?php echo $this->modelClass; ?>'), 'url'=>array('update', 'id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>)),
	array('label' => Yii::t('<?php echo $this->modelClass; ?>', 'Excluir <?php echo $this->modelClass; ?>'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>),'confirm'=>Yii::t('site', 'Tem certeza de que deseja excluir este registro?'))),
	array('label' => Yii::t('<?php echo $this->modelClass; ?>', 'Gerenciar <?php echo $label; ?>'), 'url'=>array('admin')),
);
?>

<h1><?php echo "<?php echo Yii::t('" . $this->modelClass . "', 'Ver ". $this->class2name($this->modelClass) . "') . ' #' . \$model->{$this->tableSchema->primaryKey}; ?>"; ?></h1>

<?php echo "<?php"; ?> $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
<?php
foreach($this->tableSchema->columns as $column)
	echo "\t\t'".$column->name."',\n";
?>
	),
)); ?>
