<?php

/**
 * Controlador inicial
 */
class PizzaController extends Controller {

    public function actionAjaxGetArrayPizza() { {
            if (Yii::app()->request->isAjaxRequest) {
                $modelTamanho = Tamanho::model()->findByPk($_POST['tamanho']);
                
                $arrayTamanhoBorda     = TamanhoBorda::getArrayDescricaoFormatadaByTamanho($modelTamanho->id);
                $arrayTamanhoTipoMassa = TamanhoTipoMassa::getArrayDescricaoFormatadaByTamanho($modelTamanho->id);
                $arrayTamanhoAdicional = TamanhoAdicional::getArrayDescricaoFormatadaByTamanho($modelTamanho->id);
                
                echo CJSON::encode(
                        array(
                            'arrayTamanhoBorda'     => $arrayTamanhoBorda,
                            'arrayTamanhoTipoMassa' => $arrayTamanhoTipoMassa,
                            'arrayTamanhoAdicional' => $arrayTamanhoAdicional,
                            'max_qtd_sabor'         => $modelTamanho->max_qtd_sabor
                        ));
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
