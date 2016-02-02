<?php

class Contato extends CFormModel {

    public $name;
    public $email;
    public $subject;
    public $message;

    public function rules() {
        return array(
            array('name, subject, message', 'required'),
            array('email','validEmail'),
            array('name, email, subject, message', 'safe'),
        );
    }

    public function attributeLabels() {
        return array(
            'name' => Yii::t('Contato', 'Nome'),
            'email' => Yii::t('Contato', 'Seu e-mail'),
            'subject' => Yii::t('Contato', 'Assunto'),
            'message' => Yii::t('Contato', 'Mensagem'),
        );
    }

    function validEmail($attribute,$params) {
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL))
            $this->addError('email',Yii::t('Contato','E-mail inválido'));
    }
    
    public function enviar(){
        $message = new YiiMailMessage;
                
        $message->from = $this->email;
        $message->addTo(Yii::app()->params['adminEmail']);
        $message->subject = $this->subject;

        $message->view = "template";
        
        $view = Yii::app()->controller->renderFile(
            Yii::getPathOfAlias('application.modules.pizzaria.views.mail') . '/contato.php', array(
            'de' => $this->name,
            'email' => $this->email,
            'mensagem' => $this->message
            ), true
        );

        $message->setBody(array('content' => $view, 'title' => $this->subject), 'text/html');

        return Yii::app()->mail->send($message) ? true : false;
    }

}

?>
