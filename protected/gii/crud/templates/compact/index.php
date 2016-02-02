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
	Yii::t('$this->modelClass', '$label'),
);\n";
?>

$this->menu=array(
	array('label' => Yii::t('<?php echo $this->modelClass; ?>', 'Novo <?php echo $this->modelClass; ?>'), 'url'=>array('create')),
	array('label' => Yii::t('<?php echo $this->modelClass; ?>', 'Gerenciar <?php echo $label; ?>'), 'url'=>array('admin')),
);
?>

<h1><?php echo "<?php echo Yii::t('" . $this->modelClass . "','" . $label . "'); ?>"; ?></h1>

<?php echo "<?php"; ?> $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
