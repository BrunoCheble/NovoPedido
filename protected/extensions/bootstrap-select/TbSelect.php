<?php

/**
 * Class TbSelect
 *
 * Usage without model
 *
 * ```
 * <?php $this->widget('ext.bootstrap-select.TbSelect',array(
 *      'name' => 'country_id',
 *      'data' => Country::listData(),
 *      'htmlOptions' => array(
 *          //'multiple' => true,
 *      ),
 * )) ?>
 *
 * Usage with model
 *
 * ```
 * <?php $this->widget('ext.bootstrap-select.TbSelect',array(
 *      'model' => $user,
 *      'attribute' => 'country',
 *      'data' => Country::listData(),
 *      'htmlOptions' => array(
 *          //'multiple' => true,
 *      ),
 * )) ?>
 * ```
 *
 * @author Bryan Jayson Tan <bryantan16@gmail.com>
 * @link admin@bryantan.info
 * @date 11/02/2013
 * @src http://silviomoreto.github.io/bootstrap-select/
 */
class TbSelect extends CInputWidget
{
    public $data = array();

    public $options = array();

    public $cssFile = null;

    private $_assetsUrl = null;

    public function init()
    {
        $this->publishAssets();
    }

    public function run()
    {
        $this->renderField();
        $this->registerClientScript();
        $this->registerCss();
    }

    public function renderField()
    {
        list($name, $id) = $this->resolveNameID();

        if ($this->hasModel()) {
            echo CHtml::activeDropDownList($this->model, $this->attribute, $this->data, $this->htmlOptions);
        }else {
            echo CHtml::dropDownList($name, $this->value, $this->data, $this->htmlOptions);
        }
    }

    public function publishAssets()
    {
        if ($this->_assetsUrl === null) {
            $assetsUrl = Yii::app()->assetManager->publish(dirname(__FILE__).'/assets');

            $this->_assetsUrl = $assetsUrl;
        }

        return $this->_assetsUrl;
    }

    public function registerCss()
    {
        $cs = Yii::app()->getClientScript();
        if ($this->cssFile !== null) {
            $cs->registerCssFile($this->cssFile);
        }else {
            $cs->registerCssFile($this->_assetsUrl . '/bootstrap-select.css');
        }
    }

    public function registerClientScript()
    {
        list($name, $id) = $this->resolveNameID();

        $options = $this->options;
        $options = json_encode($options);

        $cs = Yii::app()->getClientScript();
        $select = YII_DEBUG === true ? 'bootstrap-select.js' : 'bootstrap-select.min.js';
        $cs->registerScriptFile($this->_assetsUrl . '/' . $select,CClientScript::POS_END);
        Yii::app()->clientScript->registerScript(__CLASS__ . $this->getId(),"$('#" . $id . "').selectpicker({$options})");
    }
} 