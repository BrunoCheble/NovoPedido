<style>
    .link-turn{
        text-align: center; display: block; border:1px solid #ccc; margin-top: 2em;
        background: #ffffff; /* Old browsers */
background: -moz-linear-gradient(top,  #ffffff 0%, #f1f1f1 50%, #e1e1e1 51%, #f6f6f6 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(50%,#f1f1f1), color-stop(51%,#e1e1e1), color-stop(100%,#f6f6f6)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #ffffff 0%,#f1f1f1 50%,#e1e1e1 51%,#f6f6f6 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #ffffff 0%,#f1f1f1 50%,#e1e1e1 51%,#f6f6f6 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #ffffff 0%,#f1f1f1 50%,#e1e1e1 51%,#f6f6f6 100%); /* IE10+ */
background: linear-gradient(to bottom,  #ffffff 0%,#f1f1f1 50%,#e1e1e1 51%,#f6f6f6 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#f6f6f6',GradientType=0 ); /* IE6-9 */
    border-radius: 1em;
    }
    
    .link-turn i{width: auto; margin: 1em 0; height: auto; background: none; vertical-align: text-bottom;}
    .link-turn i:before,.link-turn i:after{
        font-size: 10em;
        line-height: 1em;
    }
    .status-atual{text-align: center;}
</style>
<div>
    <?php
        $status = array(
            array(
                'icon'=>'icon-flat-power1 on',
                'alert' => 'error',
                'label'=>'Desligado!',
                'text'=>'Atualmente o sistema de pedidos está desligado, clique no botão para liga-lo.',
            ),
            array(
                'icon'=>'icon-flat-power17 off',
                'alert' => 'success',
                'label'=>'Ligado!',
                'text'=>'Atualmente o sistema de pedidos está ligado, clique no botão para desliga-lo.',
                )
            );
    ?>
<div class="alert in alert-block fade <?= 'alert-'.$status[$situacao]['alert']; ?>"><a class="close" data-dismiss="alert">×</a><strong><?= $status[$situacao]['label']; ?></strong> <?= $status[$situacao]['text']; ?></div>
    
    <?php echo CHtml::link('<i class="'.$status[$situacao]['icon'].'"></i>',array('updateStatus','mobile'=>true),array('class'=>'link-turn')); ?>
</div>