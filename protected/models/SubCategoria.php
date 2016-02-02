<?php

/**
 * This is the model class for table "sub_categoria".
 *
 * The followings are the available columns in table 'sub_categoria':
 * @property integer $id
 * @property string $descricao
 * @property integer $categoria
 *
 * The followings are the available model relations:
 * @property Produto[] $produtos
 */
class SubCategoria extends CActiveRecord
{
    
        const TIPO_BEBIDA = 1;
        const TIPO_LANCHE = 2;
        const TIPO_SOBREMESA = 3;
        const TIPO_PRATO = 4;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sub_categoria';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
                        array('descricao, categoria','required'),
			array('categoria', 'numerical', 'integerOnly'=>true),
			array('descricao', 'length', 'max'=>30),
                        
                        array('descricao', 'unique'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, descricao, categoria', 'safe', 'on'=>'search'),
		);
	}

        public function scopes() {
            return array(
                'validos' => array(
                    'condition' => 'descricao <> "Sem sub-categoria"',
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
			'produtos' => array(self::HAS_MANY, 'Produto', 'sub_categoria_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'descricao' => 'Descricao',
			'categoria' => 'Categoria',
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
		$criteria->compare('categoria',$this->categoria);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SubCategoria the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public static function getArrayCategoria(){
            return array(
                self::TIPO_BEBIDA => 'Bebida',
                self::TIPO_LANCHE => 'Lanche',
                self::TIPO_SOBREMESA => 'Sobremesa',
                self::TIPO_PRATO => 'Prato',
            );
        }
        
        public static function getDescricaoCategoria($categoria){
            $categorias = array(
                self::TIPO_BEBIDA => 'Bebida',
                self::TIPO_LANCHE => 'Lanche',
                self::TIPO_SOBREMESA => 'Sobremesa',
                self::TIPO_PRATO => 'Prato',
            );
            
            return $categorias[$categoria];
        }
}
