<?php

class AdicionalController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */

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
		$model=new Adicional;
                $this->tituloManual = "Cadastrar item adicional";
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Adicional']))
		{
			$model->attributes=$_POST['Adicional'];
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
                $this->tituloManual = "Editar o adicional: ".$model->descricao;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Adicional']))
		{
			$model->attributes=$_POST['Adicional'];
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
                TamanhoAdicional::model()->updateAll(array('ativa' => $status), 'adicional_id = ' . $id);
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
            $conditions = 'adicional_id = ' . $model->id;
            $modelPendentes = "";
            $tamanhoAdicional = TamanhoAdicional::model()->find($conditions);
            
            // Deleta todos os registros dependentes
            if (!empty($tamanhoAdicional))
                $modelPendentes = TamanhoAdicional::model()->updateAll(array('excluida' => 1), $conditions);
            
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
                $this->tituloManual = "Lista de itens adicionais";
		$model=new Adicional('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Adicional']))
			$model->attributes=$_GET['Adicional'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Adicional the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Adicional::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Adicional $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='adicional-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
