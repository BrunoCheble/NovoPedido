<?php

/**
 * This is the model class for table "entregador".
 *
 * The followings are the available columns in table 'entregador':
 * @property integer $id
 * @property string $nome
 * @property string $telefone
 * @property integer $excluido
 */ 
class Entregador extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'entregador';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, excluido', 'numerical', 'integerOnly'=>true),
			array('nome, telefone', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nome, telefone, excluido', 'safe', 'on'=>'search'),
		);
	}

	public function scopes()
    {
        $alias = $this->getTableAlias();
        return array(
            'naoExcluido' => array(
                'condition' => "{$alias}.excluido = 0",
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
			'entregas' 	 => array(self::HAS_MANY, 'Entrega', 'entregador_id'),            
			'qtdEntregas' => array(self::STAT, 'Entrega','entregador_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nome' => 'Nome',
			'telefone' => 'Telefone',
			'excluido' => 'Excluido',
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
		$criteria->compare('nome',$this->nome,true);
		$criteria->compare('telefone',$this->telefone,true);
		$criteria->compare('excluido',$this->excluido);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Entregador the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
