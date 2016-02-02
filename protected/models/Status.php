<?php

class Status{
    const _TIPO_AGUARDANDO_    = 1;
    const _TIPO_PREPARANDO_    = 2;
    const _TIPO_ENTREGANDO_    = 3;
    const _TIPO_CONCLUIDO_     = 4;
    const _TIPO_DEVOLVIDO_     = 5;
    const _TIPO_CANCELADO_     = 6;
    const _TIPO_FILA_ENTREGA_  = 7;
    
    public $tipoStatus = array(
        self::_TIPO_AGUARDANDO_ => 'Aguardando',
        self::_TIPO_PREPARANDO_ => 'Preparando',
        
        self::_TIPO_ENTREGANDO_ => 'Entregando',
        self::_TIPO_CONCLUIDO_ => 'Concluído',
        
        self::_TIPO_DEVOLVIDO_ => 'Devolvido',
        self::_TIPO_CANCELADO_ => 'Cancelado',

        self::_TIPO_FILA_ENTREGA_ => 'Fila de entrega',
    );
    
    public static function getPercentual($status){
        $percent[1] = 25;
        $percent[2] = 50;
        $percent[3] = 90;
        $percent[4] = 100;
        $percent[5] = 0;
        $percent[6] = 0;
        
        return $percent[$status];
    }


    public static function getDescricao($status){
        $model = new Status;
        return $model->tipoStatus[$status];
    }

    public static function getArray(){
        $model = new Status;
        return $model->tipoStatus;
    }
}
?>
