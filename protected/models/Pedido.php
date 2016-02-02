<?php

/**
 * This is the model class for table "pedido".
 *
 * The followings are the available columns in table 'pedido':
 * @property integer $id
 * @property string $data_pedido
 * @property double $preco_total
 * @property integer $forma_pagamento_id
 * @property double $valor_pago
 * @property integer $usuario_id
 * @property double $preco_taxa
 * @property string $cep
 * @property string $endereco
 * @property integer $status
 * @property string $telefone
 * @property string $bairro
 * @property integer $numero
 * @property string $responsavel
 * @property string $complemento
 *
 * The followings are the available model relations:
 * @property Usuario $usuarios
 * @property Pizza[] $pizzas
 * @property ProdutoPedido[] $produtoPedidos
 */
class Pedido extends CActiveRecord
{
        public $troco;
        public $_pizzas;
        public $_produtos;
        public $_promocoes;
        public $_combinados;
        public $pedido_min;
        public $tempo_aguardando;
        public $_endereco_id;
        
        /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pedido';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('preco_total, forma_pagamento_id, valor_pago, preco_taxa, endereco, telefone, bairro, numero, responsavel', 'required'),
			array('forma_pagamento_id, usuario_id, status, numero, excluido, codigo, _endereco_id, entrega_id', 'numerical', 'integerOnly'=>true),
			array('preco_total, valor_pago, preco_taxa', 'numerical'),
			array('cep', 'length', 'max'=>9),
			array('telefone', 'length', 'max'=>10),
			array('observacao', 'length', 'max'=>255),
			array('bairro, responsavel, complemento', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, data_pedido, preco_total, forma_pagamento_id, valor_pago, usuario_id, preco_taxa, cep, endereco, status, telefone, bairro, numero, responsavel, complemento, troco, excluido, codigo, observacao, tempo_aguardando, _endereco_id, entrega_id', 'safe', 'on'=>'search'),
		);
	}

        
        public function scopes()
        {
            $alias = $this->getTableAlias();
        
            return array(
                'orderPrioridade' => array(
                    'order' => 'status asc, data_pedido desc',
                    'condition' => 'excluido = 0'
                ),
                'emAberto' => array(
                    'condition' => 'status = '.Status::_TIPO_AGUARDANDO_.' and excluido = 0'
                ),
                'preparando' => array(
                    'condition' => 'status = '.Status::_TIPO_PREPARANDO_.' and excluido = 0'
                ),
                'filaEntrega' => array(
                    'condition' => 'status = '.Status::_TIPO_FILA_ENTREGA_.' and excluido = 0'
                ),
                'entregando' => array(
                    'condition' => 'status = '.Status::_TIPO_ENTREGANDO_.' and excluido = 0'
                ),
                'entregandoEdisponiveis' => array(
                    'condition' => 'status = '.Status::_TIPO_FILA_ENTREGA_.' or (status = '.Status::_TIPO_ENTREGANDO_.' and entrega_id = null) and excluido = 0'
                ),
                'naoExcluido' => array(
                    'condition' => 'excluido = 0'
                ),
            );
        }
    
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'usuarios'            => array(self::BELONGS_TO, 'Usuario', 'usuario_id'),
            'entregas'            => array(self::BELONGS_TO, 'Entrega', 'entrega_id'),
			'formaPagamentos'     => array(self::BELONGS_TO, 'FormaPagamento', 'forma_pagamento_id'),
			'pizzas'              => array(self::HAS_MANY, 'Pizza', 'pedido_id'),
            'combinadoPedidos'    => array(self::HAS_MANY, 'CombinadoPedido', 'pedido_id'),
			'produtoPedidos'      => array(self::HAS_MANY, 'ProdutoPedido', 'pedido_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'                 => 'ID',
			'codigo'             => 'Código',
			'data_pedido'        => 'Data do pedido',
			'preco_total'        => 'Preço Total',
			'forma_pagamento_id' => 'Forma Pagamento',
			'valor_pago'         => 'Valor Pago',
			'usuario_id'         => 'Usuário',
			'preco_taxa'         => 'Preço Taxa',
			'cep'                => 'CEP',
			'endereco'           => 'Endereço',
			'status'             => 'Status',
			'telefone'           => 'Telefone',
			'bairro'             => 'Bairro',
			'numero'             => 'Número',
			'responsavel'        => 'Responsável',
			'complemento'        => 'Complemento',
			'observacao'         => 'Observação',
            'entrega_id'         => 'Entregador',
			'excluido'           => 'Excluído',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
                $this->beforeSearch();
                
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('codigo',$this->codigo);
		$criteria->compare('data_pedido',$this->data_pedido,true);
		$criteria->compare('preco_total',$this->preco_total);
		$criteria->compare('forma_pagamento_id',$this->forma_pagamento_id);
		$criteria->compare('valor_pago',$this->valor_pago);
		$criteria->compare('usuario_id',$this->usuario_id);
        $criteria->compare('entrega_id',$this->entrega_id);
		$criteria->compare('preco_taxa',$this->preco_taxa);
		$criteria->compare('cep',$this->cep,true);
		$criteria->compare('endereco',$this->endereco,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('telefone',$this->telefone,true);
		$criteria->compare('bairro',$this->bairro,true);
		$criteria->compare('numero',$this->numero);
		$criteria->compare('responsavel',$this->responsavel,true);
		$criteria->compare('complemento',$this->complemento,true);
		$criteria->compare('observacao',$this->observacao,true);
		$criteria->compare('excluido',$this->excluido);
                
                $this->afterSearch();
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Pedido the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
                
    public function afterSave()
    {
        $retorno = parent::afterSave();
        
        if(!$this->isNewRecord)
            return $retorno;
        
        if(isset($this->_produtos))
        {
            foreach($this->_produtos as $produto)
            {
                $modelProdutoPedido             = new ProdutoPedido;
                $modelProdutoPedido->attributes = $produto;
                $modelProdutoPedido->pedido_id  = $this->id;

                $modelProdutoPedido->save();
            }
        }
        
        if(isset($this->_pizzas))
        {
            foreach($this->_pizzas as $pizza)
            {
                $modelPizza              = new Pizza;
                $modelPizza->attributes  = $pizza;
                $modelPizza->pedido_id   = $this->id;
                $modelPizza->_sabores    = $pizza['sabores'];
                $modelPizza->_adicionais = isset($pizza['adicionais']) ? $pizza['adicionais'] : null;
                $modelPizza->save();
            }
        }

        if(isset($this->_combinados))
        {
            foreach($this->_combinados as $combinado)
            {
                $modelCombinadoPedido                  = new CombinadoPedido;
                $modelCombinadoPedido->preco           = $combinado['preco'];
                $modelCombinadoPedido->combinado_id    = $combinado['combinado_id'];
                $modelCombinadoPedido->pedido_id       = $this->id;
                $modelCombinadoPedido->_item_combinado = $combinado['itens_combinado'];

                $modelCombinadoPedido->save();
            }
        }

        $retorno = false;

        return $retorno;
    }

        public function beforeSearch(){
            $this->valor_pago = str_replace(',','.',$this->valor_pago);
            $this->preco_total = str_replace(',','.',$this->preco_total);
        }

        public function afterSearch(){
            $this->valor_pago = str_replace('.',',',$this->valor_pago);
            $this->preco_total = str_replace('.',',',$this->preco_total);
        }
        
        public function beforeValidate()
        {
            $retorno = parent::beforeValidate();
            
            if($this->isNewRecord)
            {
                $modelPizzaria     = Pizzaria::model()->find();
                $modelEndereco     = EnderecoPermitido::model()->findByPk($this->_endereco_id);
                
                $this->preco_taxa  = empty($modelEndereco->frete) ? 0 : $modelEndereco->frete;
                $this->endereco    = $modelEndereco->local;
                $this->bairro      = $modelEndereco->bairro;
                $this->pedido_min  = $modelPizzaria->pedido_min;
                
                $this->status      = Status::_TIPO_AGUARDANDO_;
                $this->data_pedido = date("Y-m-d H:i:s");
                $this->preco_total = $this->preco_taxa;
                $this->codigo      = time();
                
                return $retorno;
            }

            $this->valor_pago  = str_replace(',','.',$this->valor_pago);
            $this->preco_total = str_replace(',','.',$this->preco_total);
            $this->preco_taxa  = str_replace(',','.',$this->preco_taxa);

            return $retorno;
        }
        
        public function afterFind() {
            $this->troco = $this->valor_pago - $this->preco_total;
            $this->tempo_aguardando = $this->getTempoAguardando();
            
            parent::afterFind();
        }
        
        public function beforeSave(){
            
            $retorno = parent::beforeSave();
            $modelPizzaria = new Pizzaria;
            
            if(!$this->isNewRecord) return $retorno;
            
            // Se tiver promoção, direcionar os itens as suas propriedades.
            if(isset($this->_promocoes))
            {
                foreach($this->_promocoes as &$promocao)
                {
                    $modelIP = ItemPromocao::model()->ativos()->findByPk($promocao['item_promocao']);
                    
                    if(!empty($modelIP->produto_id))
                    {
                        $this->_produtos[] = array(
                            'produto_id' => $modelIP->produto_id,
                            'promocao'   => 1,
                            'quantidade' => !empty($promocao['quantidade']) ? $promocao['quantidade'] : null,
                            'preco'      => $modelIP->promocoes->valor
                        );
                    }
                    else
                    {
                        $this->_pizzas[] = array(
                            'sabores'    => array($modelIP->tamanhoSabores->sabor_id),
                            'tamanho_id' => $modelIP->tamanhoSabores->tamanho_id,
                            'preco'      => $modelIP->promocoes->valor,
                            'promocao'   => 1,
                        );
                    }
                    
                }
            }
            else {
                $this->_promocoes = null;
            }
            
            if(isset($this->_produtos))
            {
                foreach ($this->_produtos as &$produto)
                {
                    $modelProduto = Produto::model()->ativos()->findByPk($produto['produto_id']);
                    
                    // Se for um produto promocional é o valor da promocao
                    $this->preco_total += !isset($produto['promocao']) ? $modelProduto->preco * $produto['quantidade'] : $produto['preco'];
                }
            }

            if(isset($this->_combinados))
            {
                foreach ($this->_combinados as &$combinado)
                {                    
                    // Se for um combinado promocional é o valor da promocao
                    if(!empty($combinado['combinado_id']))
                    {
                        $modelCombinado = Combinado::model()->ativos()->findByPk($combinado['combinado_id']);
                        $combinado['preco'] = $modelCombinado->preco;
                    }
                    else
                    {
                        foreach ($combinado['itens_combinado'] as $produto)
                        {
                            $modelProduto = Produto::model()->ativos()->findByPk($produto['produto_id']);
                            $combinado['preco'] += $modelProduto->preco * $produto['quantidade'];
                        }
                    }

                    $this->preco_total += $combinado['preco'];
                }
            }
            
            if(isset($this->_pizzas) && $modelPizzaria->tipo_restaurante == TipoRestaurante::_TIPO_PIZZARIA_)
            {
                foreach($this->_pizzas as &$pizza)
                {
                    $modelTamanho = Tamanho::model()->ativos()->findByPk($pizza['tamanho_id']);

                    if(count($pizza['sabores']) > $modelTamanho->max_qtd_sabor)
                        return false;
                    
                    $valorTamanhoBorda = 0;
                    
                    // Valida se a pizza tem borda recheada (se não tiver permitido ignora).
                    if(isset($pizza['tamanho_borda_id']) && !empty($pizza['tamanho_borda_id']) && $modelPizzaria->borda_pizza)
                    {
                        $modelTamanhoBorda         = TamanhoBorda::model()->ativos()->findByAttributes(array('tamanho_id'=>$modelTamanho->id,'borda_id'=>$pizza['tamanho_borda_id']));
                        $pizza['tamanho_borda_id'] = $modelTamanhoBorda->id;
                        $valorTamanhoBorda         = $modelTamanhoBorda->preco;
                    }

                    $valorTipoMassa = 0;
                    // Valida se a pizza tem massa diferenciada (se não tiver permitido ignora).
                    if(isset($pizza['tamanho_tipo_massa_id']) && !empty($pizza['tamanho_tipo_massa_id']) && $modelPizzaria->massa_pizza)
                    {
                        $modelTamanhoTipoMassa          = TamanhoTipoMassa::model()->ativos()->findByAttributes(array('tamanho_id'=>$modelTamanho->id,'tipo_massa_id'=>$pizza['tamanho_tipo_massa_id']));          
                        $pizza['tamanho_tipo_massa_id'] = $modelTamanhoTipoMassa->id;
                        $valorTipoMassa                 = $modelTamanhoTipoMassa->preco;
                    }

                    $valorAdicionais = 0;
                    $valorSabor      = 0;
                    $i               = 0;
                    
                    foreach($pizza['sabores'] as &$sabor)
                    {
                        $modelTamanhoSabor = TamanhoSabor::model()->ativos()->findByAttributes(array('tamanho_id'=>$modelTamanho->id,'sabor_id'=>$sabor));
                        $sabor             = $modelTamanhoSabor->id;
                        
                        // Se for uma pizza promocional, considere apenas o valor da promoção e só é permitido um sabor por pizza.
                        if(isset($pizza['promocao'])){
                            $valorSabor = $pizza['preco'];
                            break;
                        }
                        
                        if($modelTamanhoSabor->preco > $valorSabor)
                            $valorSabor = $modelTamanhoSabor->preco;
                        
                        if($i > $modelTamanho->max_qtd_sabor)
                            break;
                        
                        $i++;
                    }
                    
                    if(isset($pizza['adicionais']) && $modelPizzaria->adicional_pizza)
                    {
                        foreach($pizza['adicionais'] as &$adicional)
                        {
                            $modelTA   = TamanhoAdicional::model()->naoExcluido()->findByAttributes(array('tamanho_id'=>$modelTamanho->id,'adicional_id'=>$adicional));
                            $adicional = $modelTA->id;

                            $valorAdicionais += $modelTA->preco;                        
                        }
                    }
                        
                    $pizza['preco_total'] = $valorSabor + $valorAdicionais + $valorTipoMassa + $valorTamanhoBorda; 
                    $this->preco_total   += $pizza['preco_total'];
                }
            }
            
            if($this->forma_pagamento_id != FormaPagamento::_TIPO_DINHEIRO_ || $this->valor_pago == 0)
            {
                $this->valor_pago = $this->preco_total;
            }
            else 
            {
                if($this->preco_total > floatval($this->valor_pago)) return false;
            }
            
            return parent::beforeSave();
        }
        
        public function getTempoAguardando(){
            $data_pedido = new DateTime($this->data_pedido);
            $data_dif    = $data_pedido->diff(new DateTime('NOW'));
            
            return $data_dif->h.":".$data_dif->i.":".$data_dif->s;
        }
}
