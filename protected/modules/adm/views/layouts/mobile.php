<!DOCTYPE HTML>
<?php Yii::app()->bootstrap->register(); ?>
<html lang="<?php echo Yii::app()->getLanguage(); ?>" xml:lang="<?php echo Yii::app()->getLanguage(); ?>">
    <head>

        <meta charset="<?php echo Yii::app()->charset; ?>" />
        <meta name="robots" content="noindex,nofollow" />
        <?php
        echo Yii::app()->controller->module->registerCss('main.css');
        Yii::app()->clientScript->registerPackage('flaticon');
        echo Yii::app()->controller->module->registerScript('main.js', CClientScript::POS_END);
        ?>

    </head>
    <body class="adm">
        <div class='content'>

            <div class="matter">
                <div class="container">
                    <?= $content; ?>
                </div>
            </div>
        </div>
    </body>
</html>