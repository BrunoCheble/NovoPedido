<?php

/**
 * Controlador inicial
 */
class TamanhoBordaController extends Controller
{
    public function actionError() {
		
        $this->tituloManual = 'Erro | ' . Yii::app()->name;
		
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }
    
    public function actionAjaxGetArrayTamanhoBorda() { {
            if (Yii::app()->request->isPostRequest && isset($_POST['tamanho'])) {
                $array = TamanhoBorda::getArrayDescricaoFormatadaByTamanho($_POST['tamanho']);
                $modelTamanho = Tamanho::model()->findByPk($_POST['tamanho']);
                echo CJSON::encode(array('items'=>$array,'max_qtd_sabor'=>$modelTamanho->max_qtd_sabor));
            }
            else
                throw new CHttpException(400);
        }
    }
}
