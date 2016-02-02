<?php

/**
 * This is the model class for table "item_combinado_pedido".
 *
 * The followings are the available columns in table 'item_combinado_pedido':
 * @property integer $id
 * @property integer $combinado_pedido_id
 * @property integer $quantidade
 * @property integer $produto_id
 *
 * The followings are the available model relations:
 * @property Combinado $combinadoPedido
 * @property Produto $produto
 */
class ItemCombinadoPedido extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'item_combinado_pedido';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('combinado_pedido_id, produto_id', 'required'),
			array('combinado_pedido_id, quantidade, produto_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, combinado_pedido_id, quantidade, produto_id', 'safe', 'on'=>'search'),
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
			'combinadoPedidos' => array(self::BELONGS_TO, 'Combinado', 'combinado_pedido_id'),
			'produtos' => array(self::BELONGS_TO, 'Produto', 'produto_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'combinado_pedido_id' => 'Combinado Pedido',
			'quantidade' => 'Quantidade',
			'produto_id' => 'Produto',
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
		$criteria->compare('combinado_pedido_id',$this->combinado_pedido_id);
		$criteria->compare('quantidade',$this->quantidade);
		$criteria->compare('produto_id',$this->produto_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ItemCombinadoPedido the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
