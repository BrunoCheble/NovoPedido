<?php

/**
 * Controlador inicial
 */
class PizzariaController extends Controller {

    //public $layout = 'pages';
    /**
    * @return array action filters
    */
    public function filters()
    {
        return array(
                'accessControl', // perform access control for CRUD operations
                'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
    * Specifies the access control rules.
    * This method is used by the 'accessControl' filter.
    * @return array access control rules
    */
    public function accessRules()
    {
            
        return array(
                array('allow',  // allow all users to perform 'index' and 'view' actions
                    'actions'    => array('validaSituacao'),
                ),
                array('deny',  // deny all users
                    'users'=>array('*'),
                ),
        );
    }
    
    public function actionValidaSituacao() {
        
        if (Yii::app()->request->isAjaxRequest)
        {
            echo $this->validaSituacao() ? 1 : 0;
            Yii::app()->end();
        }
        else
            throw new CHttpException(400);
    }
    
}
