<?php

class PromocaoController extends Controller {
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
                'actions' => array('index', 'create', 'update','updateStatus'),
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
        $model             = new Promocao;
        $modelTamanhoSabor = new TamanhoSabor;
        $modelProduto      = new Produto;
        
        $this->tituloManual = "Cadastrar promoção";

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Promocao'])) {
            $model->attributes = $_POST['Promocao'];
            $model->_pizzaPromocao   = isset($_POST['Promocao']['_pizzaPromocao']) ? $_POST['Promocao']['_pizzaPromocao'] : array();
            $model->_produtoPromocao = isset($_POST['Promocao']['_produtoPromocao']) ? $_POST['Promocao']['_produtoPromocao'] : array();

            if ($model->save())
                $this->redirect(array('index'));
        }

        $this->render('create', array(
            'modelTamanhoSabor' => $modelTamanhoSabor->getArraySimplesFormatado(),
            'modelProduto'      => $modelProduto->getArraySimplesFormatado(),
            'model'             => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $modelTamanhoSabor = new TamanhoSabor;
        $modelProduto = new Produto;
        
        $this->tituloManual = "Editar a promoção: #" . $model->id;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Promocao'])) {
            $model->attributes = $_POST['Promocao'];
            $model->_pizzaPromocao   = isset($_POST['Promocao']['_pizzaPromocao']) ? $_POST['Promocao']['_pizzaPromocao'] : array();
            $model->_produtoPromocao = isset($_POST['Promocao']['_produtoPromocao']) ? $_POST['Promocao']['_produtoPromocao'] : array();

            if ($model->save())
                $this->redirect(array('index'));
        }
        
        $this->render('update', array(
            'modelTamanhoSabor' => $modelTamanhoSabor->getArraySimplesFormatado(),
            'modelProduto'      => $modelProduto->getArraySimplesFormatado(),
            'model' => $model,
        ));
    }

    public function actionUpdateStatus($id) {
        $model = $this->loadModel($id);
        $status = $model->ativa ? 0 : 1;
        $model->ativa = $status;
        $model->save();

        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }


    /**
     * Manages all models.
     */
    public function actionIndex() {
        $this->tituloManual = "Lista de promoções";
        $model = new Promocao('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Promocao']))
            $model->attributes = $_GET['Promocao'];

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
        $model = Promocao::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Sabor $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'promocao-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
