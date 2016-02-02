<?php
/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    /**
     * ID do usuário buscado através do login
     * @var integer 
     */
    protected $_id;

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {   
        $user = Usuario::model()->find("lower(email) = ?",array(strtolower($this->username)));
        
        if($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
			return !$this->errorCode;	
        }

        if(!$user->validatePassword($this->password))
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
	else {
            
            $this->_id = $user->id;
            
            Yii::app()->user->setState('cliente', $user->database);
            
            $this->errorCode=self::ERROR_NONE;
            $user->ultimo_acesso = date("Y-m-d H:i:s");
            $user->save();
        }
		
        return !$this->errorCode;	
    }
    
    public function getId()
    {
        return $this->_id;
    }
}