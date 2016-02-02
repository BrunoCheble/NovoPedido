<?php

/**
 * This is the model class for table "item_combinado".
 *
 * The followings are the available columns in table 'item_combinado':
 * @property integer $id
 * @property integer $produto_id
 * @property integer $combinado_id
 * @property integer $ativo
 *
 * The followings are the available model relations:
 * @property Combinado $combinado
 * @property Produto $produto
 */
class ItemCombinado extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'item_combinado';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('produto_id, combinado_id', 'required'),
			array('produto_id, combinado_id, ativo, excluido', 'numerical', 'integerOnly'=>true),
			array('id, produto_id, combinado_id, ativo, excluido', 'safe', 'on'=>'search'),
		);
	}


	public function scopes() {
        $alias = $this->getTableAlias();
        return array(
            'naoExcluido' => array(
                'condition' => "$alias.excluido = 0",
            ),
            'ativos' => array(
                'condition' => "$alias.ativo = 1 AND {$alias}.excluido = 0",
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
			'combinados' => array(self::BELONGS_TO, 'Combinado', 'combinado_id'),
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
			'produto_id' => 'Produto',
			'combinado_id' => 'Combinado',
			'ativo' => 'Ativo',
			'excluido' => 'excluido',
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
		$criteria->compare('produto_id',$this->produto_id);
		$criteria->compare('combinado_id',$this->combinado_id);
		$criteria->compare('ativo',$this->ativo);
		$criteria->compare('excluido',$this->excluido);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ItemCombinado the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
