<?php

/**
 * Controlador inicial
 */
class TamanhoAdicionalController extends Controller
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
    
    public function actionAjaxGetArrayTamanhoAdicional() { {
            if (Yii::app()->request->isAjaxRequest) {
                $arrayTamanhoAdicional = TamanhoAdicional::getArrayDescricaoFormatadaByTamanho($_POST['tamanho']);
                echo CJSON::encode(array('arrayTamanhoAdicional' => $arrayTamanhoAdicional));
            }
            else
                throw new CHttpException(400);
        }
    }
}
