<?php

/**
 * This is the model class for table "tamanho".
 *
 * The followings are the available columns in table 'tamanho':
 * @property integer $id
 * @property string $descricao
 * @property string $tamanho
 * @property integer $max_qtd_sabor
 * @property integer $excluido
 *
 * The followings are the available model relations:
 * @property Pizza[] $pizzas
 * @property TamanhoAdicional[] $tamanhoAdicionals
 * @property TamanhoSabor[] $tamanhoSabors
 * @property TamanhoTipoMassa[] $tamanhoTipoMassas
 */
class Tamanho extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tamanho';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('descricao, tamanho', 'required'),
            array('max_qtd_sabor, excluido', 'numerical', 'integerOnly' => true),
            array('descricao', 'length', 'max' => 20),
            array('tamanho', 'length', 'max' => 10),
            array('descricao+excluido', 'application.extensions.uniqueMultiColumnValidator', 'caseSensitive' => true, 'message'=>'Este tamanho já foi cadastrado.'),
	
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, descricao, tamanho, max_qtd_sabor, excluido, ativo', 'safe', 'on' => 'search'),
        );
    }

    public function scopes() {
        $alias = $this->getTableAlias();
        return array(
            'naoExcluido' => array(
                'condition' => "{$alias}.excluido = 0",
            ),
            'ativos' => array(
                'condition' => "{$alias}.excluido = 0 AND {$alias}.ativo = 1",
            ),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'pizzas' => array(self::HAS_MANY, 'Pizza', 'tamanho_id'),
            'tamanhoAdicionais' => array(self::HAS_MANY, 'TamanhoAdicional', 'tamanho_id'),
            'tamanhoSabores' => array(self::HAS_MANY, 'TamanhoSabor', 'tamanho_id'),
            'tamanhoTipoMassas' => array(self::HAS_MANY, 'TamanhoTipoMassa', 'tamanho_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'descricao' => 'Descricao',
            'tamanho' => 'Tamanho',
            'max_qtd_sabor' => 'Max Qtd Sabor',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('descricao', $this->descricao, true);
        $criteria->compare('tamanho', $this->tamanho, true);
        $criteria->compare('max_qtd_sabor', $this->max_qtd_sabor);
        $criteria->compare('ativo', $this->ativo);
        $criteria->compare('excluido', $this->excluido);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Tamanho the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function updateStatusAllDependentes() {
        $conditions = 'tamanho_id = ' . $this->id;
        TamanhoSabor::model()->updateAll(array('ativa' => $this->ativo), $conditions);
        TamanhoBorda::model()->updateAll(array('ativa' => $this->ativo), $conditions);
        TamanhoTipoMassa::model()->updateAll(array('ativa' => $this->ativo), $conditions);
        TamanhoAdicional::model()->updateAll(array('ativa' => $this->ativo), $conditions);
    }

    public function deleteAllDependentes() {
        $conditions = 'tamanho_id = ' . $this->id;
        $modelPendentes = "";

        $tamanhoSabor = TamanhoSabor::model()->find($conditions);
        $tamanhoBorda = TamanhoBorda::model()->find($conditions);
        $tamanhoTipoM = TamanhoTipoMassa::model()->find($conditions);
        $tamanhoAdici = TamanhoAdicional::model()->find($conditions);
        
        if (!empty($tamanhoSabor))
            $modelPendentes = TamanhoSabor::model()->updateAll(array('excluida' => 1), $conditions);

        if (!empty($tamanhoBorda))
            $modelPendentes = TamanhoBorda::model()->updateAll(array('excluida' => 1), $conditions);

        if (!empty($tamanhoTipoM))
            $modelPendentes = TamanhoTipoMassa::model()->updateAll(array('excluida' => 1), $conditions);

        if (!empty($tamanhoAdici))
            $modelPendentes = TamanhoAdicional::model()->updateAll(array('excluida' => 1), $conditions);

        return $modelPendentes;
    }

    public static function getArrayTamanho(){
        $model = Tamanho::model()->ativos()->findAll();
        $tamanhos = array();
        
        foreach($model as $item)
        {
            $tamanhos[$item->id] = $item->descricao." (".$item->tamanho.")";
        }
        
        return $tamanhos;
    }
}
