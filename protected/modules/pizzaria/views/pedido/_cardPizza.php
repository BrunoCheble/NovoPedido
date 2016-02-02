<section card-id="1" qtd-sabor-max="" class="card-pizza">
    <div class="border-top titulo_pizza bg-yellow row-fluid">
        <span class="preco_pizza pull-right">R$ 0,00</span>
        <h4><span class="numero_pizza">1</span> Pizza -<span class="tamanho_pizza"></span> <span class="tipo_pizza hidden-phone"></span></h4>
    </div>
    <div class="content-pizza">
        <div class="row-fluid">
            <div class="span3">
                <label class="hidden-phone">Selecione o tamanho</label>
                <?php echo CHtml::dropDownList('Pizza[tamanho]', key(array_slice($modelTamanho, -1, 1, TRUE)), $modelTamanho, array('class'=>'span12')); ?>
                <label class="hidden-phone">Selecione o tipo do sabor?</label>
                <?php echo CHtml::dropDownList('Pizza[TipoSabor]', 1, $arrayTipoSabor, array('class'=>'span12')); ?>
                
                <div class="borda_e_tipo_massa" style="">
                    <?php
                        if($modelPizzaria->borda_pizza){
                            echo CHtml::label('Selecione a borda recheada', '',array('class'=>'hidden-phone'));
                            echo CHtml::dropDownList('Pizza[TamanhoBorda]', '', array(), array('empty' => 'Sem borda','class'=>'span12'));
                        }
                        
                        if($modelPizzaria->massa_pizza){
                            echo CHtml::label('Selecione o tipo da massa', '',array('class'=>'hidden-phone'));
                            echo CHtml::dropDownList('Pizza[TamanhoTipoMassa]', '', array(), array('empty' => 'Tipo da massa','class'=>'span12'));
                        }
                    ?>
                </div>
            </div>
            <div class="span9">
                <div class="box-sabores">
                    <div class="row-fluid">
                        <?php 
                            $this->widget('bootstrap.widgets.TbButton', array(
                                'label'=>'Escolha o(s) sabor(es) desta pizza',
                                'type'=>'success', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                                'htmlOptions'=>array(
                                    'data-toggle' => 'modal',
                                    'data-target' => '#modal-sabores',
                                    'class'       => 'btn_escolher_sabor span6'
                                )
                            )); 

                            if($modelPizzaria->adicional_pizza){
                                $this->widget('bootstrap.widgets.TbButton', array(
                                    'label'=>'Escolher Adicionais',
                                    'type'=>'null', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                                    'htmlOptions'=>array(
                                        'data-toggle' => 'modal',
                                        'data-target' => '#modal-adicional',
                                        'class'       => 'btn_add_adicional span6',
                                        'style'=>'display: none'
                                    )
                                ));
                                echo CHtml::dropDownList('Pizza[TamanhoAdicional]', '', array(), array('multiple' => 'multiple','style'=>'display: none'));
                            }
                        ?>
                    </div>
                    <div preco="" total-adicionais="" class="list-sabores vazio"></div>
                </div>
            </div>  
        </div>
    </div>
</section>



