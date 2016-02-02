<?php

/**
 * This is the model class for table "produto".
 *
 * The followings are the available columns in table 'produto':
 * @property integer $id
 * @property string $nome
 * @property double $preco
 * @property integer $preco_embalagem
 * @property string $descricao
 * @property integer $sub_categoria_id
 * @property integer $ativa
 * @property integer $excluido
 * @property string $foto
 *
 * The followings are the available model relations:
 * @property SubCategoria $subCategoria
 * @property ProdutoPedido[] $produtoPedidos
 */
class Produto extends CActiveRecord {

    public $categoria;
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'produto';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nome, preco, descricao', 'required'),
            array('preco_embalagem, sub_categoria_id, ativa, excluido', 'numerical', 'integerOnly' => true),
            array('preco', 'numerical'),
            array('foto', 'file','types'=>'jpg, gif, png', 'allowEmpty'=>true),
            array('nome, foto', 'length', 'max' => 50),
            array('descricao', 'length', 'max' => 255),
            array('nome+sub_categoria_id+descricao+excluido', 'application.extensions.uniqueMultiColumnValidator', 'caseSensitive' => true, 'message'=>'Este produto já foi cadastrado nesta sub-categoria'),
			
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, nome, preco, preco_embalagem, descricao, sub_categoria_id, ativa, excluido, foto', 'safe', 'on' => 'search'),
        );
    }

    public function scopes() {
        $alias = $this->getTableAlias();
        return array(
            'naoExcluido' => array(
                'with' => 'subCategorias',
                'condition' => "$alias.excluido = 0",
            ),
            'ativos' => array(
                'condition' => "$alias.ativa = 1 AND {$alias}.excluido = 0",
            ),
            'bebidas' => array(
                'with' => 'subCategorias',
                'condition' => 'subCategorias.categoria = ' . SubCategoria::TIPO_BEBIDA,
                'order' => 'sub_categoria_id asc'
            ),
            'lanches' => array(
                'with' => 'subCategorias',
                'condition' => 'subCategorias.categoria = ' . SubCategoria::TIPO_LANCHE,
                'order' => 'sub_categoria_id asc'
            ),
            'pratoLanche' => array(
                'with' => 'subCategorias',
                'condition' => 'subCategorias.categoria != ' . SubCategoria::TIPO_BEBIDA,
                'order' => 'sub_categoria_id asc'
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
            'subCategorias' => array(self::BELONGS_TO, 'SubCategoria', 'sub_categoria_id'),
            'produtoPedidos' => array(self::HAS_MANY, 'ProdutoPedido', 'produto_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'nome' => 'Nome',
            'preco' => 'Preço',
            'preco_embalagem' => 'Preço da embalagem',
            'descricao' => 'Descrição',
            'sub_categoria_id' => 'Categoria',
            'ativa' => 'Ativa?',
            'excluido' => 'Excluído',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $this->beforeSearch();
        
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('nome', $this->nome, true);
        $criteria->compare('preco', $this->preco);
        $criteria->compare('preco_embalagem', $this->preco_embalagem);
        $criteria->compare('descricao', $this->descricao, true);
        $criteria->compare('sub_categoria_id', $this->sub_categoria_id);
        $criteria->compare('ativa', $this->ativa);
        $criteria->compare('excluido', $this->excluido);
        $criteria->compare('foto', $this->foto, true);

        $this->afterSearch();
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Produto the static model class
     */
    public static function model($className = __CLASS__) {
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
    
    public function afterFind() {
        $this->categoria = $this->subCategorias->categoria;
        
        parent::afterFind();
    }
    
    public static function getArrayTipoQuantidade() {
        return array(
            1 => 'ml',
            2 => 'litros',
            3 => 'mg',
            4 => 'kg'
        );
    }

    public static function getArrayListBebidasCardapio() {
        $arrayBebidas = array();
        $bebidas = Produto::model()->bebidas()->naoExcluido()->findAll();

        foreach ($bebidas as $item) {
            if ($item->sub_categoria_id != 1) {
                $arrayBebidas[$item->sub_categoria_id]['descricao'] = $item->subCategorias->descricao;
                $arrayBebidas[$item->sub_categoria_id]['quantidade'][$item->descricao] = $item->descricao;
            } else {
                $arrayBebidas[$item->nome]['descricao'] = $item->nome;
                $arrayBebidas[$item->nome]['quantidade'][$item->descricao] = $item->descricao;
            }
        }

        return $arrayBebidas;
    }

    public static function getArrayListMassaCardapio() {
        $arrayMassa = array();
        $massa = Produto::model()->massas()->naoExcluido()->findAll();

        foreach ($massa as $item) {
            if ($item->sub_categoria_id != 2) {
                $arrayMassa[$item->sub_categoria_id]['nome'] = $item->subCategorias->nome;
                $arrayMassa[$item->sub_categoria_id]['sabor'][] = $item->nome;
            } else {
                $arrayMassa[$item->nome]['nome'] = $item->nome;
            }
        }

        return $arrayMassa;
    }
    
    public static function getArraySimplesFormatado() {

        $model = Produto::model()->ativos()->findAll();

        foreach ($model as $item) {
            $array[$item->id] = $item->nome . " (" . $item->descricao . ")";
        }

        return $array;
    }

}
