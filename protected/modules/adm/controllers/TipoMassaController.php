<?php

class TipoMassaController extends Controller
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
				'actions'=>array('index','create','update','view','delete','updateStatus'),
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
		$model=new TipoMassa;
                $this->tituloManual = "Cadastrar tipo de massa";

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TipoMassa']))
		{
			$model->attributes=$_POST['TipoMassa'];
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
                $this->tituloManual = "Editar o tipo de massa: ".$model->descricao;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TipoMassa']))
		{
			$model->attributes=$_POST['TipoMassa'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
        
        public function actionUpdateStatus($id) {
            $model = $this->loadModel($id);
            $status = $model->ativa ? 0 : 1;
            $model->ativa = $status;

            if ($model->save()) {
                TamanhoTipoMassa::model()->updateAll(array('ativa' => $status), 'tipo_massa_id = ' . $id);
            };

            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id) {
            $model = $this->loadModel($id);
            $model->excluida = 1;
            $conditions = 'tipo_massa_id = ' . $model->id;
            $modelPendentes = "";
            $tamanhoTipoMassa = TamanhoTipoMassa::model()->find($conditions);
            
            // Deleta todos os registros dependentes
            if (!empty($tamanhoTipoMassa))
                $modelPendentes = TamanhoTipoMassa::model()->updateAll(array('excluida' => 1), $conditions);
            
            if (empty($modelPendentes))
                $model->delete();
            else
                $model->save();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
                $this->tituloManual = "Lista de tipos de massas";
		$model=new TipoMassa('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TipoMassa']))
			$model->attributes=$_GET['TipoMassa'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return TipoMassa the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=TipoMassa::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param TipoMassa $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tipo-massa-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
