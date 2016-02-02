<?php

/**
 * Controlador inicial
 */
class ItemCombinadoController extends Controller
{

    public function actionAjaxGetItemCombinado(){

    	$combinado = array();
    	
        if (Yii::app()->request->isPostRequest) {

            if(!empty($_POST['combinado'])) {
            	
            	$itemcombinado = ItemCombinado::model()->findAllByAttributes(array('combinado_id'=>$_POST['combinado']));
            	
            	$combinado = $itemcombinado[0]->combinados;

            	$array = array();
            	foreach ($itemcombinado as $item) {
            		$array[] = $item->produtos;
            	}

            }
            else
            	$array = Produto::model()->ativos()->lanches()->findAll();

            echo CJSON::encode(array('item_combinados'=>$array,'combinado'=>$combinado));
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
