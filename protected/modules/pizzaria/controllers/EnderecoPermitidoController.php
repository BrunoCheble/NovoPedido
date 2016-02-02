<?php

/**
 * Controlador inicial
 */
class EnderecoPermitidoController extends Controller {

    public function actionAjaxGetArrayEndereco() { {
            if (Yii::app()->request->isAjaxRequest) {
                
                $modelEndereco = EnderecoPermitido::getArrayFormatadoByBairro($_POST['bairro']);
                
                echo CJSON::encode($modelEndereco);
            }
            else
                throw new CHttpException(400);
        }
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
