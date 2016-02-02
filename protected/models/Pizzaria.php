<?php

/**
 * This is the model class for table "pizzaria".
 *
 * The followings are the available columns in table 'pizzaria':
 * @property integer $id
 * @property string $nome
 * @property string $telefone1
 * @property double $pedido_min
 * @property string $ultimo_atualizacao
 * @property integer $adicional_pizza
 * @property integer $borda_pizza
 * @property integer $massa_pizza
 * @property integer $situacao
 * @property integer $pratos_lanches
 * @property string $endereco
 * @property string $tempo_espera
 * @property string $telefone2
 * @property string $bairro
 * @property string $logo
 */
class Pizzaria extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pizzaria';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, adicional_pizza, borda_pizza, massa_pizza, situacao, pratos_lanches, tipo_restaurante', 'numerical', 'integerOnly'=>true),
			array('pedido_min', 'numerical'),
			array('nome, tempo_espera, bairro, logo', 'length', 'max'=>50),
			array('telefone1, telefone2', 'length', 'max'=>10),
			array('endereco', 'length', 'max'=>100),
			array('ultimo_atualizacao', 'safe'),
            array('logo', 'file','types'=>'jpg, gif, png', 'allowEmpty'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nome, telefone1, pedido_min, ultimo_atualizacao, adicional_pizza, borda_pizza, massa_pizza, situacao, pratos_lanches, endereco, tempo_espera, telefone2, bairro, logo, tipo_restaurante', 'safe', 'on'=>'search'),
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
			'telefone1' => 'Telefone',
			'pedido_min' => 'Valor mínimo da entrega',
			'ultimo_atualizacao' => 'Ultima Atualização',
			'adicional_pizza' => 'Adicional de Pizza',
			'borda_pizza' => 'Borda de Pizza',
			'massa_pizza' => 'Massa de Pizza',
			'situacao' => 'Situacao',
			'pratos_lanches' => 'Pratos Lanches',
			'endereco' => 'Endereço',
			'tempo_espera' => 'Tempo de espera',
			'telefone2' => 'Celular',
			'bairro' => 'Bairro',
			'logo' => 'Logo',
			'tipo_restaurante' => 'Restaurante'
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
		$criteria->compare('telefone1',$this->telefone1,true);
		$criteria->compare('pedido_min',$this->pedido_min);
		$criteria->compare('ultimo_atualizacao',$this->ultimo_atualizacao,true);
		$criteria->compare('adicional_pizza',$this->adicional_pizza);
		$criteria->compare('borda_pizza',$this->borda_pizza);
		$criteria->compare('massa_pizza',$this->massa_pizza);
		$criteria->compare('tipo_restaurante',$this->tipo_restaurante);
		$criteria->compare('situacao',$this->situacao);
		$criteria->compare('pratos_lanches',$this->pratos_lanches);
		$criteria->compare('endereco',$this->endereco,true);
		$criteria->compare('tempo_espera',$this->tempo_espera,true);
		$criteria->compare('telefone2',$this->telefone2,true);
		$criteria->compare('bairro',$this->bairro,true);
		$criteria->compare('logo',$this->logo,true);

                $this->afterSearch();
		
                return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Pizzaria the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        public function beforeSave(){

            $retorno = parent::beforeSave();
            
            $uploadedFile=CUploadedFile::getInstance($this,'logo');
            
//            if(!$this->tipo_restaurante)
//            	$this->pratos_lanches = 1;

            if($uploadedFile != ''){
                
                $rnd = rand(0,9999);  // generate random number between 0-9999
                $fileName = "{$rnd}-{$uploadedFile}";  // random number + file name
                $this->logo = $fileName;

                if(!$uploadedFile->saveAs(Yii::app()->basePath.'/assets/images/clientes/'.$this->logo)){
                    $retorno = false;
                }
            }
            return $retorno;
        }

        public function beforeSearch(){
            $this->pedido_min = str_replace(',','.',$this->pedido_min);
        }

        public function afterSearch(){  
            $this->pedido_min = str_replace('.',',',$this->pedido_min);            
        }
        
        public function beforeValidate() {
            $retorno = parent::beforeValidate();
            
            if(!empty($this->pedido_min)){
                $this->pedido_min = str_replace(',','.',$this->pedido_min);
            }
            
            return $retorno;
        }
}
