<?php

/**
 * This is the model class for table "promocao".
 *
 * The followings are the available columns in table 'promocao':
 * @property integer $id
 * @property string $descricao
 * @property integer $desconto
 * @property double $valor
 * @property double $valor_min
 * @property integer $ativa
 *
 * The followings are the available model relations:
 * @property ItemPromocao[] $itemPromocaos
 * @property Pedido[] $pedidos
 */
class Promocao extends CActiveRecord
{
    public $_pizzaPromocao = array();
    public $_produtoPromocao = array();
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'promocao';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('desconto, ativa, excluida', 'numerical', 'integerOnly'=>true),
			array('valor, valor_min', 'numerical'),
			array('descricao', 'length', 'max'=>255),
            array('valor, valor_min, desconto', 'default','value'=>0),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, descricao, desconto, quantidade, valor, valor_min, ativa, excluida', 'safe', 'on'=>'search'),
		);
	}

    public function scopes() {
        $alias = $this->getTableAlias();
        return array(
            'naoExcluido' => array(
                'condition' => "$alias.excluida = 0",
            ),
            'ativas' => array(
                'condition' => "$alias.ativa = 1 AND {$alias}.excluida = 0",
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
			'itemPromocoes' => array(self::HAS_MANY, 'ItemPromocao', 'promocao_id'),
			'pedidos' => array(self::HAS_MANY, 'Pedido', 'promocao_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'descricao' => 'Descrição',
			'desconto' => 'Desconto',
            'quantidade' => 'Quantidade',
			'valor' => 'Valor',
			'valor_min' => 'Valor Mínimo',
			'ativa' => 'Ativa',
			'excluida' => 'Excluída',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('descricao',$this->descricao,true);
		$criteria->compare('desconto',$this->desconto);
        $criteria->compare('quantidade',$this->quantidade);
		$criteria->compare('valor',$this->valor);
		$criteria->compare('valor_min',$this->valor_min);
		$criteria->compare('ativa',$this->ativa);
		$criteria->compare('excluida',$this->excluida);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function beforeSearch() {
        $this->valor     = str_replace(',', '.', $this->valor);
        $this->valor_min = str_replace(',', '.', $this->valor_min);
    }

    public function afterSearch() {
        $this->valor     = str_replace('.', ',', $this->valor);
        $this->valor_min = str_replace('.', ',', $this->valor_min);
    }

    public function beforeValidate() {
        if (!empty($this->valor))
            $this->valor = str_replace(',', '.', $this->valor);
        
        if (!empty($this->valor_min))
            $this->valor_min = str_replace(',', '.', $this->valor_min);

        return parent::beforeValidate();
    }
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Promocao the static model class
	 */

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
    public function afterSave() {

        $return = parent::afterSave();
        
        // Atualizar
        ItemPromocao::model()->updateAll(array('ativo'=>0), 'promocao_id = ' . $this->id);

        foreach($this->mergerItemPromocao() as $tipo => $item)
        {    
            $criteria = new CDbCriteria;
            $criteria->compare('produto_id', $item);
            $criteria->compare('tamanho_sabor_id', $item,false,'OR');
            $criteria->addCondition('promocao_id = '.$this->id);

            $modelItemPromocaoExist = ItemPromocao::model()->find($criteria);
            
            if(!empty($modelItemPromocaoExist)){
                $modelItemPromocaoExist->ativo = 1;
                $modelItemPromocaoExist->save();
            } 
            else{
                $modelItemPromocao = new ItemPromocao;
                if(key($item) == 'produto_id'){
                    $modelItemPromocao->produto_id = $item['produto_id'];
                }
                else{
                    $modelItemPromocao->tamanho_sabor_id = $item['tamanho_sabor_id'];
                }
                $modelItemPromocao->promocao_id = $this->id;
                $modelItemPromocao->ativo = 1;
                $modelItemPromocao->save();
            }
        }
            
        return $return;
    }
        
    public function afterFind() {
        $return = parent::afterFind();
        
        foreach($this->itemPromocoes as $value)
        {
            if($value->ativo == 0)
                continue;
            
            if(!empty($value->produto_id)){
                $this->_produtoPromocao[] = $value->produto_id;
            }
            else{
                $this->_pizzaPromocao[] = $value->tamanho_sabor_id;
            }
        }
        
        return $return;
    }

    public function mergerItemPromocao(){
        foreach($this->_pizzaPromocao as $pizza){
            $return[] = array(
                'tamanho_sabor_id' => $pizza
            );
        }
        foreach($this->_produtoPromocao as $produto){
            $return[] = array(
                'produto_id' => $produto
            );
        }
        
        return $return;
    }

    public function getArrayItensPromocao(){
        $opcoes = array();
        foreach($this->itemPromocoes as $index => $value)
        {
            if(!$value->ativo)
                continue;
            
            $descricao = !empty($value->produtos) ? $value->produtos->nome : $value->tamanhoSabores->sabores->descricao;
            $opcoes[$value->id] = $descricao;
        }
        
        return $opcoes;
    }

}
