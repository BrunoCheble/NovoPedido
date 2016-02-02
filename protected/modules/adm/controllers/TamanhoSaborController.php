<?php
class TamanhoSaborController extends Controller
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
				'actions' => array('index','create','update','view','delete','saveAll','updateStatus'),
                'expression' => 'Yii::app()->user->isAdmin()'
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
                $this->tituloManual = "Cadastrar tamanho de sabor de pizza";
		$model=new TamanhoSabor;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TamanhoSabor']))
		{
			$model->attributes=$_POST['TamanhoSabor'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('create',array(
			'model'=>$model,
                        'arraySabor' => CHtml::listData(Sabor::model()->findAll(),'id','descricao'),
                        'arrayTamanho' => CHtml::listData(Tamanho::model()->findAll(),'id','descricao'),
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
                $this->tituloManual = "Editar o tamanho de sabor de pizza: ".$model->sabores->descricao." (".$model->tamanhos->descricao.")";

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TamanhoSabor']))
		{
			$model->attributes=$_POST['TamanhoSabor'];
			if($model->save())
				$this->redirect(array('saveAll'));
		}

		$this->render('update',array(
			'model'=>$model,
                        'arraySabor' => CHtml::listData(Sabor::model()->findAll(),'id','descricao'),
                        'arrayTamanho' => CHtml::listData(Tamanho::model()->findAll(),'id','descricao'),
		));
	}
        
        public function actionUpdateStatus($id)
	{
		$model = $this->loadModel($id);
                
                $model->ativa = $model->ativa ? 0 : 1;
                
                if($model->save())
                        $this->redirect(array('index'));

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
            $conditions = 'tamanho_sabor_id = ' . $model->id;
            $sabor = PizzaTamanhoSabor::model()->find($conditions);
            
            if (empty($sabor))
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
        $this->tituloManual = "Lista de tamanhos de sabores de pizza";
		$model=new TamanhoSabor('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TamanhoSabor']))
			$model->attributes=$_GET['TamanhoSabor'];

		$this->render('index',array(
			'model'=>$model,
                        'arraySabor' => CHtml::listData(Sabor::model()->findAll(),'id','descricao'),
                        'arrayTamanho' => CHtml::listData(Tamanho::model()->findAll(),'id','descricao'),
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return TamanhoSabor the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=TamanhoSabor::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param TamanhoSabor $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tamanho-sabor-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
    public function actionSaveAll()
	{
            $this->tituloManual = "Gerenciador de preços de sabores de pizza";
            
            $return = true;
            $modelItem = Sabor::model()->naoExcluido()->ordenarPorDescricao()->findAll(); // Alterar 2
            
            if(isset($_POST['TamanhoSabor']) && !empty($_POST['TamanhoSabor']['sabor_id'])) // Alterar 1
            {
                $arrayItem = $_POST['TamanhoSabor']['sabor_id']; // Alterar 3
                
                foreach($_POST['TamanhoSabor']['preco'] as $key_preco => $preco){ // Alterar 2
                    if(empty($preco)) continue;
                    
                    foreach($arrayItem as $item){ // Alterar 2
                        $tamanho_id = $_POST['TamanhoSabor']['tamanho_id'][$key_preco]; // Alterar 2
                        $model = TamanhoSabor::model()->findByAttributes(array('sabor_id'=>$item,'tamanho_id'=>$tamanho_id)); // Alterar 3

                        if(empty($model)) $model = new TamanhoSabor();
                        
                        $model->sabor_id   = $item;  // Alterar 2
                        $model->tamanho_id = $tamanho_id;
                        $model->preco      = $preco;
                        
                        if(!$model->save()) $return = false;
                    }
                }
            }

            $this->render('save_all',array(
                'return'       => $return,
                'arrayTamanho' => CHtml::listData(Tamanho::model()->naoExcluido()->findAll(),'id','descricao'),
                'modelItens'   => $modelItem,
                'arrayItens'   => CHtml::listData($modelItem,'id','descricao'),
            ));
	}
}
