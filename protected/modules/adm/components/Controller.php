<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    public $tituloManual;

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = 'main';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    public function init() {
        parent::init();

        Yii::app()->params['nome'] = Pizzaria::model()->find()->nome;
    }

    public function afterAction($action) {
        parent::afterAction($action);
    }

    function validaSituacao() {
        $model = Pizzaria::model()->find();

        $tempoAtual  = new DateTime(date('Y-m-d H:i:s', strtotime('-30 second')));
        $ultimaAtual = new DateTime($model->ultimo_atualizacao);
        
        return $model->situacao == 1 || $tempoAtual < $ultimaAtual;
    }

    function visualizarBorda() {
        $model = Pizzaria::model()->find();

        return $model->borda_pizza == 1;
    }

    function visualizarTipoMassa() {
        $model = Pizzaria::model()->find();

        return $model->massa_pizza == 1;
    }

    function visualizarPizza() {
        $model = Pizzaria::model()->find();
        return $model->tipo_restaurante == TipoRestaurante::_TIPO_PIZZARIA_;
    }

    function visualizarCombinado() {
        $model = Pizzaria::model()->find();
        return $model->tipo_restaurante == TipoRestaurante::_TIPO_JAPONES_;
    }

    function visualizarAdicional() {
        $model = Pizzaria::model()->find();

        return $model->adicional_pizza == 1;
    }

}
