<?php

/**
 * Controlador inicial
 */
class CardapioController extends Controller
{
    public $layout = 'pages';
    
    public function actionIndex() {
        $this->tituloManual = "Cardápios";
        
        $this->render('index', array(
            'modelSabor'     => Sabor::model()->naoExcluido()->ordenarPorSalgada()->findAll(),
            'listTamanho'    => CHtml::listData(Tamanho::model()->naoExcluido()->findAll(),'id','descricao'),
            'listAdicional'  => CHtml::listData(Adicional::model()->naoExcluido()->findAll(),'id','descricao'),
            'listMassa'      => Produto::getArrayListMassaCardapio(),
            'listBebidas'    => Produto::getArrayListBebidasCardapio(),
        ));
    }

    public function actionError() {
		
        $this->tituloManual = 'Erro | ' . Yii::app()->name;
		
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }
}
