<?php

    $isAtendimento = Yii::app()->user->isAtendimento();
    $isCozinha = Yii::app()->user->isCozinha();
?>
<div class="card-item">
    <div class="card-pedido">
        <div>
            <div><b>Código:</b> <?= $data->codigo; ?></div>
            <div><b>Responsável:</b> <?= $data->responsavel; ?></div>
            <div><b>Telefone:</b> <?= $data->telefone; ?></div>
            
            <div><b>Endereço:</b> <?= $data->endereco.','.$data->numero.' '.$data->complemento.' - '.$data->bairro; ?></div>
            <div><b>Tempo de espera:</b> <?= $data->tempo_aguardando." atrás"; ?></div>
            
            <?php
                if($isAtendimento) {
                    echo '<div><b>Valor total:</b> R$ '.number_format($data->preco_total,2,",",".").'</div>';

                    if($data->forma_pagamento_id == 1)
                        echo "<div><b>Troco:</b> R$ ".number_format($data->troco,2,",",".")."</div>";
                    else
                        echo "<div><b>Forma de pagamento:</b> ".$data->formaPagamentos->nome."</div>";

                    if($data->entregas != null)
                        echo "<div><b>Entregador:</b> ".$data->entregas->entregadores->nome."</div>";
                }
            ?>
                        
        </div>
    </div>
    <nav class="links clearfix">
        <?php
        

        $links[1] = array(
            'Excluir' => CHtml::link('<i class="icon-remove"></i>','',array('class'=>'excluir-pedido','data-id'=>$data->id))
        );
        
        
        $links[2] = array();
        
        $links[3] = array(
            'Concluido' => CHtml::link('<i class="icon-ok"></i>','',array('class'=>'confirmar-entrega','data-id'=>$data->id)),
            'Cancelar' => CHtml::link('<i class="icon-remove"></i>','',array('class'=>'cancelar-entrega','data-id'=>$data->id))
        );

        if($isAtendimento) {
            echo CHtml::link('<i class="icon-shopping-cart"></i> ',array('itensPedido',"id"=>$data->id),array('title'=>'Visualizar itens'));
            echo CHtml::link('<i class="icon-pencil"></i> ',array('update',"id"=>$data->id),array('title'=>'Editar pedido'));
        }
        else{
            $links[2] = array(
                'Entregar' => CHtml::link('<i class="icon-ok"></i>','',array('class'=>'confirmar-preparando','data-id'=>$data->id)),
                'Cancelar' => CHtml::link('<i class="icon-remove"></i>','',array('class'=>'cancelar-preparando','data-id'=>$data->id))
            );
            echo CHtml::link('<i class="icon-shopping-cart"></i> ',array('cozinha',"id"=>$data->id),array('title'=>'Visualizar itens'));
        }

        $links[7] = array(
            'Concluido' => CHtml::link('<i class="icon-ok"></i>','',array('class'=>'confirmar-entrega','data-id'=>$data->id)),
            'Cancelar' => CHtml::link('<i class="icon-remove"></i>','',array('class'=>'cancelar-entrega','data-id'=>$data->id))
        );


        foreach($links[$data->status] as $link){
            echo $link;
        }
        
        ?>
    </nav>
</div>