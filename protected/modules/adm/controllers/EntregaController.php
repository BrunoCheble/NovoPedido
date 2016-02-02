<?php

class EntregaController extends Controller
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
                'actions' => array('index', 'create', 'update', 'delete', 'ajaxGetEntregas'),
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (Yii::app()->request->isAjaxRequest){
        	
			$model=new Entrega;
			$model->_pedidos = $_POST['pedidos'];
			$model->entregador_id = $_POST['entregador_id'];

			if(!empty($model->_pedidos))
        		echo $model->save();

        	Yii::app()->end();
        }
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
		if (Yii::app()->request->isAjaxRequest){
        	
			$model = $this->loadModel($_POST['entrega_id']);
			$model->_pedidos = isset($_POST['pedidos']) ? $_POST['pedidos'] : array();
			
			if(!empty($_POST['entregador_id']))
				$model->entregador_id = $_POST['entregador_id'];
			
        	echo $model->save();

        	Yii::app()->end();
        }
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
		$this->tituloManual = "Lista de entregadores";

        $modelPedido = new CActiveDataProvider('Pedido', array(
		    'criteria' => array(
		        'condition' => 'status = 3 AND excluido = 0'
		    )
		));

        $entregador = '';
        $entrega = '';

        $modelEntregador = '';

        if(isset($_GET['id'])){
			$entrega = $_GET['id'];
        	$modelEntrega = $this->loadModel($entrega);

			$modelEntregaPedido = new CActiveDataProvider('Pedido', array(
			    'criteria' => array(
			        'condition' => 'excluido = 0 AND entrega_id = '.$_GET['id']
			    )
			));	

			$records=array_merge($modelPedido->data,$modelEntregaPedido->data);

			$modelEntregador = Entregador::model()->findByPk($modelEntrega['entregador_id']);
			$entregador = $modelEntregador->id;
        }
        else
        	$records = $modelPedido->data;
 
        $modelPedidoAll = new CArrayDataProvider($records,
		    array(
		        'sort' => array( //optional and sortring
		            'attributes' => array(
		                'codigo', 
		                'data_pedido',
		                'bairro',
		                'endereco',
		                'responsavel',
		                'forma_pagamento_id',
		                'preco_total',
		                'troco'
		            ),
		        ),
		        'pagination' => array('pageSize' => 10) //optional add a pagination
		    )
		);

        $this->render('index', array(
            'modelPedidoAll' => $modelPedidoAll,
            'arrayFormaPagamento' => CHtml::listData(FormaPagamento::model()->ativos()->findAll(),'id','nome'),
            'arrayEntregadores' => CHtml::listData(Entregador::model()->findAll(),'id','nome'),
            'modelEntregador' => $modelEntregador,
            'entregador'=> $entregador,
            'entrega'=> $entrega
        ));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Entrega('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Entrega']))
			$model->attributes=$_GET['Entrega'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Entrega the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Entrega::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Entrega $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='entrega-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function getEntregas(){

		$dataEntrega = array();
        
        if(isset($_POST['entregador_id']))
			$dataEntrega = Entrega::model()->findAllByAttributes(array('entregador_id'=>$_POST['entregador_id']));
	}

	public function actionAjaxGetEntregas(){
        if (Yii::app()->request->isPostRequest && isset($_POST['entregador_id'])) {
                $array = Entrega::model()->findAllByAttributes(array('entregador_id'=>$_POST['entregador_id']));
                echo CJSON::encode(array('entregas'=>$array));
            }
            else
                throw new CHttpException(400);
    }
}
