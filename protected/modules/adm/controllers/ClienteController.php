<?php

class ClienteController extends Controller {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */

    /**
     * @return array action filters
     */
    public function filters() {
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
                'actions' => array('index', 'create', 'update', 'delete'),
                'expression' => 'Yii::app()->user->isAdmin()',
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Cliente;
        $modelUsuario = new Usuario;
            
        $this->tituloManual = "Cadastrar cliente";

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Cliente']))
        {
            $model->attributes = $_POST['Cliente'];
            $modelUsuario->attributes = $_POST['Usuario'];
            
            if($modelUsuario->validate() && $model->validate()){
                if ($model->save())
                {
                    $modelUsuario->cliente_id = $model->id;
                    if($modelUsuario->save())
                    {
                        $this->redirect(array('index'));
                    }
                    
                }
            }
        }

        $this->render('create', array(
            'model' => $model,
            'modelUsuario' => $modelUsuario,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {

        $model = $this->loadModel($id);        
        $modelUsuario = Usuario::model()->findByAttributes(array('cliente_id'=>$id));
        $modelUsuario->setScenario('update');

        $this->tituloManual = "Editar o cliente: " . $model->nome;

        $this->performAjaxValidation($model);


        if (isset($_POST['Cliente'])) {
            $model->attributes = $_POST['Cliente'];
            $modelUsuario->email = $_POST['Usuario']['email'];

            if(!empty($_POST['Usuario']['senha'])){
                $modelUsuario->setScenario('updatePassword');
                $modelUsuario->senha = $_POST['Usuario']['senha'];
                $modelUsuario->senha2 = $_POST['Usuario']['senha2'];
            }

            if($modelUsuario->validate() && $model->validate()){
                if ($model->save())
                {
                    $modelUsuario->cliente_id = $model->id;
                    if($modelUsuario->save())
                    {
                        $this->redirect(array('index'));
                    }
                    
                }
            }
        } else
            $modelUsuario->senha = '';

        $this->render('update', array(
            'model' => $model,
            'modelUsuario' => $modelUsuario
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        $model->excluido = 1;
        
        $model->save();
        
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    /**
     * Manages all models.
     */
    public function actionIndex() {
        $this->tituloManual = "Lista de clientes";
        $model = new Cliente('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Cliente']))
            $model->attributes = $_GET['Cliente'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Sabor the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Cliente::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Sabor $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'cliente-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}