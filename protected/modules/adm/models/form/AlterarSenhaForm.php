<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class AlterarSenhaForm extends CFormModel
{
	public $novaSenha;
	public $novaSenha2;
	
	public $usuario;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('novaSenha, novaSenha2', 'required'),
			array('novaSenha', 'compare', 'compareAttribute'=>'novaSenha2'),
			array('usuario', 'safe'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'novaSenha' => 'Nova Senha',
			'novaSenha2' => 'Repita a Senha',
			'usuario' => 'Usuario'
		);
	}

	public function afterValidate() {
		$return = parent::afterValidate();
		
		
		if(!$this->usuario->isValidToken()) {
			
			$this->addError('novaSenha',Yii::t('AlterarSenhaForm','Esta chave de acesso não é mais válida'));
		}
		
		return $return;
	}
	
	public function changePassword() {
		
		$this->usuario->token_recupera_senha = null;
		$this->usuario->senha = $this->usuario->getPassword($this->novaSenha);
		return $this->usuario->save();
	}
}
