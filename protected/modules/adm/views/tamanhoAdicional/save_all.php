<?php
/** @var BootActiveForm $form */
Yii::app()->clientScript->registerPackage('jquery-maskmoney');
?>

<script>
    $(document).ready(function() {
        $("[name='TamanhoAdicional[preco][]']").maskMoney({decimal: ",", thousands: "."});
        
        $('#check_all').click(function(){
            $('[type="checkbox"]').attr('checked',$(this).is(':checked'));
        });
    });
</script>

<form method="post" class="">
    <div class="row-fluid">
        <div class="span3">

            <div class="widget">
                <!-- Widget title -->
                <div class="widget-head">
                    Padronizar preços
                </div>
                <div class="widget-content">
                    <div class="padd">
                        <!-- Widget content -->
                        <?php
                        foreach ($arrayTamanho as $key => $tamanho) {
                            echo '<div class="row-fluid">';
                            echo "<div class='span6'>" . CHtml::label($tamanho, '') . "</div>";
                            echo "<div class='span6'>";
                            echo CHtml::hiddenField('TamanhoAdicional[tamanho_id][]', $key);
                            echo '<div class="input-prepend"><span class="add-on">R$ </span>' . CHtml::textField('TamanhoAdicional[preco][]', '', array('class' => 'span9')) . "</div>";
                            echo '</div>';
                            echo '</div>';
                        }
                        ?>
                        <hr/>
                        <?php
                        $this->widget('bootstrap.widgets.TbButton', array(
                            'buttonType' => 'submit',
                            'label' => 'Padronizar preços por tamanho',
                            'type' => 'success', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                            'size' => 'null', // null, 'large', 'small' or 'mini'
                            'block' => true
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="span9">
            <div class="widget">
                <!-- Widget title -->
                <div class="widget-head">Cardápio atual de adicionais</div>
                <div class="widget-content">
                    <div class="padd">
                        <table class="items table table-striped table-bordered table-condensed">
                            <thead>
                                <tr>
                                    <th style="width: 20px;"><input type="checkbox" id="check_all" /></th>
                                    <th>Borda</th>
                                    <?php
                                    echo '<th>' . implode('</th><th>', $arrayTamanho);
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($modelItens as $item) {
                                    echo '<tr>';
                                    echo '<td><input name="TamanhoAdicional[adicional_id][]" type="checkbox" value="' . $item->id . '" /></td>';
                                    echo '<td>' . $item->descricao . '</td>';

                                    foreach ($arrayTamanho as $key_tamanho => $tamanho) {
                                        $html[$key_tamanho] = "<td></td>";
                                        foreach ($item->tamanhoAdicionais as $tamanhoItem) {
                                            if ($tamanhoItem->tamanho_id == $key_tamanho && $tamanhoItem->excluida == 0) {
                                                $preco = isset($tamanhoItem->preco) && !$tamanhoItem->excluida ? 'R$ ' . number_format($tamanhoItem->preco, 2, ',', '.') : ' ';
                                                $ativo = !$tamanhoItem->ativa ? 'inativo' : '';

                                                $html[$key_tamanho] = '<td class="' . $ativo . '" >' . CHtml::link($preco, array('update', 'id' => $tamanhoItem->id)) . '</td>';
                                            }
                                        }
                                    }

                                    echo implode($html);
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>