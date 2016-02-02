<?php

class LoginFormController extends Controller {
    
    public function actionAjaxLogin() {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new LoginForm;
            $model->attributes = $_POST['LoginForm'];
            
            if(($model->validate() && $model->login())){
                $user   = Usuario::model()->findByPk(Yii::app()->user->id);
                $result = $user->clientes->getArrayParaPedido();
            }else
                $result = false;
            
            echo CJSON::encode($result);
            Yii::app()->end();
        }
        else
            throw new CHttpException(400);
    }
    
    public function actionAjaxValidate() {
        if (Yii::app()->request->isAjaxRequest) {

            $model = new LoginForm;
            $model->attributes = $_POST['LoginForm'];

            $errors  = CActiveForm::validate(array($model));

            if ($errors !== '[]'){
                echo $errors;
                Yii::app()->end();
            }
        }
        else
            throw new CHttpException(400);
    }
}