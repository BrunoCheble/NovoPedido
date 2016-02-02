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
echo "\$this->breadcrumbs = array(
	Yii::t('{$this->modelClass}', '$label') => array('index'),
	\$model->{$nameColumn} => array('view','id'=>\$model->{$this->tableSchema->primaryKey}),
	Yii::t('site', 'Editar'),
);\n";
?>

$this->menu=array(
	array('label' => Yii::t('<?php echo $this->modelClass; ?>', '<?php echo $label; ?>'), 'url'=>array('index')),
	array('label' => Yii::t('<?php echo $this->modelClass; ?>', 'Novo <?php echo $this->modelClass; ?>'), 'url'=>array('create')),
	array('label' => Yii::t('<?php echo $this->modelClass; ?>', 'Ver <?php echo $this->modelClass; ?>'), 'url'=>array('view', 'id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>)),
	array('label' => Yii::t('<?php echo $this->modelClass; ?>', 'Gerenciar <?php echo $label; ?>'), 'url'=>array('admin')),
);
?>

<h1><?php echo "<?php echo Yii::t('" . $this->modelClass . "', 'Editar ". $this->class2name($this->modelClass) . "') . ' #' . \$model->{$this->tableSchema->primaryKey}; ?>"; ?></h1>

<?php echo "<?php echo \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>