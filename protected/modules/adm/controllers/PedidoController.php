<?php

class PedidoController extends Controller
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
			array(
				'allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=> array(
					'index',
					'update',
					'view',
					'delete',
					'itensPedido',
					'dashboard',
					'updateStatus',
					'updateAllStatus'
				),
                'expression' => 'Yii::app()->user->isAtendimento()',
			),
			array(
				'allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=> array(
					'updateStatus',
					'cozinha'
				),
                'expression' => 'Yii::app()->user->isCozinha()',
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
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
                $this->tituloManual = "Pedido do(a) cliente: ".$model->responsavel." (".$model->codigo.")";

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Pedido']))
		{
			$model->attributes=$_POST['Pedido'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model'=>$model,
            'arrayStatus' => Status::getArray(),
            'arrayFormaPagamento' => CHtml::listData(FormaPagamento::model()->ativos()->findAll(),'id','nome'),
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id = null)
	{
		$id = empty($id) ? $_POST['id'] : $id;
		
		$model = $this->loadModel($id);
        $model->excluido = 1;
        
        $saved = $model->save();
                    
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(Yii::app()->request->isAjaxRequest)
        	echo $saved;
        else
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
        $this->tituloManual = "Lista de pedidos";
		$model=new Pedido('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Pedido']))
			$model->attributes=$_GET['Pedido'];

		$this->render('index',array(
			'model'=>$model,
            'arrayStatus' => Status::getArray(),
            'arrayFormaPagamento' => CHtml::listData(FormaPagamento::model()->findAll(),'id','nome'),
		));
	}
        
    // Dashboard
    public function actionDashboard()
	{
        $this->tituloManual = "Dashboard";
        
        $modelPedidosAberto     = Pedido::model()->emAberto()->findAll();
        $dataPedidosAberto      = new CArrayDataProvider($modelPedidosAberto);
        
        $modelPedidosPreparando = Pedido::model()->preparando()->findAll();
        $dataPedidosPreparando  = new CArrayDataProvider($modelPedidosPreparando);

        $modelPedidosFilaEntrega = Pedido::model()->filaEntrega()->findAll();
        $dataPedidosFilaEntrega  = new CArrayDataProvider($modelPedidosFilaEntrega);    

        $modelPedidosEntregando = Pedido::model()->entregando()->findAll();
        $dataPedidosEntregando  = new CArrayDataProvider($modelPedidosEntregando);    


		$this->render('dashboard',array(
			'dataPedidosAberto'      => $dataPedidosAberto,
			'dataPedidosPreparando'  => $dataPedidosPreparando,
			'dataPedidosFilaEntrega' => $dataPedidosFilaEntrega,
			'dataPedidosEntregando'  => $dataPedidosEntregando,
		));
	}
        
        public function actionItensPedido($id){
                
                $model = $this->loadModel($id);
                
                $dataProdutoPedido = new CArrayDataProvider('ProdutoPedido');
                $dataProdutoPedido->setData($model->produtoPedidos);
                
                $modelPizzaria = Pizzaria::model()->find();

                $dataPizzas = array();
                $dataCombinados = array();
                
                switch ($modelPizzaria->tipo_restaurante) {
		            case TipoRestaurante::_TIPO_PIZZARIA_:
		                $dataPizzas = new CArrayDataProvider('Pizza');
		                $dataPizzas->setData($model->pizzas);
		                break;
		            default:
		               	$dataCombinados = new CArrayDataProvider('CombinadoPedido');
		                $dataCombinados->setData($model->combinadoPedidos);
		                break;
		        }

                $this->render('itens_pedido',array(
						'model'             => $model,
                        'dataPizzas'        => $dataPizzas,
                        'dataCombinados'    => $dataCombinados,
                        'dataProdutoPedido' => $dataProdutoPedido,
                        'modelPizzaria'     => $modelPizzaria,
				));
        }

        public function actionCozinha($id = null){
                
                $dataPizzas = array();
                $dataCombinados = array();
                $dataProdutoPedido = array();

                $model = array();

				$modelPizzaria = Pizzaria::model()->find();

                if(!empty($id)){
                	$model = $this->loadModel($id);

	                $dataProdutoPedido = new CArrayDataProvider('ProdutoPedido');
	                $dataProdutoPedido->setData($model->produtoPedidos);

	                switch ($modelPizzaria->tipo_restaurante) {
			            case TipoRestaurante::_TIPO_PIZZARIA_:
			                $dataPizzas = new CArrayDataProvider('Pizza');
			                $dataPizzas->setData($model->pizzas);
			                break;
			            default:
			               	$dataCombinados = new CArrayDataProvider('CombinadoPedido');
			                $dataCombinados->setData($model->combinadoPedidos);
			                break;
			        }
                }
                

		        $modelPedidosPreparando = Pedido::model()->preparando()->findAll();
		        $dataPedidosPreparando  = new CArrayDataProvider($modelPedidosPreparando);

                $this->render('cozinha',array(
						'model'             => $model,
                        'dataPizzas'        => $dataPizzas,
                        'dataCombinados'    => $dataCombinados,
                        'dataProdutoPedido' => $dataProdutoPedido,
                        'modelPizzaria'     => $modelPizzaria,
						'dataPedidosPreparando' => $dataPedidosPreparando,
				));
        }

        /**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Pedido the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Pedido::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
        
	public function actionUpdateAllStatus()
	{
		foreach ($_POST['pedidos'] as $id_pedido)
		{
			$model = Pedido::model()->findByPk($id_pedido);

			if($model===null)
            	throw new CHttpException(404,'The requested page does not exist.');

        	$model->status = $_POST['status'];        

    		$saved = 1;

        	if(!$model->save()){
        		$saved = 'Houve um erro ao salvar alguns pedidos';
        		break;
        	}
		}

		echo $saved;

    	Yii::app()->end();
	}   

    public function actionUpdateStatus()
	{
		$model = Pedido::model()->findByPk($_POST['id']);
                
		if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');

        $model->status = $_POST['status'];        

        $saved = $model->save();      

        if (Yii::app()->request->isAjaxRequest){
        	echo $saved;
        	Yii::app()->end();
        }
    	else
	        $this->redirect(array('dashboard'));

	}

	/**
	 * Performs the AJAX validation.
	 * @param Pedido $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='pedido-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
}
