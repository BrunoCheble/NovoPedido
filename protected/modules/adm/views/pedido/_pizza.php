<?php
$borda     = !empty($data->tamanho_borda_id) ? $data->tamanhoBordas->bordas->descricao : "Comum";
$tipoMassa = !empty($data->tamanho_tipo_massa_id) ? $data->tamanhoTipoMassas->tipoMassas->descricao : "Comum";
$promocao = $data->promocao ? '<div class="promocao"><i class="icon-flat-offer"></i></div>' : '';

?>
<div class="card-pedido-pizza">
     <?=$promocao;?>
    <div>
        <div><b>Tamanho:</b> <?= $data->tamanhos->descricao; ?></div>
        <div><b>Borda recheada:</b> <?= $borda; ?></div>
        <div><b>Tipo da massa:</b> <?= $tipoMassa; ?></div>
    </div>
    <div>
        <?php
            $pizzas = "";
            foreach ($data->pizzaTamanhoSabores as $key => $pizza) {

                if($key > 0)
                    $pizzas .= ', ';

                $pizzas .= $pizza->tamanhoSabores->sabores->descricao;
            }

            echo "<b>Sabores: </b>".$pizzas;
        ?>
    </div>
    <div>
        <?php
            if (!empty($data->pizzaTamanhoAdicionais))
            {
                $adicionais = "";
                
                foreach ($data->pizzaTamanhoAdicionais as $key => $adicional) {
                    if($key > 0)
                        $adicionais .= ', ';

                    $adicionais .= $adicional->tamanhoAdicionais->adicionais->descricao;
                }
                
                echo "<b>Adicionais: </b>".$adicionais;
                
            }
        ?>
    </div>
</div>
