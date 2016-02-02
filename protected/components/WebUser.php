<?php

class WebUser extends CWebUser {

	/**
	 * Usuário
	 * @var Usuario
	 */
	protected $_model;

	/**
	 * Carrega o usuário
	 * @return Usuario 
	 */
    
    function isCliente(){
            
        $user = $this->loadUser(Yii::app()->user->id);
        $db = explode('.',$_SERVER['SERVER_NAME'])[0];
        
        return $user->tipo_usuario == 0 && Yii::app()->user->getState('cliente') == $db;
    }

	function isAdmin(){
            
        $user = $this->loadUser(Yii::app()->user->id);
        $db = explode('.',$_SERVER['SERVER_NAME'])[0];
        
        return $user->tipo_usuario == 1 && Yii::app()->user->getState('cliente') == $db;
    }

    function isAtendimento(){
            
        $user = $this->loadUser(Yii::app()->user->id);
        $db = explode('.',$_SERVER['SERVER_NAME'])[0];
        
        return ($user->tipo_usuario == 1 || $user->tipo_usuario == 2) && Yii::app()->user->getState('cliente') == $db;
    }

    function isCozinha(){
            
        $user = $this->loadUser(Yii::app()->user->id);
        $db = explode('.',$_SERVER['SERVER_NAME'])[0];
        
        return ($user->tipo_usuario == 1 || $user->tipo_usuario == 3) && Yii::app()->user->getState('cliente') == $db;
    }

          // Load user model.
    protected function loadUser($id=null)
    {
        if($this->_model===null)
        {
            if($id!==null)
                $this->_model=Usuario::model()->findByPk($id);
        }
        return $this->_model;
    

    }
}