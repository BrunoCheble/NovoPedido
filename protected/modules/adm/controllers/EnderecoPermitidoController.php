<?php

class EnderecoPermitidoController extends Controller
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
	public function accessRules() {
            return array(
                array('allow', // allow all users to perform 'index' and 'view' actions
                    'actions' => array('index', 'create', 'update', 'updateStatus', 'delete'),
                    'expression' => 'Yii::app()->user->isAdmin()',
                ),
                array('deny', // deny all users
                    'users' => array('*'),
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
		$model=new EnderecoPermitido;
                $this->tituloManual = "Cadastrar endereço";

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['EnderecoPermitido']))
		{
			$model->attributes=$_POST['EnderecoPermitido'];
			if($model->save())
				$this->redirect(array('index'));
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
                $this->tituloManual = "Editar o endereço: ".$model->local." - ".$model->bairro;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['EnderecoPermitido']))
		{
			$model->attributes=$_POST['EnderecoPermitido'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('update',array(
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
	 * Lists all models.
	 */
	public function actionIndex()
	{
                $this->tituloManual = "Lista de endereços permitidos";
                
		$model=new EnderecoPermitido('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['EnderecoPermitido']))
			$model->attributes=$_GET['EnderecoPermitido'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

        public function actionUpdateStatus($id)
	{
		$model = $this->loadModel($id);
                
                $model->ativo = $model->ativo ? 0 : 1;
                
                if($model->save())
                        $this->redirect(array('index'));

                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}
        
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return EnderecoPermitido the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=EnderecoPermitido::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param EnderecoPermitido $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='endereco-permitido-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
