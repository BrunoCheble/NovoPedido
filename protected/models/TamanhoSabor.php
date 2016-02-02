<?php

/**
 * This is the model class for table "tamanho_sabor".
 *
 * The followings are the available columns in table 'tamanho_sabor':
 * @property integer $id
 * @property integer $sabor_id
 * @property integer $tamanho_id
 * @property double $preco
 * @property integer $promocao
 *
 * The followings are the available model relations:
 * @property PizzaTamanhoSabor[] $pizzaTamanhoSabors
 * @property Sabor $sabor
 * @property Tamanho $tamanho
 */
class TamanhoSabor extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tamanho_sabor';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('sabor_id, tamanho_id, preco', 'required'),
            array('sabor_id, tamanho_id, promocao, ativa, excluida', 'numerical', 'integerOnly' => true),
            array('tamanho_id+sabor_id+excluida', 'application.extensions.uniqueMultiColumnValidator', 'caseSensitive' => true, 'message' => 'Este sabor já foi cadastrado neste tamanho'),
            array('preco', 'numerical'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, sabor_id, tamanho_id, preco, promocao, ativa, excluida', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'pizzaTamanhoSabores' => array(self::HAS_MANY, 'PizzaTamanhoSabor', 'tamanho_sabor_id'),
            'sabores' => array(self::BELONGS_TO, 'Sabor', 'sabor_id'),
            'tamanhos' => array(self::BELONGS_TO, 'Tamanho', 'tamanho_id'),
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
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'sabor_id' => 'Sabor',
            'tamanho_id' => 'Tamanho',
            'preco' => 'Preço',
            'promocao' => 'Promoção',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $this->beforeSearch();

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('sabor_id', $this->sabor_id);
        $criteria->compare('tamanho_id', $this->tamanho_id);
        $criteria->compare('preco', $this->preco);
        $criteria->compare('promocao', $this->promocao);
        $criteria->compare('ativa', $this->ativa);
        $criteria->compare('excluida', $this->excluida);

        $this->afterSearch();

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TamanhoSabor the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
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

    public static function getArraySimplesFormatado() {

        $model = TamanhoSabor::model()->ativos()->findAll(array('order' => 'sabor_id, tamanho_id asc'));
        $array = array();
        foreach ($model as $item) {
            $array[$item->id] = $item->sabores->descricao . " (" . $item->tamanhos->descricao . ")";
        }

        return $array;
    }

    public static function getArrayFormatadoPorTamanho($tamanho_id, $tipo_pizza) {
        $array = array();

        $criteria = new CDbCriteria;

        $criteria->with = 'sabores';

        $criteria->addCondition("tamanho_id = " . $tamanho_id);
        $criteria->addCondition("tipo_sabor = " . intval($tipo_pizza));
        $criteria->order = 'sabores.descricao asc';
        
        $model = TamanhoSabor::model()->ativos()->findAll($criteria);
        foreach ($model as $item) {
            $array[] = array(
                'sabor_id'     => $item->sabor_id,
                'descricao'    => $item->sabores->descricao,
                'ingredientes' => $item->sabores->ingredientes,
                'preco'        => $item->preco,
                'foto'         => $item->sabores->foto,
            );
        }
        return $array;
    }

}
