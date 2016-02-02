<?php

/**
 * Controlador inicial
 */
class HomeController extends Controller
{
    
    public function actionIndex() {
        $this->tituloManual = "Home";
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
