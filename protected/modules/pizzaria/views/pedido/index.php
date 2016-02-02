<?php 
    //Yii::app()->clientScript->registerPackage('jquery-maskmoney');
    
    Yii::app()->clientScript->registerPackage('jquery-toastmessage');
    echo Yii::app()->controller->module->registerScript('pedido.js?5');
    echo Yii::app()->controller->module->registerCss('pedido.css?4');
    
?>

<div class="bg-pedido">
     <?php
        echo CHtml::image(Yii::app()->controller->module->registerImageProtected('/promocoes/'.$modelBanner->imagem));
    ?>
    <div style="padding: 5px;">
        
        <div id="servico-indisponivel" style="display: none; padding: 0 10px;">
            <h3 style="color: #fff;">Desculpe interrompê-lo, mas infelizmente este serviço está indisponível :( <br/>Ligue para: <?= Yii::app()->params['telefone1']; ?> / <?= Yii::app()->params['telefone2']; ?> </h3>
        </div>
        <div id="box_endereco">
        <?php        
            echo CHtml::dropDownList('EnderecoPedido_bairro','bairro',$arrayBairro,array('empty'=>'Selecione o bairro','class'=>'span3'));
            echo CHtml::dropDownList('EnderecoPedido_endereco','endereco',array(),array('style'=>'display:none;','empty'=>'Selecione o endereço','class'=>'span3'));
        ?>
        </div>
        <span style="display:none; margin-left: 1em; color: #fff" id="load_endereco">Carregando endereços...</span>
    </div>
    <div>
        <?php
            $this->widget('bootstrap.widgets.TbButton', array(
                'label' => 'Internet lenta?',
                'type'  => 'null', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'size'  => 'null', // null, 'large', 'small' or 'mini'
                'htmlOptions'=> array(
                    'id'=>'net_lenta',
                    'style'=>'margin-top: 20px!important;'
                ),
            ));
        ?>
    </div>
</div>

<h1 class="visible-desktop"><?= Yii::t('Pedido','Monte seu pedido'); ?></h1>

<div class="row-fluid">
    <div id="info-pedido">
        <div class="bg-green titulo">Resumo do pedido</div>
        <div class="info-geral-bar-top">Valor mín.: <b id="valor-min">R$ <?= number_format($modelPizzaria->pedido_min,2,',','.'); ?></b></div>
        <div class="info-geral-bar-top">Sub-total: <b id="sub-total-geral">R$ 0,00</b></div>
    </div>
</div>

<?php
    $tabs[] = array(
        'label'   => Yii::t('Pedido','Pizza'),
        'icon'    => 'flat-pizza3',
        'active'  => $modelPizzaria->tipo_restaurante == TipoRestaurante::_TIPO_PIZZARIA_,
        'visible' => $modelPizzaria->tipo_restaurante == TipoRestaurante::_TIPO_PIZZARIA_,
        'content' => $this->renderPartial('_abaPizza', array(
            'modelTamanho'   => $modelTamanho,
            'arrayTipoSabor' => $arrayTipoSabor,
            'modelPizzaria'  => $modelPizzaria
        ), true),
    );

    $tabs[] = array(
        'label'   => Yii::t('Pedido','Combinados'),
        'icon'    => 'flat-snacks',
        'active'  => $modelPizzaria->tipo_restaurante == TipoRestaurante::_TIPO_JAPONES_,
        'visible' => $modelPizzaria->tipo_restaurante == TipoRestaurante::_TIPO_JAPONES_,
        'content' => $this->renderPartial('_abaCombinado', array('listCombinado'=>$listCombinado),
        true),
    );

    $tabs[] = array(
        'label'   => Yii::t('Pedido','Pratos e lanches'),
        'icon'    => 'flat-snacks',
        'content' => $this->renderPartial('_abaPratoLanche', array('dataPratosLanche'=>$dataPratosLanche),true),
        'visible' => $modelPizzaria->pratos_lanches
    );

    $tabs[] = array(
        'label'   => Yii::t('Pedido','Promoção'),
        'icon'    => 'flat-offer',
        'content' => $this->renderPartial('_abaPromocao', array('dataPromocao'=>$dataPromocao), true),
    );
    
    $tabs[] = array(
        'label'   => Yii::t('Pedido','Bebidas'),
        'icon'    => 'flat-bottle24',
        'content' => $this->renderPartial('_abaBebida', array('dataBebidas'=>$dataBebidas), true),
    );

    $tabs[] = array(
        'label'   => Yii::t('Pedido','Finalizar'),
        'icon' => 'flat-banknotes',
        'content' => $this->renderPartial('_abaFinalizar', array(
            'modelCliente'        => $modelCliente,
            'loginForm'           => $loginForm,
            'modelPedido'         => $modelPedido,
            'modelUsuario'        => $modelUsuario,
            'arrayFormaPagamento' => $arrayFormaPagamento,
            'modelPizzaria'       => $modelPizzaria
        ),true),
    );

    $this->widget('bootstrap.widgets.TbTabs', array(
        'tabs'=>$tabs,
        'id' => 'sistema-pedido',
        'htmlOptions' => array(
            'style'   => 'display: block',
            'class'   => 'fixed enable_fixed'
        ),
    ));
?>
    

<script>
    tempoValidacao               = <?php echo Yii::app()->params['tempoValidacao']; ?>;
    ajaxValidaSituacao           = '<?php echo Yii::app()->createAbsoluteUrl('pizzaria/pizzaria/validaSituacao'); ?>';
    valorMinimo                  = '<?php echo $modelPizzaria->pedido_min; ?>';
    ajaxSavePedido               = '<?php echo Yii::app()->createAbsoluteUrl('pizzaria/pedido/ajaxSave'); ?>';
    ajaxGetArrayEndereco         = '<?php echo Yii::app()->createAbsoluteUrl('pizzaria/enderecoPermitido/ajaxGetArrayEndereco'); ?>';
    ajaxGetArrayPizza            = '<?php echo Yii::app()->createAbsoluteUrl('pizzaria/pizza/ajaxGetArrayPizza'); ?>';
    ajaxGetArrayTamanhoBorda     = '<?php echo Yii::app()->createAbsoluteUrl('pizzaria/tamanhoBorda/ajaxGetArrayTamanhoBorda'); ?>';
    ajaxGetArrayTamanhoAdicional = '<?php echo Yii::app()->createAbsoluteUrl('pizzaria/tamanhoAdicional/ajaxGetArrayTamanhoAdicional'); ?>';
    ajaxGetTamanhoSabor          = '<?php echo Yii::app()->createAbsoluteUrl('pizzaria/tamanhoSabor/ajaxGetTamanhoSabor'); ?>';
    urlImage                     = '<?php echo Yii::app()->controller->module->getUrlBaseImage(); ?>';
    visualizarPedido             = '<?php echo Yii::app()->createAbsoluteUrl('pizzaria/pedido/visualizar'); ?>';
    ajaxGetItemCombinado         = '<?php echo Yii::app()->createAbsoluteUrl('pizzaria/itemCombinado/ajaxGetItemCombinado'); ?>';

    $('#net_lenta').click(function(){
        $('#sistema-pedido img').parent('*').prepend('<i class="icon-flat-"></i>');
        $('#sistema-pedido img').hide();
        $('body').addClass('modo-basico');
        $(this).hide();
    });
</script>