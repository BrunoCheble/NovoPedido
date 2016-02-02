<h1 class="visible-desktop">Cardápio</h1>
<div class="row-fluid">
    <div class="span8">
        <h3 class="p20">Pizzas</h3>
        <div class="row-fluid">
            <div class="span5">
                <?= CHtml::image(Yii::app()->controller->module->registerImage('page4-img1.jpg'), '', array('class' => 'thumbnail')); ?>
            </div>
            <div class="span7">
                <a class="font_style" href="#">Tamanhos</a>
                <p class="desc_cardapio"><?= implode(' | ', $listTamanho); ?></p>
                <?php
                foreach ($modelSabor as $item)
                    echo "<a class='font_style' href='#'>" . $item->descricao . "</a><p class='desc_cardapio'>" . $item->ingredientes . "</p>";
                ?>
            </div>
        </div>

        <h3>Massas</h3>
        <div class="row-fluid">
            <div class="span5">
                <?= CHtml::image(Yii::app()->controller->module->registerImage('page4-img2.jpg'), '', array('class' => 'thumbnail')); ?>
            </div>
            <div class="span7">
                <?php
                foreach ($listMassa as $item) {
                    echo '<a class="font_style" href="#">' . $item['descricao'] . '</a><p class="desc_cardapio">';
                    echo isset($item['sabor']) ? implode(', ', $item['sabor']) : null;
                    echo '</p>';
                }
                ?>
            </div>
        </div>
    </div>

    <div class="span4">
        <h3 class="p13">Aplicações</h3>

        <a class="link2" href="#">Personalize a sua pizza, acrescentando quaisquer dos ítens abaixo por um pequeno acréscimo no preço.</a>
        <p class="desc_cardapio"><?= implode(', ', $listAdicional); ?></p>
        <!--
        <h2 class="p13">
          Sobremesas
        </h2>
                        <a class="link2" href="#">Mousse </a><p class="p21">chocolate, maracujá ou limão</p>
            <a class="link2" href="#">Pizza de chocolate (brotinho) </a><p class="p21"></p>
        -->

        <h3 class="p13">Bebidas</h3>
        <?php
        foreach ($listBebidas as $item) {
            echo '<a class="font_style" href="#">' . $item['descricao'] . '</a>';
            echo '<p class="desc_cardapio">';
            echo implode(', ', $item['quantidade']);
            echo '</p>';
        }
        ?>

    </div>
</div>