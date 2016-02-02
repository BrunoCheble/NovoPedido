<?php

/**
 * This is the model class for table "pizza".
 *
 * The followings are the available columns in table 'pizza':
 * @property integer $id
 * @property integer $tamanho_id
 * @property integer $pedido_id
 * @property double $preco_total
 * @property integer $tamanho_borda_id
 * @property integer $tamanho_tipo_massa_id
 *
 * The followings are the available model relations:
 * @property Tamanho $tamanho
 * @property TamanhoBorda $tamanhoBorda
 * @property Pedido $pedido
 * @property TamanhoTipoMassa $tamanhoTipoMassa
 * @property PizzaTamanhoSabor[] $pizzaTamanhoSabors
 */
class Pizza extends CActiveRecord
{
        public $_sabores;
        public $_adicionais;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pizza';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tamanho_id, pedido_id, preco_total', 'required'),
			array('tamanho_id, pedido_id, tamanho_borda_id, tamanho_tipo_massa_id, promocao', 'numerical', 'integerOnly'=>true),
			array('preco_total', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, tamanho_id, pedido_id, preco_total, tamanho_borda_id, tamanho_tipo_massa_id, promocao', 'safe', 'on'=>'search'),
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
			'tamanhos'               => array(self::BELONGS_TO, 'Tamanho', 'tamanho_id'),
			'tamanhoBordas'          => array(self::BELONGS_TO, 'TamanhoBorda', 'tamanho_borda_id'),
			'pedidos'                => array(self::BELONGS_TO, 'Pedido', 'pedido_id'),
			'tamanhoTipoMassas'      => array(self::BELONGS_TO, 'TamanhoTipoMassa', 'tamanho_tipo_massa_id'),
			'pizzaTamanhoSabores'    => array(self::HAS_MANY, 'PizzaTamanhoSabor', 'pizza_id'),
                        'pizzaTamanhoAdicionais' => array(self::HAS_MANY, 'PizzaTamanhoAdicional', 'pizza_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tamanho_id' => 'Tamanho',
			'pedido_id' => 'Pedido',
			'preco_total' => 'Preco Total',
			'tamanho_borda_id' => 'Tamanho Borda',
			'tamanho_tipo_massa_id' => 'Tamanho Tipo Massa',
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
		$criteria->compare('tamanho_id',$this->tamanho_id);
		$criteria->compare('pedido_id',$this->pedido_id);
		$criteria->compare('preco_total',$this->preco_total);
		$criteria->compare('tamanho_borda_id',$this->tamanho_borda_id);
		$criteria->compare('tamanho_tipo_massa_id',$this->tamanho_tipo_massa_id);
		$criteria->compare('promocao',$this->promocao);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Pizza the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        public function afterSave()
        {
            $retorno = parent::afterSave();
            
            if(!$this->isNewRecord){
                return $retorno;
            }
            
            foreach($this->_sabores as $sabor)
            {
                $modelPTS                   = new PizzaTamanhoSabor;
                $modelPTS->tamanho_sabor_id = $sabor;
                $modelPTS->pizza_id         = $this->id;

                $modelPTS->save();
            }
            
            if(!empty($this->_adicionais))
            {
                foreach($this->_adicionais as $adicional)
                {
                    $modelPTA                       = new PizzaTamanhoAdicional;
                    $modelPTA->tamanho_adicional_id = $adicional;
                    $modelPTA->pizza_id             = $this->id;

                    $modelPTA->save();
                }
            }
            
            return $retorno;
        }
}
