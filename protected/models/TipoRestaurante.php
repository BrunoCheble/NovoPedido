<?php

class TipoRestaurante{
    const _TIPO_PIZZARIA_ = 1;
    const _TIPO_JAPONES_ = 2;
    
    public $tipoRestaurantes = array(
        self::_TIPO_PIZZARIA_ => 'Pizzaria',
        self::_TIPO_JAPONES_ => 'Japonês',
    );
    
    public static function getDescricao($status){
        $model = new TipoRestaurante;
        return $model->tipoRestaurantes[$status];
    }

    public static function getArray(){
        $model = new TipoRestaurante;
        return $model->tipoRestaurantes;
    }
}
?>