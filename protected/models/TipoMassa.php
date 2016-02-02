<?php

/**
 * This is the model class for table "tipo_massa".
 *
 * The followings are the available columns in table 'tipo_massa':
 * @property integer $id
 * @property string $descricao
 * @property integer $ativa
 * @property integer $excluida
 *
 * The followings are the available model relations:
 * @property Pizza[] $pizzas
 * @property TamanhoTipoMassa[] $tamanhoTipoMassas
 */
class TipoMassa extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tipo_massa';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('descricao','required'),
			array('ativa, excluida', 'numerical', 'integerOnly'=>true),
			array('descricao', 'length', 'max'=>50),
                        array('descricao+excluida', 'application.extensions.uniqueMultiColumnValidator', 'caseSensitive' => true, 'message'=>'Este tipo de massa já foi cadastrado.'),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, descricao, ativa, excluida', 'safe', 'on'=>'search'),
		);
	}
        
        public function scopes() {
            $alias = $this->getTableAlias();
            return array(
                'naoExcluido' => array(
                    'condition' => "{$alias}.excluida = 0",
                ),
                'ativos' => array(
                    'condition' => "{$alias}.excluida = 0 AND {$alias}.ativa = 1",
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
			'pizzas' => array(self::HAS_MANY, 'Pizza', 'tipo_massa_id'),
			'tamanhoTipoMassas' => array(self::HAS_MANY, 'TamanhoTipoMassa', 'tipo_massa_id'),               
			'qtdTamanhoTipoMassa' =>  array(self::STAT, 'TamanhoTipoMassa','tipo_massa_id'),
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
			'ativa' => 'Ativo',
			'excluida' => 'Excluido',
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
		$criteria->compare('ativa',$this->ativa);
		$criteria->compare('excluida',$this->excluida);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TipoMassa the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
