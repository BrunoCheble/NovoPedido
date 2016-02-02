<!DOCTYPE HTML>
<?php Yii::app()->bootstrap->register(); ?>
<html lang="<?php echo Yii::app()->getLanguage(); ?>" xml:lang="<?php echo Yii::app()->getLanguage(); ?>">
    <head>
        <meta charset="<?php echo Yii::app()->charset; ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="Pedido online, Pizzaria Online, Delivery" />
        <meta property="og:image" content="<?= Yii::app()->controller->module->registerImageProtected('/clientes/'.Yii::app()->params['logo']); ?>" />
        <?php
        $baseUrl = Yii::app()->clientScript;
        $site = explode('.',$_SERVER['SERVER_NAME'])[0];
        
        $baseUrl->registerMetaTag('Pedido online, Pizzaria Online, Delivery', 'keywords', null);
        $baseUrl->registerMetaTag(Yii::app()->params['nome'].' - Novo pedido', null, null, array('property' => 'og:title'));
        $baseUrl->registerMetaTag(Yii::app()->params['nome'].' - Novo pedido', null, null, array('property' => 'og:site_name'));
        $baseUrl->registerMetaTag('Peça sua pizza pela internet!', 'description', null);
        $baseUrl->registerMetaTag('Peça sua pizza pela internet!', null, null, array('property' => 'og:description'));
        $baseUrl->registerMetaTag('website', null, null, array('property' => 'og:type'));
        $baseUrl->registerMetaTag('width=device-width', 'viewport', null);
        
        $baseUrl->registerMetaTag('http://'.$site.'.novopedido.com.br', null, null, array('property' => 'og:url'));

        $baseUrl->registerLinkTag('apple-touch-icon-precomposed', null, Yii::app()->controller->module->registerImageProtected('/clientes/'.Yii::app()->params['logo']), null, array('sizes' => '144x144'));
        $baseUrl->registerLinkTag('apple-touch-icon-precomposed', null, Yii::app()->controller->module->registerImageProtected('/clientes/'.Yii::app()->params['logo']), null, array('sizes' => '114x114'));
        $baseUrl->registerLinkTag('apple-touch-icon-precomposed', null, Yii::app()->controller->module->registerImageProtected('/clientes/'.Yii::app()->params['logo']), null, array('sizes' => '72x72'));
        $baseUrl->registerLinkTag('apple-touch-icon-precomposed', null, Yii::app()->controller->module->registerImageProtected('/clientes/'.Yii::app()->params['logo']), null);
        $baseUrl->registerLinkTag('shortcut icon', null, Yii::app()->controller->module->registerImage(Yii::app()->controller->module->registerImageProtected('/clientes/'.Yii::app()->params['logo'])), null);

        echo Yii::app()->controller->module->registerCss('main_site.css');
        
        Yii::app()->clientScript->registerPackage('slidebars');
        Yii::app()->clientScript->registerPackage('flaticon');
        
        ?>
        
        <title><?php echo Yii::app()->params['nome'].' - '.$this->tituloManual; ?></title>
    </head>
    <body>
        <script>
            $(document).ready(function(){
                $("button[type='submit']").click(function(){
                   $(this).parents('form').submit();
                });
            });
        </script>
        <?php
        $items = array(
            array('label' => 'Novo pedido', 'url' => array('pedido/index')),
            array('label' => 'Acompanhar o pedido', 'url' => array('pedido/visualizar'))
        );
        ?>
        
        <header id="main" class="visible-desktop">
            <?php
            $img = '<img alt="'.Yii::app()->params['nome'].'" src="'.Yii::app()->controller->module->registerImageProtected('/clientes/'.Yii::app()->params['logo']).'" />';
            echo CHtml::link($img,array(),array('id'=>'logo'));
            ?>
            <?php
                $model = new Pedido;
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'Pedido',
                    'action' => array('pedido/visualizar'),
                    'htmlOptions'=> array('class'=>'form-search','style'=>'margin-bottom: 0; margin-top:2em; text-align: center')
                ));
                echo '<div class="input-append">';
                echo $form->textField($model,'codigo',array('class'=>'input-small search-query','placeholder'=>'Seu pedido'));
                echo CHtml::htmlButton('<i class="icon-search"></i>',array('type' => 'submit','class'=>'btn'));
                echo '</div>';

                $this->endWidget();
            ?>
            
            <?php
            $this->widget('zii.widgets.CMenu', array(
                'items' => $items,
                'id' => 'nav_main',
            ));
            ?>
            
            <div style="text-align: center">
            <?php
                $this->widget('bootstrap.widgets.TbButton', array(
                    'label'=>'Feedback',
                    'type'=>'null',
                    'htmlOptions'=>array(
                        'data-toggle'=>'modal',
                        'data-target'=>'#feedback',
                        'style'=>'margin: 0 auto 20px;'
                    ),
                ));
                
                /*
                $this->widget('application.extensions.SocialShareButton.SocialShareButton', array(
                        'style'=>'vertical',
                        'networks' => array('facebook'),
                        'data_via'=>'', //twitter username (for twitter only, if exists else leave empty)
                ));
                */
                ?>
                
            </div>
            <div id="info-local">
                <?php echo Yii::app()->params['endereco'].' -'.Yii::app()->params['bairro']; ?><br/>
                <?php echo Yii::app()->params['telefone1'] . ' / ' .Yii::app()->params['telefone2']; ?>
            </div>
        </header>

        <?php $this->renderPartial('../layouts/_modalFeedback'); ?>

        <div id="sb-site" class='container'>
            <div class="navbar navbar-fixed-top fixed enable_fixed hidden-desktop">
                <div class="navbar-inner bg-red">
                    <div class="container">
                        <div class="navbar-search pull-right">
                            <?php
                            $form = $this->beginWidget('CActiveForm', array(
                                'id' => 'Pedido',
                                'action' => array('pedido/visualizar'),
                                'htmlOptions'=> array('class'=>'form-search','style'=>'margin-bottom: 0')

                            ));
                            
                            echo '<div class="input-append">';
                            echo $form->textField($model,'codigo',array('class'=>'span2 search-query','placeholder'=>'Consulte o seu pedido'));
                            echo CHtml::htmlButton('<i class="icon-search"></i>',array('type' => 'submit','class'=>'btn'));
                            echo '</div>';
                            
                            $this->endWidget();                    
                            ?>
                        </div>
                        <a style="float: left;" class="sb-open-left btn btn-navbar bg-red fixed">
                            <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
                        </a>
                    </div>
                </div>
            </div>
            <?= $content; ?>
        </div>

        <div class="sb-slidebar sb-left">
            <?php
            echo CHtml::link($img,'#',array('id'=>'logo'));
            
            $this->widget('zii.widgets.CMenu', array(
                'items' => $items,
                'id' => 'nav_main',
            ));
            ?>
            
            <div id="pizzaria-info">
                <?php echo Yii::app()->params['endereco'].' - '.Yii::app()->params['bairro']; ?><br/>
                <?php echo Yii::app()->params['telefone1'] . ' / ' .Yii::app()->params['telefone2']; ?>
            </div>
        </div>

        <script>
            (function($) {
                $(document).ready(function() {
                    $.slidebars();
                });
            })(jQuery);
            
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-55619131-1', 'auto');
            ga('send', 'pageview');

        </script>
        <style>
            #pizzaria-info{
                position: absolute;
                font-size: .9em;
                background: #A01614;
                padding: 10px 0;
                bottom: 0;
                left: 0;
                width: 100%;
                color: #fff;
                text-align: center;
                overflow-x: hidden;
            }
        </style>
    </body>
</html>