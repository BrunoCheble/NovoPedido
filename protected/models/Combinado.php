<?php

/**
 * This is the model class for table "combinado".
 *
 * The followings are the available columns in table 'combinado':
 * @property integer $id
 * @property string $nome
 * @property string $descricao
 * @property double $preco
 * @property string $foto
 * @property integer $ativo
 * @property integer $excluido
 *
 * The followings are the available model relations:
 * @property CombinadoPedido[] $combinadoPedidos
 * @property ItemCombinadoPedido[] $itemCombinadoPedidos
 */
class Combinado extends CActiveRecord
{
    public $_produtoCombinado = array();

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'combinado';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nome, preco', 'required'),
			array('ativo, excluido', 'numerical', 'integerOnly'=>true),
			array('preco', 'numerical'),
            array('foto', 'file','types'=>'jpg, gif, png', 'allowEmpty'=>true),
			array('nome, foto', 'length', 'max'=>45),
			array('descricao', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nome, descricao, preco, foto, ativo, excluido', 'safe', 'on'=>'search'),
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
			'combinadoPedidos' => array(self::HAS_MANY, 'CombinadoPedido', 'combinado_id'),
			'itemCombinados' => array(self::HAS_MANY, 'ItemCombinado', 'combinado_id'),
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
			'descricao' => 'Descrição',
			'preco' => 'Preço',
			'foto' => 'Foto',
			'ativo' => 'Ativo',
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

        $this->beforeSearch();

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('nome',$this->nome,true);
		$criteria->compare('descricao',$this->descricao,true);
		$criteria->compare('preco',$this->preco);
		$criteria->compare('foto',$this->foto,true);
		$criteria->compare('ativo',$this->ativo);
		$criteria->compare('excluido',$this->excluido);

        $this->afterSearch();

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function beforeSearch() {
        $this->preco = str_replace(',', '.', $this->preco);
    }

    public function afterSearch() {
        $this->preco = str_replace('.', ',', $this->preco);
    }

    public function beforeValidate() {
        if (!empty($this->preco))
            $this->preco = str_replace(',', '.', $this->preco);

        return parent::beforeValidate();
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Combinado the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function beforeSave() {
        $return = parent::beforeSave();
        
        $uploadedFile=CUploadedFile::getInstance($this,'foto');

        if($uploadedFile != ''){
            $rnd = rand(0,9999);  // generate random number between 0-9999
            $fileName = "{$rnd}-{$uploadedFile}";  // random number + file name
            $this->foto = $fileName;
            
            if(!$uploadedFile->saveAs(Yii::app()->basePath.'/assets/images/produtos/'.$this->foto))
                $return = false;
        }
        
        return $return;
    }

    public function afterSave() {
        $return = parent::afterSave();
        
        // Atualizar
        ItemCombinado::model()->updateAll(array('ativo'=>0), 'combinado_id = ' . $this->id);

        foreach($this->_produtoCombinado as $item)
        {    
            $criteria = new CDbCriteria;
            $criteria->compare('produto_id', $item);
            $criteria->addCondition('combinado_id = '.$this->id);

            $modelItemPromocao = ItemCombinado::model()->find($criteria);
            
            if(empty($modelItemPromocao)) {
                $modelItemPromocao = new ItemCombinado;
                $modelItemPromocao->produto_id = $item;
                $modelItemPromocao->combinado_id = $this->id;
            }
            
            $modelItemPromocao->ativo = 1;
            $modelItemPromocao->save();
        }
        
        return $return;
    }

    public function afterFind() {
        $return = parent::afterFind();
        
        foreach($this->itemCombinados as $value)
        {
            if($value->ativo == 0)
                continue;
            
            $this->_produtoCombinado[] = $value->produto_id;            
        }
        

        return $return;
    }
        
}
