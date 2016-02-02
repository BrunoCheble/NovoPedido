<?php

/**
 * This is the model class for table "sabor".
 *
 * The followings are the available columns in table 'sabor':
 * @property integer $id
 * @property string $descricao
 * @property integer $tipo_sabor
 * @property integer $ativa
 * @property integer $excluido
 * @property string $ingredientes
 * @property string $foto
 *
 * The followings are the available model relations:
 * @property TamanhoSabor[] $tamanhoSabors
 */
class Sabor extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sabor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('descricao, ingredientes', 'required'),
			array('tipo_sabor, ativa, excluido', 'numerical', 'integerOnly'=>true),
			array('descricao', 'length', 'max'=>40),
			array('foto', 'length', 'max'=>100),
                        array('foto', 'file','types'=>'jpg, gif, png', 'allowEmpty'=>true),
                        array('descricao+excluido', 'application.extensions.uniqueMultiColumnValidator', 'caseSensitive' => true, 'message'=>'Este sabor já foi cadastrado.'),
                    
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, descricao, tipo_sabor, ativa, excluido, ingredientes, foto', 'safe', 'on'=>'search'),
		);
	}

        public function scopes()
        {
            $alias = $this->getTableAlias();
            return array(
                'naoExcluido' => array(
                    'condition' => "{$alias}.excluido = 0",
                ),
                'ativos' => array(
                    'condition' => "{$alias}.excluido = 0 AND {$alias}.ativa = 1",
                ),
                'ordenarPorSalgada' => array(
                    'order' => "{$alias}.tipo_sabor asc",
                ),
                'ordenarPorDoce' => array(
                    'order' => "{$alias}.tipo_sabor desc",
                ),
                'ordenarPorDescricao' => array(
                    'order' => "{$alias}.descricao asc",
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
			'tamanhoSabores' => array(self::HAS_MANY, 'TamanhoSabor', 'sabor_id'),                    
			'qtdTamanhoSabor' =>  array(self::STAT, 'TamanhoSabor','sabor_id'),
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
			'tipo_sabor' => 'Tipo de sabor',
			'ativa' => 'Status',
			'excluido' => 'Excluído',
			'ingredientes' => 'Ingredientes',
			'foto' => 'Foto',
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
		$criteria->compare('tipo_sabor',$this->tipo_sabor);
		$criteria->compare('ativa',$this->ativa);
		$criteria->compare('excluido',$this->excluido);
		$criteria->compare('ingredientes',$this->ingredientes,true);
		$criteria->compare('foto',$this->foto,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

        public function beforeSave() {
                $return = parent::beforeSave();

                $uploadedFile=CUploadedFile::getInstance($this,'foto');

                if($uploadedFile != ''){
                    $rnd = rand(0,9999);  // generate random number between 0-9999
                    $fileName = "{$rnd}-{$uploadedFile}";  // random number + file name
                    $this->foto = $fileName;

                    if(!$uploadedFile->saveAs(Yii::app()->basePath.'/assets/images/sabores/'.$this->foto))
                        $return = false;
                }

                return $return;
        }
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Sabor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
