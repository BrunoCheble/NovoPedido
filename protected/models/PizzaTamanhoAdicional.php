<?php

/**
 * This is the model class for table "pizza_tamanho_adicional".
 *
 * The followings are the available columns in table 'pizza_tamanho_adicional':
 * @property integer $id
 * @property integer $pizza_id
 * @property integer $tamanho_adicional_id
 *
 * The followings are the available model relations:
 * @property TamanhoAdicional $tamanhoAdicional
 * @property Pizza $pizza
 */
class PizzaTamanhoAdicional extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pizza_tamanho_adicional';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pizza_id, tamanho_adicional_id', 'required'),
			array('pizza_id, tamanho_adicional_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, pizza_id, tamanho_adicional_id', 'safe', 'on'=>'search'),
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
			'tamanhoAdicionais' => array(self::BELONGS_TO, 'TamanhoAdicional', 'tamanho_adicional_id'),
			'pizzas' => array(self::BELONGS_TO, 'Pizza', 'pizza_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'pizza_id' => 'Pizza',
			'tamanho_adicional_id' => 'Tamanho Adicional',
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
		$criteria->compare('pizza_id',$this->pizza_id);
		$criteria->compare('tamanho_adicional_id',$this->tamanho_adicional_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PizzaTamanhoAdicional the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
