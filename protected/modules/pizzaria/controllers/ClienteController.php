<?php

class ClienteController extends Controller {

    public function actionIndex() {
        $this->render('index');
    }

    
    
    public function actionAjaxSave() {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new Cliente;
            $model->attributes = $_POST['Cliente'];
            
            $modelUsuario = new Usuario;
            $modelUsuario->attributes = $_POST['Usuario'];
            $modelUsuario->tipo_cliente = 0;

            if($modelUsuario->validate() && $model->validate()){
                if($model->save()){
                    $modelUsuario->cliente_id = $model->id;
                    if($modelUsuario->save()){
                        Yii::app()->session['id-cliente'] = $model->id;
                        echo true;
                    }
                }
            }else
                echo false;
            
            Yii::app()->end();
        }
        else
            throw new CHttpException(400);
    }
    
    public function actionAjaxValidate() {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new Cliente;
            $model->attributes = $_POST['Cliente'];

            $modelUsuario = new Usuario;
            $modelUsuario->attributes = $_POST['Usuario'];
            
            $errors  = CActiveForm::validate(array($modelUsuario,$model));
            
            if ($errors !== '[]'){
                echo $errors;
                Yii::app()->end();
            }
        }
        else
            throw new CHttpException(400);
    }
}