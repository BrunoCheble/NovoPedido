<?php

/**
 * Controlador inicial
 */
class TamanhoSaborController extends Controller
{

    public function actionAjaxGetTamanhoSabor(){
        if (Yii::app()->request->isPostRequest && isset($_POST['tamanho_id']) && isset($_POST['tipo_pizza'])) {
                $array = TamanhoSabor::getArrayFormatadoPorTamanho($_POST['tamanho_id'],$_POST['tipo_pizza']);
                echo CJSON::encode(array('sabores'=>$array));
            }
            else
                throw new CHttpException(400);
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
