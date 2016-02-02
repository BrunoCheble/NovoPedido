<?php

/**
 * This is the model class for table "adicional".
 *
 * The followings are the available columns in table 'adicional':
 * @property integer $id
 * @property string $descricao
 * @property integer $excluido
 * @property string $foto
 *
 * The followings are the available model relations:
 * @property TamanhoAdicional[] $tamanhoAdicionals
 */
class Adicional extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'adicional';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('descricao', 'required'),
			array('excluido, ativa', 'numerical', 'integerOnly'=>true),
			array('descricao', 'length', 'max'=>50),
			array('foto', 'length', 'max'=>100),
                        array('foto', 'file','types'=>'jpg, gif, png', 'allowEmpty'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, descricao, excluido, foto, ativa', 'safe', 'on'=>'search'),
		);
	}

	public function scopes() {
            $alias = $this->getTableAlias();
                return array(
                'naoExcluido' => array(
                    'condition' => "{$alias}.excluido = 0",
                ),
                'ativos' => array(
                    'condition' => "{$alias}.excluido = 0 AND {$alias}.ativa = 1",
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
			'tamanhoAdicionais' => array(self::HAS_MANY, 'TamanhoAdicional', 'adicional_id'),              
			'qtdTamanhoAdicionais' =>  array(self::STAT, 'TamanhoAdicional','adicional_id'),
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
			'excluido' => 'Excluido',
			'foto' => 'Foto',
			'ativa' => 'Status',
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
		$criteria->compare('foto',$this->foto,true);
		$criteria->compare('excluido',$this->excluido);
		$criteria->compare('ativa',$this->ativa);

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

                    if(!$uploadedFile->saveAs(Yii::app()->basePath.'/assets/images/adicionais/'.$this->foto))
                        $return = false;
                }

                return $return;
        }
        
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Adicional the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
