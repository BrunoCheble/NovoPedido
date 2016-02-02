<?php

/**
 * This is the model class for table "combinado_pedido".
 *
 * The followings are the available columns in table 'combinado_pedido':
 * @property integer $id
 * @property double $preco
 * @property integer $pedido_id
 * @property integer $combinado_id
 *
 * The followings are the available model relations:
 * @property Combinado $combinado
 * @property Pedido $pedido
 */
class CombinadoPedido extends CActiveRecord
{
	public $_item_combinado = [];

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'combinado_pedido';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('preco, pedido_id', 'required'),
			array('pedido_id, combinado_id', 'numerical', 'integerOnly'=>true),
			array('preco', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, preco, pedido_id, combinado_id', 'safe', 'on'=>'search'),
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
			'combinados' 		   => array(self::BELONGS_TO, 'Combinado', 'combinado_id'),
			'pedidos' 			   => array(self::BELONGS_TO, 'Pedido', 'pedido_id'),
			'itemCombinadoPedidos' => array(self::HAS_MANY, 'ItemCombinadoPedido', 'combinado_pedido_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'preco' => 'Preco',
			'pedido_id' => 'Pedido',
			'combinado_id' => 'Combinado',
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
		$criteria->compare('preco',$this->preco);
		$criteria->compare('pedido_id',$this->pedido_id);
		$criteria->compare('combinado_id',$this->combinado_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CombinadoPedido the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function afterSave(){
            
        $retorno = parent::afterSave();

        if(!$this->isNewRecord)
            return $retorno;

        foreach ($this->_item_combinado as $item_combinado) {
            $modelItemCombinadoPedido = new ItemCombinadoPedido;
            $modelItemCombinadoPedido->attributes = $item_combinado;
            $modelItemCombinadoPedido->combinado_pedido_id = $this->id;
            
            $modelItemCombinadoPedido->save();
        }
        return $retorno;
    }
    
}
