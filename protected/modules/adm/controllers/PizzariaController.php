<?php

class PizzariaController extends Controller
{
	
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
				'actions'    => array('index','update','updateStatus','mobile','updateTime','stopTime'),
                                'expression' => 'Yii::app()->user->isAdmin()',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new Pizzaria;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Pizzaria']))
		{
			$model->attributes=$_POST['Pizzaria'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Pizzaria']))
		{
                    $model->attributes = $_POST['Pizzaria'];
                    
                    if($model->save())
                        $this->redirect(array('index'));
		}

		$this->render('update',array(
			'arrayTipoRestaurante' => TipoRestaurante::getArray(),
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}


	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$model=$this->loadModel(1);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Pizzaria']))
		{
			$model->attributes=$_POST['Pizzaria'];
			if($model->save())
				$this->redirect(array('index'));
		}
		$this->render('index',array(
			'model'=>$model,
		));
	}
        
        /**
	 * Manages all models.
	 */
	public function actionMobile()
	{
                $this->layout = 'mobile';
		
                $situacao = $this->validaSituacao();

		$this->render('mobile',array(
			'situacao'=>$situacao,
		));
	}

	/**
	 * Performs the AJAX validation.
	 * @param Pizzaria $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='pizzaria-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        public function actionUpdateTime() {
            if (Yii::app()->request->isAjaxRequest)
            {
                $model = $this->loadModel(1);
                $model->ultimo_atualizacao = date("Y-m-d H:i:s");
                $model->situacao = 0;
                
                echo $model->save() ? true : false;

                Yii::app()->end();
            }
        }
        
        public function actionStopTime() {
            if (Yii::app()->request->isAjaxRequest)
            {
                $model = $this->loadModel(1);
                
                $model->ultimo_atualizacao = date('Y-m-d H:i:s', strtotime('-120 second'));
                
                echo $model->save() ? true : false;

                Yii::app()->end();
            }
        }
        
        public function actionUpdateStatus($mobile = null) {
            $model = $this->loadModel(1);
            $status = $model->situacao ? 0 : 1;
            $model->situacao = $status;

            $model->save();
            
            $redirect = isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index');
            
            if(!empty($mobile))
                $redirect = array('mobile');
            
            $this->redirect($redirect);
        }
        
        /**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Pizzaria the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Pizzaria::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
