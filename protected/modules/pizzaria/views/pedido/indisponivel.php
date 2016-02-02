<?php
echo Yii::app()->controller->module->registerCss('pedido.css?4');
echo $this->tituloManual;
?>
<div class="bg-pedido">
    <?php
    echo CHtml::image(Yii::app()->controller->module->registerImageProtected('/promocoes/' . $modelBanner->imagem));
    ?>
    <div style="padding: 0 10px;">
        <h3 style="color: #fff;">No momento este serviço está indisponível :( <br/>Ligue para: <?= Yii::app()->params['telefone1']; ?> / <?= Yii::app()->params['telefone2']; ?> </h3>
    </div>
</div>
<script>
    tempoValidacao     = <?php echo Yii::app()->params['tempoValidacao']; ?>;
    ajaxValidaSituacao = '<?php echo Yii::app()->createAbsoluteUrl('pizzaria/pizzaria/validaSituacao'); ?>';
    urlNovoPedido      = '<?php echo Yii::app()->createAbsoluteUrl('pizzaria/pedido/index'); ?>';

    $(document).ready(function() {

        setInterval(function() {
            $.ajax({
                type: 'POST',
                url: ajaxValidaSituacao,
                complete: function(jqXHR, textStatus) {
                    var jsonData = eval('(' + jqXHR.responseText + ')');
                    
                    if(jsonData == 1)
                        window.location.href = urlNovoPedido;
                }
            })
        }, tempoValidacao);
    });
</script>