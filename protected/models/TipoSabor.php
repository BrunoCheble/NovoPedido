<?php

class TipoSabor{
    const _TIPO_DOCE_ = 0;
    const _TIPO_SALGADA_ = 1;
    
    public $tipoSabor = array(
        self::_TIPO_DOCE_ => 'Doce',
        self::_TIPO_SALGADA_ => 'Salgada',
    );
    
    public static function getDescricaoTipoSabor($tipo_sabor){
        $model = new TipoSabor;
        return $model->tipoSabor[$tipo_sabor];
    }

    public static function getArrayTipoSabor(){
        $model = new TipoSabor;
        return $model->tipoSabor;
    }
}
?>
