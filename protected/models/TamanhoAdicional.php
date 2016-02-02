<?php

/**
 * This is the model class for table "tamanho_adicional".
 *
 * The followings are the available columns in table 'tamanho_adicional':
 * @property integer $id
 * @property integer $tamanho_id
 * @property integer $adicional_id
 * @property double $preco
 *
 * The followings are the available model relations:
 * @property PizzaTamanhoSaborTamanhoAdicional[] $pizzaTamanhoSaborTamanhoAdicionals
 * @property Adicional $adicional
 * @property Tamanho $tamanho
 */
class TamanhoAdicional extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tamanho_adicional';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tamanho_id, adicional_id, preco', 'required'),
			array('tamanho_id, adicional_id, ativa, excluida', 'numerical', 'integerOnly'=>true),
                        array('tamanho_id+adicional_id+excluida', 'application.extensions.uniqueMultiColumnValidator', 'caseSensitive' => true, 'message'=>'Este adicional já foi cadastrado neste tamanho'),                    
			array('preco', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, tamanho_id, adicional_id, preco, ativa, excluida', 'safe', 'on'=>'search'),
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
			'adicionais'             => array(self::BELONGS_TO, 'Adicional', 'adicional_id'),
			'tamanhos'               => array(self::BELONGS_TO, 'Tamanho', 'tamanho_id'),
                        'pizzaTamanhoAdicionais' => array(self::HAS_MANY, 'PizzaTamanhoAdicional', 'tamanho_adicional_id'),
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
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tamanho_id' => 'Tamanho',
			'adicional_id' => 'Adicional',
			'preco' => 'Preço',
                        'ativa' => 'Status',
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
                
                $this->beforeSearch();

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('tamanho_id',$this->tamanho_id);
		$criteria->compare('adicional_id',$this->adicional_id);
		$criteria->compare('preco',$this->preco);
		$criteria->compare('ativa',$this->ativa);
		$criteria->compare('excluida',$this->excluida);
                
                $this->afterSearch();

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TamanhoAdicional the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function beforeSearch(){
            $this->preco = str_replace(',','.',$this->preco);
        }

        public function afterSearch(){
            $this->preco = str_replace('.',',',$this->preco);            
        }
        
        public function beforeValidate() {
            if(!empty($this->preco))
                $this->preco = str_replace(',','.',$this->preco);

            return parent::beforeValidate();
        }
        
        public static function getArrayDescricaoFormatadaByTamanho($id){
            $array = array();
            
            $criteria = new CDbCriteria;
            $criteria->addCondition("excluida = 0");
            $criteria->addCondition("ativa = 1");
            $criteria->addCondition("tamanho_id = ".$id);
            
            $model = TamanhoAdicional::model()->findAll($criteria);
            
            foreach($model as $item){
                $array[$item->adicional_id] = array(
                    'descricao' => $item->adicionais->descricao,
                    'foto' => $item->adicionais->foto,
                    'preco' => $item->preco,
                );
            }
            return $array;
        }

}
