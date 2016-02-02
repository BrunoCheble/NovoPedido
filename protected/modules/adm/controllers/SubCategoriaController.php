<?php

class SubCategoriaController extends Controller
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
				'actions'=>array('index','create','update','view'),
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
		$model=new SubCategoria;
                $this->tituloManual = "Cadastrar sub-categoria";

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SubCategoria']))
		{
			$model->attributes=$_POST['SubCategoria'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('create',array(
			'model'=>$model,
                        'arrayCategoria' => SubCategoria::getArrayCategoria(),
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
                $this->tituloManual = "Editar a sub-categoria: ".$model->descricao;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SubCategoria']))
		{
			$model->attributes=$_POST['SubCategoria'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model'=>$model,
                        'arrayCategoria' => SubCategoria::getArrayCategoria(),
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */


	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$model=new SubCategoria('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SubCategoria']))
			$model->attributes=$_GET['SubCategoria'];

		$this->render('index',array(
			'model'=>$model,
                        'arrayCategoria' => SubCategoria::getArrayCategoria(),
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return SubCategoria the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=SubCategoria::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param SubCategoria $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='sub-categoria-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        /**
         * Deletes a particular model.
         * If deletion is successful, the browser will be redirected to the 'admin' page.
         * @param integer $id the ID of the model to be deleted
         */
        public function actionDelete($id) {
            $model = $this->loadModel($id);
            $model->excluida = 1;
            
            $conditions     = 'sub_categoria_id = ' . $model->id;
            $produto        = Produto::model()->find($conditions);
            $modelPendentes = "";
            
            // Deleta todos os registros dependentes
            if (!empty($produto))
                $modelPendentes = Produto::model()->updateAll(array('excluido' => 1), $conditions);

            if (empty($modelPendentes))
                $model->delete();
            else
                $model->save();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
}
