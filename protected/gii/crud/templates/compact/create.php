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
	Yii::t('$this->modelClass', '$label') => array('index'),
	Yii::t('site', 'Novo'),
);\n";
?>

$this->menu=array(
	array('label' => Yii::t('<?php echo $this->modelClass; ?>', '<?php echo $label; ?>'), 'url'=>array('index')),
	array('label' => Yii::t('<?php echo $this->modelClass; ?>', 'Gerenciar <?php echo $label; ?>'), 'url'=>array('admin')),
);
?>

<h1><?php echo "<?php echo Yii::t('" . $this->modelClass . "', 'Novo " . $this->modelClass . "'); ?>"; ?></h1>

<?php echo "<?php echo \$this->renderPartial('_form', array('model'=>\$model)); ?>"; ?>
