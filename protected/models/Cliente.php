<?php

/**
 * This is the model class for table "cliente".
 *
 * The followings are the available columns in table 'cliente':
 * @property integer $id
 * @property string $nome
 * @property string $telefone
 * @property string $celular
 * @property string $endereco
 * @property integer $numero
 * @property string $complemento
 * @property string $cep
 * @property string $bairro
 * @property integer $excluido
 *
 * The followings are the available model relations:
 * @property Usuario[] $usuarios
 */ 
class Cliente extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cliente';
	}
        
        public $_endereco_id;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nome, telefone, endereco, numero, bairro', 'required'),
			array('numero, excluido, _endereco_id', 'numerical', 'integerOnly'=>true),
			array('nome', 'length', 'max'=>30),
			array('telefone, celular', 'length', 'max'=>10),
			array('endereco, complemento', 'length', 'max'=>100),
			array('cep', 'length', 'max'=>9),
			array('bairro', 'length', 'max'=>40),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nome, telefone, celular, endereco, numero, complemento, cep, bairro, excluido, _endereco_id', 'safe', 'on'=>'search'),
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
			'usuarios' => array(self::HAS_ONE, 'Usuario', 'cliente_id'),
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
			'celular' => 'Celular',
			'endereco' => 'Endereço',
			'numero' => 'Número',
			'complemento' => 'Complemento',
			'cep' => 'CEP',
			'bairro' => 'Bairro',
			'excluido' => 'Excluído',
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
		$criteria->compare('celular',$this->celular,true);
		$criteria->compare('endereco',$this->endereco,true);
		$criteria->compare('numero',$this->numero);
		$criteria->compare('complemento',$this->complemento,true);
		$criteria->compare('cep',$this->cep,true);
		$criteria->compare('bairro',$this->bairro,true);
		$criteria->compare('excluido',$this->excluido);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cliente the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getArrayParaPedido(){        
                return array(
                    'responsavel' => $this->nome,
                    'telefone' => $this->telefone,
                    'endereco' => $this->endereco,
                    'bairro' => $this->bairro,
                    'numero' => $this->numero,
                    'cep' => $this->cep,
                    'complemento' => $this->complemento,
                );
        }
        
        public function beforeValidate() {
            $retorno = parent::beforeValidate();
            
            if(!empty($this->_endereco_id))
            {  
                $modelEndereco  = EnderecoPermitido::model()->findByPk($this->_endereco_id);

                $this->endereco = $modelEndereco->local;
                $this->bairro   = $modelEndereco->bairro;
            }
            
            return $retorno;
        }
}
