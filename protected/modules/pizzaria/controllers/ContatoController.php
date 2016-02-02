<?php

/**
 * Controlador inicial
 */
class ContatoController extends Controller {
    public $layout = 'pages';
    
    public function actionIndex() {
        $this->tituloManual = "Contato";
        $model = new Contato;

        if (isset($_POST['Contato'])) {
            $model->attributes = $_POST['Contato'];
            if($model->validate()){
                if($model->enviar())
                    Yii::app()->user->setFlash('success','Mensagem enviada com sucesso!');
                else
                    Yii::app()->user->setFlash('error','Houve um erro, ao enviar o formulário, tente novamente.');
            }
        }

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionError() {

        $this->tituloManual = 'Erro | ' . Yii::app()->name;

        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

}
