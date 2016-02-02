<?php

/**
 * This is the model class for table "item_promocao".
 *
 * The followings are the available columns in table 'item_promocao':
 * @property integer $id
 * @property integer $tamanho_sabor_id
 * @property integer $produto_id
 * @property integer $promocao_id
 * @property integer $ativo
 *
 * The followings are the available model relations:
 * @property Promocao $promocao
 * @property TamanhoSabor $tamanhoSabor
 * @property Produto $produto
 */
class ItemPromocao extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'item_promocao';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tamanho_sabor_id, produto_id, promocao_id, ativo', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, tamanho_sabor_id, produto_id, promocao_id, ativo', 'safe', 'on'=>'search'),
		);
	}

        public function scopes() {
            $alias = $this->getTableAlias();
            return array(
                'ativos' => array(
                    'condition' => "{$alias}.ativo = 1"
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
			'promocoes'      => array(self::BELONGS_TO, 'Promocao', 'promocao_id'),
			'tamanhoSabores' => array(self::BELONGS_TO, 'TamanhoSabor', 'tamanho_sabor_id'),
			'produtos'       => array(self::BELONGS_TO, 'Produto', 'produto_id'),
			'pedidos'        => array(self::HAS_MANY, 'Pedido', 'item_promocao_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'               => 'ID',
			'tamanho_sabor_id' => 'Sabor',
			'produto_id'       => 'Produto',
			'promocao_id'      => 'Promoção',
			'ativo'            => 'Ativo',
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
		$criteria->compare('tamanho_sabor_id',$this->tamanho_sabor_id);
		$criteria->compare('produto_id',$this->produto_id);
		$criteria->compare('promocao_id',$this->promocao_id);
		$criteria->compare('ativo',$this->ativo);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ItemPromocao the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function beforeSave() {
            $return = parent::beforeSave();
            
            if($this->ativo == 0 && empty($this->pedidos)){
                $this->delete();
                return false;
            }
            
            return $return;
        }
        
        public function getDescricaoItem()
        {
            if(!empty($this->produto_id))
                return $this->produtos->nome." (".$this->produtos->descricao.")";
            
            return $this->tamanhoSabores->sabores->descricao." (".$this->tamanhoSabores->tamanhos->descricao.")";
        }
}
