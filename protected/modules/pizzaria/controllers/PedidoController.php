<?php

/**
 * Controlador inicial
 */
class PedidoController extends Controller {

    //public $layout = 'pages';
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
                    'actions'    => array('index','visualizar','ajaxSave'),
                ),
                array('deny',  // deny all users
                        'users'=>array('*'),
                ),
        );
    }

    public function actionIndex() {
        
        $this->tituloManual = "Novo pedido";
        
        $modelPizzaria = Pizzaria::model()->find();
        $modelBanner   = Banner::model()->ativos()->find();
        
        if(!$this->validaSituacao())
        {
            $this->render('indisponivel', array(
                'modelPizzaria' => $modelPizzaria,
                'modelBanner'   => $modelBanner,
            ));
            
            Yii::app()->end();
        }
        
        $dataBebidas      = new Produto;
        $dataPratosLanche = new Produto;
        $dataPromocao     = new Promocao;
        
        $modelSabor = array();
        $modelTamanho = array();
        $arrayTipoSabor = array();
        $listCombinado = array();

        switch ($modelPizzaria->tipo_restaurante) {
            case TipoRestaurante::_TIPO_PIZZARIA_:
                $modelSabor = Sabor::model()->ativos()->findAll();
                $modelTamanho = Tamanho::getArrayTamanho();
                $arrayTipoSabor = TipoSabor::getArrayTipoSabor();
                break;
            
            default:
                $listCombinado = CHtml::listData(Combinado::model()->ativos()->findAll(),'id','nome');
                break;
        }

        $this->render('index', array(
            'modelPedido'           => new Pedido,
            'loginForm'             => new LoginForm,
            'modelCliente'          => new Cliente,
            'modelUsuario'          => new Usuario,
            
            'dataBebidas'           => $dataBebidas->ativos()->bebidas()->search(),
            'dataPratosLanche'      => $dataPratosLanche->ativos()->pratoLanche()->search(),
            'dataPromocao'          => $dataPromocao->ativas()->search(),
            
            'modelSabor'            => $modelSabor,
            'modelTamanho'          => $modelTamanho,
            'arrayTipoSabor'        => $arrayTipoSabor,
            
            'modelPizzaria'         => $modelPizzaria,
            
            'arrayBairro'           => CHtml::listData(EnderecoPermitido::model()->ativos()->findAll(array('group'=>'bairro','distinct'=>true)),'bairro','bairro'),
            'arrayFormaPagamento'   => CHtml::listData(FormaPagamento::model()->ativos()->findAll(),'id','nome'),
            'listCombinado'         => $listCombinado,

            'modelBanner'           => $modelBanner,
        ));
    }
    
    public function actionVisualizar($codigo = "")
    {
        $model = new Pedido;
        
        $naoEncontrado = "";
        
        if(isset($_POST['Pedido']))
        {
            $codigo = $_POST['Pedido']['codigo'];
        }
        
        if(!empty($codigo))
        {
            $model = Pedido::model()->naoExcluido()->findByAttributes(array('codigo'=>$codigo));
            
            if($model == null){
                $model = new Pedido;
                $naoEncontrado = "Pedido não encontrado";
            }
        } else
            $codigo = "Insira o seu código";
        

        $this->render('visualizar',array(
            'model' =>  $model,
            'codigo' => $codigo,
            'naoEncontrado' => $naoEncontrado,
        ));
    }
    
    
    public function actionAjaxValidate() {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new Pedido;
            $model->attributes = $_POST['Pedido'];

            $errors = CActiveForm::validate($model);

            if ($errors !== '[]'){
                echo $errors;
                Yii::app()->end();
            }
        }
        else
            throw new CHttpException(400);
    }
    
    public function actionAjaxSave() {
        if (Yii::app()->request->isAjaxRequest) {
            
            if(!$this->validaSituacao())
            {
                echo false;
                Yii::app()->end();
            }
        
            $model = new Pedido;
            $model->_pizzas     = isset($_POST['arrayPizza']) ? $_POST['arrayPizza'] : array();
            $model->_combinados = isset($_POST['arrayCombinado']) ? $_POST['arrayCombinado'] : array();
            $model->_produtos   = isset($_POST['arrayProduto']) ? $_POST['arrayProduto'] : array();
            $model->_promocoes  = isset($_POST['arrayPromocao']) ? $_POST['arrayPromocao'] : array();
            $model->attributes  = $_POST['arrayPedido'];

            if(!Yii::app()->user->isGuest){
                $model->usuario_id = Yii::app()->user->id;
            }
            
            $saved = $model->save() ? $model->codigo : false;
            
            echo $saved;
            
            Yii::app()->end();
        }
        else
            throw new CHttpException(400);
    }
    
}
