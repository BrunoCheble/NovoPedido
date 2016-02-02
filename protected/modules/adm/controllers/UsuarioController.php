<?php

class UsuarioController extends Controller
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
				'actions'=>array('login','logout', 'esqueciASenha','trocaSenha'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','delete','view','index','logout'),
                                'expression' => 'Yii::app()->user->isAdmin()',
			),
			array('allow',
				'actions'=>array('updatePassword'),
				'users' => array('Yii::app()->user->isAdmin()'),
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
		$model=new Usuario;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Usuario']))
		{
			$model->attributes=$_POST['Usuario'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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

		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);

		if(isset($_POST['Usuario']))
		{
			$model->attributes=$_POST['Usuario'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
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
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$model=new Usuario('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Usuario']))
			$model->attributes=$_GET['Usuario'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Usuario the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Usuario::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Usuario $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='usuario-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        public function actionLogin() {
                $model = new LoginForm;
                
                if(!Yii::app()->user->isGuest && Yii::app()->user->isAdmin()){
                        $this->redirect(array('pedido/index'));
                }
                
                // collect user input data
                if (Yii::app()->request->isPostRequest) {
                    if (isset($_POST['LoginForm'])) {
                        $model->attributes = $_POST['LoginForm'];
                        
                        if ($model->validate() && $model->login())
                        {
                            if(!empty($_POST['LoginForm']['config']))
                            {
                                $this->redirect(array('pizzaria/mobile'));
                            }

                            if(Yii::app()->user->isAdmin())
                            	$this->redirect(array('entrega/index'));
                            else if(Yii::app()->user->isAtendimento())
                            	$this->redirect(array('pedido/dashboard'));
                            else if(Yii::app()->user->isCozinha())
                            	$this->redirect(array('pedido/cozinha'));
                        }
                    }
                }

                $this->render('login', array('model' => $model));
        }

        public function actionLogout() {
                Yii::app()->user->logout();

                $this->redirect(Yii::app()->getBaseUrl(true));
        }
        
        public function actionEsqueciASenha()
	{
            $model = new RecuperarSenhaForm;

            if(Yii::app()->request->isPostRequest){

                            if(isset($_POST['RecuperarSenhaForm'])) {

                                    $model->attributes = $_POST['RecuperarSenhaForm'];
                                    if($model->validate() && $model->recover()) {

                                            $model->email = null;
                                            Yii::app()->user->setFlash('success', Yii::t('Site','Seus dados de acesso foram enviados para o seu email.'));
                                    }
                                    else {

                                            Yii::app()->user->setFlash('error', Yii::t('Site','Ocorreu um erro ao enviar o e-mail de recuperação.'));
                                    }
                            }
            }

            $this->render('esqueciASenha', array('model'=>$model));
        }
	
	public function actionUpdatePassword() {
		
		$model=$this->loadModel(Yii::app()->user->id);
		$model->scenario = 'updatePassword';
		$model->senha = null;
		
		if(isset($_POST['Usuario']))
		{
			$model->attributes=$_POST['Usuario'];
			
			if($model->save()) {
				Yii::app()->user->setFlash('success', Yii::t('Usuario', 'Senha alterada com suceso'));
				$this->redirect(array('index'));
			}
		}

		$this->render('updatePassword',array(
			'model'=>$model,
		));
	}
        
        public function actionTrocaSenha($token) {
		
		$model = new AlterarSenhaForm;

		$usuarioToken = Usuario::model()->find('token_recupera_senha = :token_recupera_senha', array(
			':token_recupera_senha' => $token
		));
		
		if(!$usuarioToken instanceof Usuario) {
			Yii::app()->user->setFlash('error', Yii::t('Site','Esta chave de acesso não existe ou já foi utilizada.'));
		}
		else {
			$model->usuario = $usuarioToken;
			$model->usuario->scenario = 'recoverPassword';
			
			if(Yii::app()->request->isPostRequest){

				if(isset($_POST['AlterarSenhaForm'])) {

					$model->attributes = $_POST['AlterarSenhaForm'];
					if($model->validate() && $model->changePassword()) {

						Yii::app()->user->setFlash('success', Yii::t('Site','Sua senha foi atualizada'));
						
						$modelLogin = new LoginForm;
						$modelLogin->username = $model->usuario->login;
						$modelLogin->password = $model->novaSenha;
						$modelLogin->login();
						
						$this->redirect(array('index'));
					}
					else {
						Yii::app()->user->setFlash('error', Yii::t('Site','Ocorreu um erro ao atualizar sua senha'));
					}
				}
			}
		}
		
		$this->render('trocaSenha', array('model'=>$model));
	}

}
