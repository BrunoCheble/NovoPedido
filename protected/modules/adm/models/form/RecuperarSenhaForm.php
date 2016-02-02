<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class RecuperarSenhaForm extends CFormModel
{
	public $email;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('email', 'required'),
			array('email', 'email'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'email' => 'Email',
		);
	}

	/**
	 * Envia e-mail de recuperação de senha 
	 */
	public function recover() {
		
		if(!$this->validate()) {
		
			return false;
		}
		
		$usuario = Usuario::model()->ativos()->find("email = ?", array($this->email) );
		if($usuario == null){
			
			$this->addError('email', Yii::t('RecuperarSenhaForm', 'Este e-mail está incorreto ou não está cadastrado.'));
		
			return false;
		}
		
		$usuario->geraTokenRecuperacaoSenha();
		
		$assunto = 'Recuperação de senha';
		$view = Yii::app()->controller->renderFile(
			Yii::getPathOfAlias('application.views.mail') . '/recuperarSenha.php', array(
				'usuario' => $usuario
			), true
		);

		$email = new YiiMailMessage;
		$email->view = "template";
		$email->setBody(array('content' => $view, 'title' => $assunto), 'text/html');
		$email->subject = $assunto;
		$email->addTo($this->email);
		$email->from = Yii::app()->params['adminEmail'];

		try {
			
			Yii::app()->mail->send($email);
		} catch (Exception $e) {
			
			Yii::log('Erro ao enviar o e-mail:  '. $e->getMessage(), CLogger::LEVEL_ERROR);
			return false;
		}
		
		return true;
	}
}
