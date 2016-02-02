<?php
$promocao  = !empty($data->combinado_id) ? '<div class="promocao"><i class="icon-flat-offer"></i></div>' : '';

?>
<div class="card-pedido-pizza">
    <?=$promocao;?>
    <h5><?= !empty($data->combinado_id) ? $data->combinados->nome : 'Combinado personalizado';?></h5>

    <ul>
        <?php
            foreach ($data->itemCombinadoPedidos as $item) {
                echo '<li><b>'.$item->quantidade.'</b> '.$item->produtos->nome.'<p><small>'.$item->produtos->descricao.'</small></p></li>';
            }
        ?>
    </ul>

</div>
