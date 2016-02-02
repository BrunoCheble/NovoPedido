<?php

/**
 * This is the model class for table "usuario".
 *
 * The followings are the available columns in table 'usuario':
 * @property integer $id
 * @property string $email
 * @property string $senha
 * @property string $sal
 * @property string $ultimo_acesso
 * @property integer $cliente_id
 * @property integer $excluido
 *
 * The followings are the available model relations:
 * @property Cliente $cliente
 */
class Usuario extends CActiveRecord
{
        public $senha2;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usuario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cliente_id, tipo_usuario, excluido', 'numerical', 'integerOnly'=>true),
			array('email', 'required'),
                    
                        array('senha, senha2', 'required', 'on' => 'insert, updatePassword'),
                        array('senha', 'required', 'on' => 'recoverPassword'),
			array('senha2', 'compare', 'compareAttribute'=>'senha', 'on' => 'insert, updatePassword'),

                        array('email', 'unique'),
			
                        array('email', 'length', 'max'=>50),
			array('senha, sal', 'length', 'max'=>100),
			array('ultimo_acesso', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, email, tipo_usuario, senha, senha2, sal, ultimo_acesso, cliente_id, excluido, database', 'safe', 'on'=>'search'),
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
			'clientes' => array(self::BELONGS_TO, 'Cliente', 'cliente_id'),
			'pedidos' => array(self::HAS_MANY, 'Pedido', 'pedido_id'),                 
			'qtdPedidos' =>  array(self::STAT, 'Pedido','usuario_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'email' => 'Email',
			'senha' => 'Senha',
			'sal' => 'Sal',
            'senha2'=> 'Confirmação da senha',
			'ultimo_acesso' => 'Ultimo Acesso',
			'cliente_id' => 'Cliente',
			'tipo_usuario' => 'tipo_usuario',
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
		$criteria->compare('email',$this->email,true);
		$criteria->compare('senha',$this->senha,true);
		$criteria->compare('sal',$this->sal,true);
		$criteria->compare('ultimo_acesso',$this->ultimo_acesso,true);
		$criteria->compare('cliente_id',$this->cliente_id);
		$criteria->compare('database',$this->database);
		$criteria->compare('excluido',$this->excluido);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
       

    public function beforeValidate() {

        if($this->getScenario() == 'insert') {
            $this->sal = uniqid();
        }
        
        return parent::beforeValidate();
    }
    
    public function beforeSave() {

        $return = parent::beforeSave();

        switch ($this->getScenario()) {

            case 'insert' :
                    $this->senha = $this->senha ? $this->getPassword() : null;
                    break;
            case 'updatePassword' : 
                    $this->senha = $this->getPassword();
                    break;
        }

        return $return;
    }
        
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Usuario the static model class
	 */
	public static function model($className=__CLASS__) {
		
		return parent::model($className);
	}
        
    public function getPassword($senha = null) {

        $senha = $senha ? $senha : $this->senha;

        return sha1($senha . $this->sal);
    }

    public function validatePassword($senha) {

        $senhaCriptografada = $this->getPassword($senha);

        if ($senhaCriptografada !== $this->senha) {
            return false;
        }

        return true;
    }
}
