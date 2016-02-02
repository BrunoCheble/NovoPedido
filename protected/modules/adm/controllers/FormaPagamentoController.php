<?php

class FormaPagamentoController extends Controller
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
				'actions'=>array('index','updateStatus'),
                                'expression' => 'Yii::app()->user->isAdmin()',
			),
		);
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new FormaPagamento('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['FormaPagamento']))
			$model->attributes=$_GET['FormaPagamento'];

		$this->render('index',array(
			'model'=>$model,
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
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return FormaPagamento the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=FormaPagamento::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param FormaPagamento $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='forma-pagamento-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
