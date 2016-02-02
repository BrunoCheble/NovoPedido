<?php

/**
 * Controlador inicial
 */
class LojaController extends Controller {
    public $layout = 'pages';
    
    public function actionIndex() {
        $this->tituloManual = "Loja";
        $this->render('index', array());
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
