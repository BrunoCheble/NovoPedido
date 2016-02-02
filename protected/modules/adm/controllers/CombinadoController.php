<?php

class CombinadoController extends Controller
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
			array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'create', 'update','updateStatus', 'delete'),
                'expression' => 'Yii::app()->user->isAdmin()',
            ),
            array('deny', // deny all users
                'users' => array('*'),
            )
        );
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new Combinado;
        $modelProduto = new Produto;
        
        $this->tituloManual = "Cadastrar combinado";

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Combinado']))
		{
			$model->attributes = $_POST['Combinado'];
            $model->_produtoCombinado = isset($_POST['Combinado']['_produtoCombinado']) ? $_POST['Combinado']['_produtoCombinado'] : array();

            if($model->save())
                $this->redirect(array('index'));
		}

		$this->render('create',array(
            'modelProduto' => $modelProduto->getArraySimplesFormatado(),
			'model' => $model,
		));
	}


    public function actionDelete($id) {
        
        $model = $this->loadModel($id);
        
        $model->excluido = 1;
        $modelPendentes = "";
        $conditions = 'combinado_id = ' . $model->id;
        
        $itemCombinado = ItemCombinado::model()->find($conditions);
        
        // Deleta todos os registros dependentes
        if (!empty($itemCombinado))
            $modelPendentes = ItemCombinado::model()->updateAll(array('excluido' => 1), $conditions);
        
        if (empty($modelPendentes))
            $model->delete();
        else
            $model->save();
        
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $modelProduto = new Produto;
        
        $this->tituloManual = "Editar o combinado: " . $model->nome;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Combinado'])) {
            $model->attributes = $_POST['Combinado'];
            $model->_produtoCombinado = isset($_POST['Combinado']['_produtoCombinado']) ? $_POST['Combinado']['_produtoCombinado'] : array();

            if ($model->save())
                $this->redirect(array('index'));
        }
        
        $this->render('update', array(
            'modelProduto' => $modelProduto->getArraySimplesFormatado(),
            'model' => $model
        ));
    }

	public function actionUpdateStatus($id) {
        $model = $this->loadModel($id);
        $status = $model->ativo ? 0 : 1;
        $model->ativo = $status;
        $model->save();

        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */

	/**
	 * Lists all models.
	 */
	public function actionIndex() {
        $this->tituloManual = "Lista de combinados";
        $model = new Combinado('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Combinado']))
            $model->attributes = $_GET['Combinado'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Combinado the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Combinado::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Combinado $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='combinado-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
