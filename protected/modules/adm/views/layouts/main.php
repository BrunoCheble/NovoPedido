<!DOCTYPE HTML>
<?php Yii::app()->bootstrap->register(); ?>
<html lang="<?php echo Yii::app()->getLanguage(); ?>" xml:lang="<?php echo Yii::app()->getLanguage(); ?>">
    <head>

        <meta charset="<?php echo Yii::app()->charset; ?>" />
        <meta name="robots" content="noindex,nofollow" />
        <meta http-equiv="refresh" content="<?php echo Yii::app()->params['tempoValidacao']*15;?>;"/>
        <?php
        $baseUrl = Yii::app()->clientScript;
        
        $baseUrl->registerMetaTag('Pedido online, Pizzaria Online, Delivery', 'keywords', null);
        $baseUrl->registerMetaTag('Novo Pedido - '.$this->tituloManual, null, null, array('property' => 'og:title'));
        $baseUrl->registerMetaTag('Novo Pedido - '.$this->tituloManual, null, null, array('property' => 'og:site_name'));
        $baseUrl->registerMetaTag('Peça sua pizza pela internet!', 'description', null);
        $baseUrl->registerMetaTag('Peça sua pizza pela internet!', null, null, array('property' => 'og:description'));
        $baseUrl->registerMetaTag('website', null, null, array('property' => 'og:type'));
        $baseUrl->registerMetaTag('width=device-width', 'viewport', null);

        echo Yii::app()->controller->module->registerCss('main.css');

        Yii::app()->clientScript->registerPackage('flaticon');
        //echo Yii::app()->controller->module->registerScript('main.js', CClientScript::POS_END);

        $baseUrl->registerLinkTag('apple-touch-icon-precomposed', null, Yii::app()->controller->module->registerImage('apple-touch-icon-144-precomposed.png'), null, array('sizes' => '144x144'));
        $baseUrl->registerLinkTag('apple-touch-icon-precomposed', null, Yii::app()->controller->module->registerImage('apple-touch-icon-114-precomposed.png'), null, array('sizes' => '114x114'));
        $baseUrl->registerLinkTag('apple-touch-icon-precomposed', null, Yii::app()->controller->module->registerImage('apple-touch-icon-72-precomposed.png'), null, array('sizes' => '72x72'));
        $baseUrl->registerLinkTag('apple-touch-icon-precomposed', null, Yii::app()->controller->module->registerImage('apple-touch-icon-57-precomposed.png'), null);
        $baseUrl->registerLinkTag('shortcut icon', null, Yii::app()->controller->module->registerImage('favicon.ico'), null);
        ?>

    </head>
    <body class="adm">
        <div class='content'>

            <?php
            $nome = '';
                if (!Yii::app()->user->isGuest){

                    $isCliente = Yii::app()->user->isCliente();
                    $isAdmin = Yii::app()->user->isAdmin();
                    $isAtendimento = Yii::app()->user->isAtendimento();
                    $isCozinha = Yii::app()->user->isCozinha();

                    $visualizarPizza = Yii::app()->controller->visualizarPizza();
                    $visualizarBorda = Yii::app()->controller->visualizarBorda();
                    $visualizarAdicional = Yii::app()->controller->visualizarAdicional();
                    $visualizarTipoMassa = Yii::app()->controller->visualizarTipoMassa();

                    $visualizarCombinado = Yii::app()->controller->visualizarCombinado();


                    if($isAdmin)
                        $nome = 'Administrador - ';
                    else if($isCozinha)
                        $nome = 'Cozinha - ';
                    else
                        $nome = 'Atendimento - ';

                    if(!$isCliente){
                        $this->widget('bootstrap.widgets.TbNavbar', array(
                            'type'     => 'null',
                            'brandUrl' => '#',
                            'brandOptions' => array('id'=>'turnTime'),
                            'brand'    => Yii::app()->controller->validaSituacao() ? '<i title="Desligar sistema" class="icon-flat-power17 off"></i>' : '<i title="Ligar sistema" class="icon-flat-power1 on"></i>',
                            'collapse' => true,
                            'items'    => array(
                                array(
                                    'class' => 'bootstrap.widgets.TbMenu',
                                    'items' => array(
                                        array(
                                            'label' => 'Dashboard',
                                            'url' => array('pedido/dashboard'),
                                            'visible' => $isAtendimento
                                        ),
                                        array(
                                            'label' => 'Pedidos',
                                            'url' => array('pedido/index'),
                                            'visible' => $isAtendimento
                                        ),
                                        array(
                                            'label' => 'Pizzas',
                                            'url'   => '#',
                                            'items' => array(
                                                array(
                                                    'label'  => 'Tamanho',
                                                    'url'    => array('tamanho/index')
                                                ),
                                                array(
                                                    'label'  => 'Sabores de pizzas',
                                                    'url'    => array('sabor/index')
                                                ),
                                                array(
                                                    'label'   => 'Bordas recheadas',
                                                    'url'     => array('borda/index'),
                                                    'visible' => $visualizarBorda
                                                ),
                                                array(
                                                    'label'   => 'Adicionais extra',
                                                    'url'     => array('adicional/index'),
                                                    'visible' => $visualizarAdicional
                                                ),
                                                array(
                                                    'label'   => 'Tipos de massas',
                                                    'url'     => array('tipoMassa/index'),
                                                    'visible' => $visualizarTipoMassa
                                                ),
                                            ),
                                            'visible' => $visualizarPizza && $isAdmin
                                        ),
                                        array(
                                            'label' => 'Preço das pizzas',
                                            'url'   => '#',
                                            'items' => array(
                                                array(
                                                    'label'   => 'Sabores de pizzas',
                                                    'url'     => array('tamanhoSabor/saveAll')
                                                ),
                                                array(
                                                    'label'   => 'Bordas recheadas',
                                                    'url'     => array('tamanhoBorda/saveAll'),
                                                    'visible' => $visualizarBorda
                                                ),
                                                array(
                                                    'label'   => 'Adicionais extras',
                                                    'url'     => array('tamanhoAdicional/saveAll'),
                                                    'visible' => $visualizarAdicional
                                                ),
                                                array(
                                                    'label'   => 'Tipos de massas',
                                                    'url'     => array('tamanhoTipoMassa/saveAll'),
                                                    'visible' => $visualizarTipoMassa
                                                ),
                                            ),
                                            'visible' => $visualizarPizza && $isAdmin
                                        ),
                                        array(
                                            'label' => 'Combinados',
                                            'url' => array('combinado/index'),
                                            'visible' => $visualizarCombinado && $isAdmin
                                        ),
                                        array(
                                            'label' => 'Pratos, Lanches e Bebidas',
                                            'url'   => '#',
                                            'items' => array(
                                                array(
                                                    'label' => 'Sub-categorias',
                                                    'url'   => array('subCategoria/index')
                                                ),
                                                array(
                                                    'label' => 'Pratos, Lanches e Bebidas',
                                                    'url'   => array('produto/index')
                                                ),
                                            ),
                                            'visible' => $isAdmin
                                        ),
                                        array(
                                            'label' => 'Logística',
                                            'url'   => '#',
                                            'items' => array(
                                                array(
                                                    'label' => 'Entregas',
                                                    'url'   => array('entrega/index')
                                                ),                                    
                                                array(
                                                    'label' => 'Entregadores',
                                                    'url'   => array('entregador/index')
                                                ),
                                                array(
                                                    'label' => 'Locais de entrega',
                                                    'url'   => array('enderecoPermitido/index')
                                                )
                                            ),
                                            'visible' => $isAdmin
                                        ),
                                        array(
                                            'label' => 'Clientes',
                                            'url'   => array('cliente/index'),
                                            'visible' => $isAdmin
                                        ),
                                        array(
                                            'label' => 'Formas de pagamento',
                                            'url' => array('formaPagamento/index'),
                                            'visible' => $isAdmin
                                        ),
                                        array(
                                            'label' => 'Destaques',
                                            'url'   => '#',
                                            'items' => array(
                                                array(
                                                    'label' => 'Promoções',
                                                    'url'   => array('promocao/index')
                                                ),
                                                array(
                                                    'label' => 'Banners',
                                                    'url'   => array('banner/index')
                                                ),
                                            ),
                                            'visible' => $isAdmin
                                        ),
                                        array(
                                            'label' => 'Configuração',
                                            'url'   => array('pizzaria/index'),
                                            'visible' => false
                                        ),
                                    ),
                                ),
                            ),
                            'htmlOptions' => array('class'=>'hidden-print')
                        ));
                    }
                }
            ?>
            
            <?php
            Yii::app()->clientScript->registerScript('scriptStatus',
                "
                $(document).ready(function(){
                    
                    $('.form-horizontal button.btn-success').click(function(e){
                        e.preventDefault();
                        $(this).attr('disabled',true).text('Salvando...');
                        $(this).parents('form').submit();
                    });
    
                    setInterval(function () {
                        if($('.icon-flat-power17.off').length > 0){
                            $.ajax({
                                type: 'POST',
                                url: '".Yii::app()->createAbsoluteUrl('adm/pizzaria/updateTime')."',
                            });
                        }
                    }, ".(Yii::app()->params['tempoValidacao']/2).");
                    
                    $('.icon-flat-power1.on').live('click',function(){
                        $.ajax({
                            type: 'POST',
                            url: '".Yii::app()->createAbsoluteUrl('adm/pizzaria/updateTime')."',
                        }).success(function(data) {
                            $('.icon-flat-power1.on').removeAttr('class').attr('class','icon-flat-power17 off');
                        });
                    });
                    
                    $('.icon-flat-power17.off').live('click',function(){
                        $.ajax({
                            type: 'POST',
                            url: '".Yii::app()->createAbsoluteUrl('adm/pizzaria/stopTime')."',
                        }).success(function(data) {
                            $('.icon-flat-power17.off').removeAttr('class').attr('class','icon-flat-power1 on');
                        });
                    });
                });
                "
            );
            ?>
            <header class="visible-desktop hidden-print">
                <div class="container">
                    <h1><?= $nome ?><?= Yii::app()->params['nome']; ?></h1>
                </div>
            </header>
            <div class="mainbar hidden-print">
                <div class="page-head">
                    <div class="container">
                        <div class="visible-desktop pull-right">
                            <?php
                            $this->widget('zii.widgets.CBreadcrumbs', array(
                                'links' => $this->breadcrumbs,
                            ));
                            ?>
                        </div>
                        <h2 class="pull-left"><?= $this->tituloManual; ?></h2>
                    </div>
                </div>
            </div>
            <div class="matter">
                <div class="container">
                    <?= $content; ?>
                </div>
            </div>
        </div>
    </body>
</html>