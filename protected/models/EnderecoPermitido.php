<?php

/**
 * This is the model class for table "endereco_permitido".
 *
 * The followings are the available columns in table 'endereco_permitido':
 * @property integer $id
 * @property string $local
 * @property string $bairro
 * @property double $frete
 * @property integer $ativo
 */
class EnderecoPermitido extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'endereco_permitido';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('local, bairro', 'required'),
			array('ativo', 'numerical', 'integerOnly'=>true),
			array('frete', 'numerical'),
			array('local', 'length', 'max'=>100),
			array('bairro', 'length', 'max'=>50),
                        array('frete', 'default','value'=>0),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, local, bairro, frete, ativo', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function scopes() {
            $alias = $this->getTableAlias();
            return array(
                'ativos' => array(
                    'condition' => "{$alias}.ativo = 1",
                ),
            );
        }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'local' => 'Local',
			'bairro' => 'Bairro',
			'frete' => 'Frete',
			'ativo' => 'Ativo',
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
		$criteria->compare('local',$this->local,true);
		$criteria->compare('bairro',$this->bairro,true);
		$criteria->compare('frete',$this->frete);
		$criteria->compare('ativo',$this->ativo);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function beforeSearch() {
            $this->frete = str_replace(',', '.', $this->frete);
        }

        public function afterSearch() {
            $this->frete = str_replace('.', ',', $this->frete);
        }

        public function beforeValidate() {
            if (!empty($this->frete))
                $this->frete = str_replace(',', '.', $this->frete);

            return parent::beforeValidate();
        }
        
        public static function getArrayFormatadoByBairro($bairro) {
            $criteria = new CDbCriteria;
            $criteria->compare('bairro', $bairro,true);
            $criteria->order = 'local asc';
            
            $model = EnderecoPermitido::model()->ativos()->findAll($criteria);

            foreach ($model as $item) {
                $array[] = array(
                    'id'     => $item->id,
                    'local'  => $item->local,
                    'bairro' => $item->bairro,
                    'frete'  => $item->frete
                );
            }

            return $array;
        }
}
