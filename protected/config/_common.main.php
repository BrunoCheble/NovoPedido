<?php
Yii::setPathOfAlias('bootstrap', dirname(__FILE__) . '/../extensions/bootstrap');

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Novo pedido',
    'sourceLanguage' => 'pt_br',
    'language' => 'pt_br',
    'defaultController' => 'pizzaria/pedido',
    'preload' => array(
        'log',
    ),
    'timeZone' => 'America/Sao_Paulo',
    // autoloading model and component classes
    'import' => array(
        'application.components.*',
        'application.extensions.*',
        'application.extensions.bootstrap.*',
//        'application.extensions.bootstrap-select.*',
        'application.extensions.yii-mail.*',
        'application.models.*',
        'application.models.forms.*',
        'application.migrations.*',
    ),
    'modules' => array(
        'adm' => array(
            'defaultController' => 'usuario/login',
            'import' => array(
                'application.modules.adm.components.*',
                'application.modules.adm.helpers.*',
                'application.modules.adm.extensions.*',
                'application.modules.adm.models.form.*',
            ),
            'components' => array(
            )
        ),
        'pizzaria' => array(
            'defaultController' => 'pedido',
            'import' => array(
                'application.modules.pizzaria.components.*',
                'application.modules.pizzaria.extensions.*',
                'application.modules.pizzaria.models.forms.*',
            ),
            'components' => array(
                
            )
        ),
    ),
    // application components
    'components' => array(
        'errorHandler' => array(
            'errorAction' => 'pizzaria/home/error',
        ),
        'user' => array(
            'allowAutoLogin' => true,
            'class' => 'WebUser',
        ),
        'bootstrap' => array(
            'class' => 'application.extensions.YiiBootstrap',
        ),
        
        'session' => array (
            'autoStart' => false,
            'sessionName' => 'cliente'
        ),
        'clientScript' => array( 
            'packages' => array(
                'flaticon' => array( 
                    'basePath' => 'application.assets.css.flaticon', 
                    'css' => array('flaticon.css'),
                ), 
                'jquery-maskmoney' => array( 
                    'basePath' => 'application.assets.plugins.xm_mask_money', 
                    'js' => array('js/jquery.maskMoney.js'), 
                    'depends' => array('jquery'),
                ), 
                'jquery-toastmessage' => array( 
                    'basePath' => 'application.assets.plugins.xm_toast_message', 
                    'css' => array('css/jquery.toastmessage.css'), 
                    'js' => array('js/jquery.toastmessage.js'), 
                    'depends' => array('jquery'), 
                ),
                'google_maps' => array( 
                    'basePath' => 'application.assets.plugins.google_map', 
                    'js' => array('google_map.js'),
                    'depends' => array('jquery'), 
                ), 
                'slidebars' => array( 
                    'basePath' => 'application.assets.plugins.slidebars', 
                    'css' => array('slidebars.css'), 
                    'js' => array('slidebars.js'), 
                    'depends' => array('jquery'), 
                ),
            ), 
        ), 
        // enable URLs in path-format
        'urlManager'=>array(
            'urlFormat'=>'path',
            'showScriptName' => false,
            'rules'=>array(
                'adm/<controller:\w+>/<action:\w+>' => 'adm/<controller>/<action>',
                'adm' => 'adm/usuario/login',
                '' => 'pizzaria/pedido/index',
            ),
        ),
        
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            /*
              array(
              'class'=>'CEmailLogRoute',
              'levels'=>'error, warning',
              'emails'=>'tenha@perspectiva.in',
              ),
             */
            ),
        ),
        'mail' => array(
            'class' => 'application.extensions.yii-mail.YiiMail',
            'transportType' => 'smtp',
            'transportOptions' => array(
                'host' => 'smtp.gmail.com',
                'username' => 'contato@xeque-mate.com.br',
                'password' => '123mudar',
                'port' => '465',
                'encryption' => 'ssl',
            ),
            'viewPath' => 'application.modules.adm.views.mail',
            'logging' => true,
            'dryRun' => false
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        'adminEmail'     => 'contato@misterpizza.com.br',
        'tempoValidacao' => 20000, // 20seg Expresso em segundos
        'nome'           => '',
        'telefone1'      => '',
        'telefone2'      => '',
        'bairro'         => '',
        'endereco'       => '',
        'numero'         => '',
    ),
);
