<div class="box-mobile">
    <h4 class="border-top bg-yellow">Detalhes do seu pedido</h4>
    <div class="content-box">
        <div id="list-itens-modelo">
            
            <div class="resumo_item_pizza" id="modelo-resumo-pizza">
                <h6 class="pull-right resumo_preco"></h6>
                <h6 class="resumo_item"></h6>
                <p class="resumo-list-sabores"></p>
                <?php
                    if($modelPizzaria->borda_pizza){
                        echo '<p class="borda item-extra"></p>';
                    }
                    
                    if($modelPizzaria->adicional_pizza){
                        echo '<p class="adicional item-extra"></p>';
                    }
                    
                    if($modelPizzaria->massa_pizza){
                        echo '<p class="tipo_massa item-extra"></p>';
                    }
                ?>
            </div>

            <div style="display: none" class="resumo_combinado" id="modelo-resumo-combinado">
                <h6><span class="resumo_item"></span><span class="pull-right resumo_preco"></span></h6>
                <ul></ul>
            </div>

            <div style="display: none" class="resumo_produto" id="modelo-resumo-produto">
                <h6><span class="qtd_item"></span> - <span class="resumo_item"></span><span class="pull-right resumo_preco"></span></h6>
                <p class="resumo-peso"></p>
            </div>

            <div style="display: none" class="resumo_promocao" id="modelo-resumo-promocao">
                <h6><span class="resumo_item"></span><span class="pull-right resumo_preco"></span></h6>
                <p class="resumo-peso"></p>
            </div>
            
            <div class="resumo-sub-total">
                <h6>Sub-total:<span class="pull-right">R$ 0,00</span></h6>
            </div>
            <div class="resumo-taxa-frete"><h6>Taxa de entrega:<span class="pull-right"></span></h6></div>
            <div class="resumo-total">
                <h6>Total:<span class="pull-right"></span></h6>
            </div>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span5">
        <div class="box-mobile">
            <h4 class="border-top bg-yellow">Forma de pagamento</h4>
            <div class="box-formapagamento content-box">
                <div class="alert">
                    <strong>Valor total do pedido: <span id="valor_total"></span></strong>
                </div>
                <h5 class='sub_titulo'>Como deseja pagar?</h5>
                <?php echo CHtml::dropDownList('Pedido[forma_pagamento_id]', '', $arrayFormaPagamento, array('class' => 'span12')); ?>
                <div id='opcoes-pagamento'>
                    <?php $this->renderPartial('_formaPagamento', array('modelPedido' => $modelPedido)); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="span7 box-mobile">
        <h4 class="border-top bg-yellow">Detalhes para a entrega</h4>
        <div class="content-box">
        <?php
        $tabs[] = array(
            'id' => 'aba-pedido',
            'icon' => 'flat-verification5',
            'active' => true,
            'label' => Yii::t('Pedido', 'Finalizar pedido'),
            'content' => $this->renderPartial('_enderecoPedido', array(
                'modelPedido'   => $modelPedido
            ), true),
        );
        
        $tabs[] = array(
            'label' => Yii::t('Pedido', 'Cadastrar-me'),
            'icon' => 'flat-create1',
            'content' => $this->renderPartial('_formCliente', array(
                'modelCliente'        => $modelCliente,
                'loginForm'           => $loginForm,
                'modelPedido'         => $modelPedido,
                'modelUsuario'        => $modelUsuario,
                'arrayFormaPagamento' => $arrayFormaPagamento
            ), true),
        );
        
        $tabs[] = array(
            'label' => Yii::t('Pedido', 'Já sou cadastrado'),
            'icon' => 'flat-user91',
            'content' => $this->renderPartial('_formLogin', array('loginForm' => $loginForm), true),
        );

        $this->widget('bootstrap.widgets.TbTabs', array(
            'tabs' => $tabs,
            'id' => 'nav-finalizar-pedido'
        ));
        
        ?>
        </div>
    </div>
</div>