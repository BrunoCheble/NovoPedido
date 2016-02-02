$(document).ready(function() {
    $('.btn, .nav a').live({
        click: function(e) {
            e.preventDefault();
        }
    });

    setInterval(function() {
        $.ajax({
            type: 'POST',
            url: ajaxValidaSituacao,
            complete: function(jqXHR, textStatus) {
                var jsonData = eval('(' + jqXHR.responseText + ')');

                if (jsonData === 1)
                {
                    if ($('#servico-indisponivel').is(':visible'))
                        $('#servico-indisponivel').hide();

                    if ($('#EnderecoPedido_endereco').val() !== "" && $('#EnderecoPedido_endereco').val() !== "undefined")
                        $('.bg-pedido').hide();

                    $('#EnderecoPedido_endereco, #net_lenta').show();
                }
                else
                {
                    if ($('.bg-pedido').is(':visible') == false)
                        $('.bg-pedido').show();

                    $('#servico-indisponivel').show();
                    $('#box_endereco, #net_lenta').hide();
                }
            }
        });
    }, tempoValidacao);

    $('.add-promocao').live('click', function() {
        item = $(this).parents('.item-promocao').clone();
        $('.list-promocao').append(item);
        calculaSubTotal();
        setResumoGeral();
    });

    $('.div-promocao').live('click', function() {
        item = $(this).parents('.item-promocao').find('.cmp-item-promocao:last-child').clone();
        item.find('input').val('');
        $(this).parents('.item-promocao').find('.lista-cmp-item-promocao').append(item);
    });

    $('[name="Pedido[item_promocao_qtd]"]').live('focusout',function(){

        var cmp_inserida = $(this).parents('.lista-cmp-item-promocao').find('input');
        var qtd_inserida = 0;

        $.each(cmp_inserida,function(){
            if($(this).val() != '')
                qtd_inserida += parseInt($(this).val());
        });

        qtd_total = parseInt($(this).parents('.item-promocao').attr('qtd-max'));

        if(qtd_inserida > qtd_total) {
            jQuery().toastmessage('showToast', {
                text: 'A quantidade máxima desta promoção é de '+qtd_total+' itens',
                type: 'error',
                sticky: false,
                stayTime: 3000,
            });

            cmp_inserida.val('');
        }

    });

    $('[name="Pedido[item_promocao_id]"]').live('change', function()
    {
        setResumoPromocao();
    });

    $('[name="Promocao[id]"]').live('change', function()
    {
        calculaSubTotal();
        //$('.item-promocao select').attr('disabled',true);        
        $(this).parents('.item-promocao').find('select,input').attr('disabled', false);
        setResumoGeral();
    });

    $('[name="Pedido[forma_pagamento_id]"]').change(function() {
        if ($(this).val() == 1) {
            $("#opcoes-pagamento #dinheiro").show();
        } else {
            $("#opcoes-pagamento #dinheiro").hide();
        }
    });

    $('.btn_add_adicional').live({
        click: function() {
            card = $(this).parents('.card-pizza');
            card_id = card.attr('card-id');
            tamanho_id = card.find('[name="Pizza[tamanho]"]').val();
            select = card.find('[name="Pizza[TamanhoAdicional][]"]').val();

            $('#modal-adicional').attr('card-selecionado', card_id);

            $('.modal-list-adicional').empty();

            $.ajax({
                type: 'POST',
                url: ajaxGetArrayTamanhoAdicional,
                data: {
                    'tamanho': tamanho_id,
                },
                complete: function(jqXHR, textStatus)
                {
                    var jsonData = eval('(' + jqXHR.responseText + ')');

                    $(setAdicionaisModal(jsonData.arrayTamanhoAdicional)).ready(function()
                    {
                        if (select != null)
                            setItemAdicionalModal(select);
                    });
                }
            });

        }
    });

    $('#EnderecoPedido_bairro').change(function() {
        if ($(this).val() == '') {
            $('#EnderecoPedido_endereco').hide();
            return false;
        }

        $('#load_endereco').show();

        bairro = $(this).val();

        $.ajax({
            type: 'POST',
            url: ajaxGetArrayEndereco,
            data: {
                'bairro': bairro,
            },
            complete: function(jqXHR, textStatus)
            {
                var jsonData = eval('(' + jqXHR.responseText + ')');

                $('#load_endereco').hide();

                $('#EnderecoPedido_endereco').empty()
                        .prepend('<option value="">Selecione o endereço</option>')
                        .show();

                $.each(jsonData, function(index, value) {
                    $('#EnderecoPedido_endereco').append('<option value="' + value.id + '" data-bairro="' + value.bairro + '" data-frete="' + value.frete + '">' + value.local + '</option>')
                });

            }
        });
    });

    $('#EnderecoPedido_endereco').change(function() {
        if ($(this).val() == '') {
            return false;
        }

        $('[data-src]').each(function() {
            $(this).attr('src', $(this).attr('data-src'));
            $(this).removeAttr('data-src');
        });

        option = $('#EnderecoPedido_endereco option:selected');

        $('.resumo-taxa-frete span').text(converterParaReal(option.attr('data-frete')));
        $('[name="Pedido[bairro]"], [name="Cliente[bairro]"]').val(option.attr('data-bairro'));
        $('[name="Pedido[endereco]"], [name="Cliente[endereco]"]').val(option.text());
        $('#Cliente__endereco_id, #Pedido__endereco_id').val($(this).val());

        $(".bg-pedido").hide();
    });

    $('[name="Pizza[TamanhoBorda]"], [name="Pizza[TamanhoTipoMassa]"]').live({
        change: function() {
            card = $(this).parents('.card-pizza');
            calculaPizza(card);
            calculaSubTotal();
        }
    });

    $("#confirmar_adicional").click(function()
    {
        card_id = $('#modal-adicional').attr('card-selecionado');
        card = $('[card-id="' + card_id + '"]');

        if ($('.item-adicional-modal.selected').length > 0) {
            setAdicionaisSelecionados(card);
            message = "Os adicionais foram adicionados com sucesso!";
        } else {
            resetAdicionaisSelecionados(card);
            message = "Os adicionais foram removidos com sucesso!";
        }

        setValorAdicional(card);
        calculaPizza(card);
        calculaSubTotal();

        jQuery().toastmessage('showToast', {
            text: message,
            type: 'success',
            sticky: false
        });
    });

    $("#confirmar_sabor").click(function() {
        card_id = $('#modal-sabores').attr('card-selecionado');
        card = $('[card-id="' + card_id + '"]');

        if ($('.item-sabor-modal.selected').length > 0) {
            $('.btn_add_adicional').show();
            message = "Os sabores foram adicionados com sucesso!";
            setThumbsSabores(card);
            setThumbsAdicionais(card);
            setValorSabor(card);
        } else {
            $('.btn_add_adicional').hide();
            message = "Os sabores foram removidos com sucesso!";
            resetSabores(card);
            resetValor(card);
        }

        setInfoPizzaCard(card);
        calculaPizza(card);
        calculaSubTotal();

        jQuery().toastmessage('showToast', {
            text: message,
            type: 'success',
            sticky: false
        });
    });

    $("#confirmar_itemcombinado").click(function() {
        card_id = $('#modal-itemcombinado').attr('card-selecionado');
        card = $('[card-id="' + card_id + '"]');

        if ($('.item-itemcombinado-modal.selected').length > 0) {
            message = "Os itens do combinado foram adicionados com sucesso!";
            setThumbsItemCombinado(card);            
            setValorCombinado(card);
        } else {
            $('.btn_add_adicional').hide();
            message = "Os itens do combinado foram removidos com sucesso!";
            resetItemCombinado(card);
            resetValor(card);
        }

        calculaSubTotal();

        jQuery().toastmessage('showToast', {
            text: message,
            type: 'success',
            sticky: false
        });
    });

    $("[name='Pizza[tamanho]']").live({
        change: function() {
            tamanho_id = $(this).val();
            card = $(this).parents('.card-pizza');

            resetCard(card);
            setInfoTamanhoCard(card);

            $.ajax({
                type: 'POST',
                url: ajaxGetArrayPizza,
                data: {
                    'tamanho': tamanho_id,
                },
                complete: function(jqXHR, textStatus) {
                    var jsonData = eval('(' + jqXHR.responseText + ')');

                    card.attr('qtd-sabor-max', jsonData.max_qtd_sabor);

                    TamanhoBorda = getHtmlOptionBordaTipoMassa(jsonData.arrayTamanhoBorda, 'Sem borda');
                    TamanhoTipoMassa = getHtmlOptionBordaTipoMassa(jsonData.arrayTamanhoTipoMassa, 'Massa comum');

                    card.find('[name="Pizza[TamanhoBorda]"]').html(TamanhoBorda);
                    card.find('[name="Pizza[TamanhoTipoMassa]"]').html(TamanhoTipoMassa);
                }
            });
        }});

    $("[name='Pizza[TipoSabor]']").live({
        change: function() {
            card = $(this).parents('.card-pizza');
            resetCard(card);
        }
    });

    getHtmlOptionBordaTipoMassa = function(array, empty) {
        itens = '<option value>' + empty + '</option>';
        $.each(array, function(index, value) {
            itens += "<option preco='" + value['preco'] + "' value='" + index + "'>" + value['descricao'] + " (" + converterParaReal(value['preco']) + ")</option>";
        });
        return itens;
    }

    $('[name="ItemCombinadoPedido[quantidade]"]').live({
        keyup: function(e) {
            if($(this).val() == '' || $(this).val() == 0) {
                $(this).parents('.item-itemcombinado-modal').removeClass('selected');
            } else {
                $(this).parents('.item-itemcombinado-modal').addClass('selected');
            }
        }
    });

    $('[name="Pedido[combinado_id]"]').live({
        change: function(){
            card = $(this).parents('.card-combinado');

            if(!card.find('.list-itemcombinado').hasClass('vazio')) {
                resetItemCombinado(card);
                resetValor(card);

                calculaSubTotal();                
            }
        }
    });

    $('.btn_escolher_itemcombinado').live({
        click: function() {
            $('#message-combinado').hide();
            $('#message-combinado p').empty();
            $('#modal-itemcombinado .modal-list-itemcombinado').empty();
            $('#modal-itemcombinado .modal-list-itemcombinado').prepend('<span id="loading">Carregando...</span>');
            
            card = $(this).parents('.card-combinado');
            combinado = card.find('[name="Pedido[combinado_id]"]').val();

            card_id = card.attr('card-id');

            $.ajax({
                type: 'POST',
                url: ajaxGetItemCombinado,
                data: {'combinado': combinado},
                complete: function(jqXHR, textStatus) {

                    var jsonData = eval('(' + jqXHR.responseText + ')');
                    $('#modal-itemcombinado').attr('card-selecionado', card_id);
                    $('#modal-itemcombinado').attr('preco',0);

                    setItemCombinadoModal(jsonData.item_combinados);

                    if(jsonData.combinado != ''){
                        $('#modal-itemcombinado').attr('preco',jsonData.combinado.preco);
                        $('#message-combinado p').html("<b>"+jsonData.combinado.nome+" ("+converterParaReal(jsonData.combinado.preco)+") :</b><br/> "+jsonData.combinado.descricao);
                        $('#message-combinado').show();
                        $('.modal_preco_itemcombinado').text('R$ 0,00');
                    }
                }
            });
        }
    });

    $('.btn_escolher_sabor').live({
        click: function() {
            $('#modal-sabores .modal-list-sabores').empty();
            $('#modal-sabores .modal-list-sabores').prepend('<span id="loading">Carregando...</span>');
            card = $(this).parents('.card-pizza');
            tamanho_id = card.find('[name="Pizza[tamanho]"]').val();
            tipo_pizza = card.find('[name="Pizza[TipoSabor]"]').val();
            card_id = card.attr('card-id');

            $.ajax({
                type: 'POST',
                url: ajaxGetTamanhoSabor,
                data: {'tamanho_id': tamanho_id, 'tipo_pizza': tipo_pizza},
                complete: function(jqXHR, textStatus) {
                    var jsonData = eval('(' + jqXHR.responseText + ')');
                    $('#modal-sabores').attr('card-selecionado', card_id);
                    setSaboresModal(jsonData.sabores);
                }
            });
        }
    });

    $('.item-sabor-modal .thumbnail').live('click', function() {
        $(this).parents('.item-sabor-modal').find('.btn:visible').click();
    });

    $('.add-sabor, .del-sabor').live({
        click: function() {
            card_id = $('#modal-sabores').attr('card-selecionado');
            if ($(this).hasClass('add-sabor') && !validaAddSabor($('[card-id="' + card_id + '"]'))) {
                jQuery().toastmessage('showToast', {
                    text: 'Não é permitido dividir mais os sabores.',
                    type: 'error',
                    sticky: false
                });
                return false;
            }

            $(this).hide();

            if ($(this).hasClass('add-sabor')) {
                $(this).parent('div').children('.del-sabor').show();
            } else {
                $(this).parent('div').children('.add-sabor').show();
            }
            $(this).parents('.item-sabor-modal').toggleClass('selected');
        }
    });

    $('.add-adicional, .del-adicional').live({
        click: function() {
            $(this).hide();

            if ($(this).hasClass('add-adicional')) {
                $(this).parent('div').children('.del-adicional').show();
            } else {
                $(this).parent('div').children('.add-adicional').show();
            }
            $(this).parents('.item-adicional-modal').toggleClass('selected');
        }
    });

    $('.btn_add_pizza').click(function() {

        if (validAddNewCard()) {
            newCard();
        } else {
            jQuery().toastmessage('showToast', {
                text: 'Existe uma pizza ainda pendente.',
                type: 'error',
                sticky: false
            });
        }
    });

    $('.btn_add_combinado').click(function() {

        if (validAddNewCombinado()) {
            newCardCombinado();
        } else {
            jQuery().toastmessage('showToast', {
                text: 'Existe um combinado ainda pendente.',
                type: 'error',
                sticky: false
            });
        }
    });

    $('.nav-tabs a').click(function() {
        aba = $(this).attr('href');
        if (!validaUltimoPasso(aba)) {
            return false;
        }

        setResumoGeral();
    });

    // Funcionalidades da aba "Bebidas  e pratos-lanche"

    $('[name="Produtos[quantidade]"]').change(function(e) {
        e.preventDefault();
        if ($(this).val() != '')
            $(this).parents('.item-produto').addClass('selecionado');
        else
            $(this).parents('.item-produto').removeClass('selecionado');

        calculaSubTotal();
    });

    setResumoGeral = function()
    {
        setResumoProduto();
        setResumoCombinado();
        setResumoPizza();
        setResumoPromocao();

        frete = converterParaFloat($('.resumo-taxa-frete span').text());
        subtotal = converterParaFloat($('#sub-total-geral').text());
        total = subtotal + frete;

        $('.resumo-sub-total span').text(converterParaReal(subtotal));
        $('.resumo-total span, #valor_total').text(converterParaReal(total));
    }


    validaUltimoPasso = function(aba) {
        ultima_aba = $('#sistema-pedido .nav-tabs li:last-child a').attr('href');
        if (aba == ultima_aba)
        {
            if (!validAddNewCard())
            {
                card = $('.list-sabores:empty').parents('.card-pizza');
                resetCard(card);
            }

            if (valorMinimo > converterParaFloat($('#sub-total-geral').text()))
            {
                jQuery().toastmessage('showToast', {
                    text: "O valor mínimo para finalizar o pedido é de: " + $('#valor-min').text(),
                    type: 'error',
                    sticky: false,
                    stayTime: 2000,
                });
                return false;
            }
        }

        return true;
    }

    newCard = function() {
        numero_card = parseInt($('.card-pizza').length) + 1;

        card = $(".card-pizza:last-child").clone();
        card.attr('card-id', numero_card);
        card.find('.numero_pizza').text(numero_card);

        card.find('.tipo_pizza').empty();

        $('#list-card-pizza').append(card);
        card.find("[name='Pizza[tamanho]']").change();
    }

    newCardCombinado = function() {
        numero_card = parseInt($('.card-combinado').length) + 1;

        card = $(".card-combinado:first-child").clone();
        card.attr('card-id', numero_card);
        card.find('.numero_combinado').text(numero_card);

        $('#list-card-combinado').append(card);

        resetItemCombinado(card);
        resetValor(card);
    }

    setResumoCombinado = function() {
        $('#list-itens-modelo [resumo-combinado-id]').remove();

        $.each($('.card-combinado'), function() {

            if(!$(this).find('.list-itemcombinado').hasClass('vazio')) {

                item = $('#modelo-resumo-combinado').clone();

                itens = "";
                $.each($(this).find('.thumb-itemcombinado'),function(){
                   itens += "<li><small>"+$(this).find('.quantidade_itemcombinado').val()+" : "+$(this).find('.nome_itemcombinado').text()+"</small></li>";
                });

                item.find('ul').html(itens);

                item.find('.resumo_item').text("Combinado: "+$(this).find('option:selected').text());
                item.find('.resumo_preco').text(converterParaReal($(this).find('.list-itemcombinado').attr('preco')));

                item.attr('resumo-combinado-id',$(this).attr('card-id')).show();

                $("#list-itens-modelo").prepend(item);
            }

        });
    }

    setResumoProduto = function() {
        $('#list-itens-modelo [resumo-produto-id]').remove();

        $.each($('.item-produto.selecionado'), function() {
            id = $(this).attr('produto-id');
            qtd = $(this).find('select').val();
            preco = converterParaFloat($(this).find('.preco-produto').text());
            nome = $(this).find('h4').text();
            peso = $(this).find('.peso').text();
            total = preco * qtd;

            item = $('#modelo-resumo-produto').clone();
            item.find('.qtd_item').text(qtd);
            item.find('.resumo_item').text(nome);
            item.find('.resumo-peso').text(peso);
            item.find('.resumo_preco').text(converterParaReal(total));
            item.attr('resumo-produto-id', id)
                    .show();

            $("#list-itens-modelo").prepend(item);
        });
    }

    setResumoPromocao = function() {

        $('#list-itens-modelo [resumo-promocao-id]').remove();

        if ($('#Pedido_promocao_vazio:checked').length > 0)
            return true;

        promocao = $('[name="Promocao[id]"]:checked');

        $.each(promocao, function(index, value)
        {
            card = $(this).parents('.item-promocao');
            id = $(this).val();

            var nome = '';

            $.each(card.find('.cmp-item-promocao'),function(index,value){

                qtd = $(this).find('input').val();

                if(qtd > 0){
                    if (index > 0)
                        nome += ", ";

                    nome += qtd+" "+$(this).find('select option:selected').text();                    
                }
            });

            descricao = card.find('.info-promocao').text();
            preco = card.attr('valor');

            item = $('#modelo-resumo-promocao').clone();
            item.find('.resumo_item').text("Promoção: " + nome);
            item.find('.resumo-peso').text(descricao);
            item.find('.resumo_preco').text(converterParaReal(preco));
            item.attr('resumo-promocao-id', id).show();

            $("#list-itens-modelo").prepend(item);
        });
    }

    setResumoPizza = function() {
        $('#list-itens-modelo [resumo-pizza-id]').remove();
        cards = $('.thumb-sabor').parents('.card-pizza');
        $.each(cards, function() {
            setItemResumoSabor($(this));
            setItemResumoBorda($(this));
            setItemResumoTipoMassa($(this));
            setItemResumoValor($(this));
            setItemResumoAdicional($(this));
        });
    }

    setItemResumoAdicional = function(card)
    {
        adicionais = card.find('[name="Pizza[TamanhoAdicional][]"]').children('option:selected');

        des_adicional = "Adicionais: ";
        $.each(adicionais, function(index, value) {
            console.log($(this));
            if (index > 0)
                des_adicional += ", ";

            des_adicional += $(this).text();
        });

        $('[resumo-pizza-id="' + id + '"]').find('.adicional').text(des_adicional);
    }

    setItemResumoBorda = function(card) {
        id = card.attr('card-id');
        borda = card.find('[name="Pizza[TamanhoBorda]"]').children('option:selected').text();
        $('[resumo-pizza-id="' + id + '"]').find('.borda').text("Borda: " + borda);
    }

    setItemResumoTipoMassa = function(card) {
        id = card.attr('card-id');
        tipoMassa = card.find('[name="Pizza[TamanhoTipoMassa]"]').children('option:selected').text();
        $('[resumo-pizza-id="' + id + '"]').find('.tipo_massa').text("Tipo da massa: " + tipoMassa);
    }

    setItemResumoValor = function(card) {
        id = card.attr('card-id');
        valor = card.find('.preco_pizza').text();
        $('[resumo-pizza-id="' + id + '"]').find('.resumo_preco').text(valor);
    }

    setItemResumoSabor = function(card) {
        id = card.attr('card-id');
        tamanho = card.find('.tamanho_pizza').text();
        tipo_pizza = card.find('.tipo_pizza').text();
        nome_item = tamanho + " " + tipo_pizza;
        des_sabor = "Sabores: ";

        sabores = card.find('.thumb-sabor');
        $.each(sabores, function(index, value) {
            if (index > 0)
                des_sabor += ", ";

            des_sabor += $(this).find('.nome_sabor').text();

        });

        item = $('[resumo-pizza-id="' + id + '"]');
        if (item.length == 0) {
            item = $('#modelo-resumo-pizza').clone();
        }

        item.find('.resumo_item').text(nome_item);
        item.find('.resumo-list-sabores').text(des_sabor);

        item.attr('resumo-pizza-id', id)
                .show();

        $("#list-itens-modelo").prepend(item);
    }

    setInfoTamanhoCard = function(card) {
        tamanho = card.find('[name="Pizza[tamanho]"]').children('option:selected').text();
        card.find('.tamanho_pizza').text(tamanho);
    }

    setInfoPizzaCard = function(card) {

        nome_estilo_pizza = new Array();
        nome_estilo_pizza[1] = 'Inteira';
        nome_estilo_pizza[2] = 'Meio a meio';
        nome_estilo_pizza[3] = 'Dividída em três';
        nome_estilo_pizza[4] = 'Dividída em quatro';

        estiloPizza = card.find('.thumb-sabor').length;
        text = estiloPizza > 0 ? "(" + nome_estilo_pizza[estiloPizza] + ")" : "";

        card.find('.tipo_pizza').text(text);
    }

    setItemAdicionalModal = function(select)
    {
        $.each(select, function(index, value)
        {
            item = $('#' + value + '.item-adicional-modal');
            item.addClass('selected');
            item.find('.add-adicional').hide();
            item.find('.del-adicional').show();
        });
    }

    setValorAdicional = function(card)
    {
        adicionais = card.find('[name="Pizza[TamanhoAdicional][]"]').children('option:selected');
        valor = 0;

        $.each(adicionais, function() {
            valor = valor + parseFloat($(this).attr('preco'));
        });

        card.find('.list-sabores').attr('total-adicionais', valor);
    }

    setAdicionaisModal = function(items)
    {
        html = '';
        $('.modal-list-adicional').empty();

        $.each(items, function(index, value)
        {
            item = $('#item-modal-adicional-modelo').clone();
            item.attr('id', index).show();

            urlImageSabor = urlImage + '/adicionais/' + value['foto'];

            item.find('.thumbnail img').attr('src', urlImageSabor);
            item.find('.nome_adicional').text(value['descricao']);
            item.find('.modal_preco_adicional').text(converterParaReal(value['preco']));

            $('.modal-list-adicional').append(item);
        });
    }

    setItemCombinadoModal = function(items) {
        html = '';
        $('.modal-list-itemcombinado').empty();
        $.each(items, function(index, value) {
            item = $('#item-modal-itemcombinado-modelo').clone();
            item.attr('id', value['id']).show();

            if (value['foto'] == null)
                value['foto'] = 'no-image.jpg';

            urlImageItemCombinado = urlImage + '/produtos/' + value['foto'];

            item.find('.thumbnail img').attr('src', urlImageItemCombinado);
            item.find('.nome_itemcombinado').text(value['nome']);
            item.find('.descricao_itemcombinado').text(value['descricao']);
            item.find('.modal_preco_itemcombinado').text(converterParaReal(value['preco']));

            $('.modal-list-itemcombinado').append(item);
        });
    }

    setSaboresModal = function(items) {
        html = '';
        $('.modal-list-sabores').empty();
        $.each(items, function(index, value) {
            item = $('#item-modal-sabor-modelo').clone();
            item.attr('id', value['sabor_id']).show();

            if (value['foto'] == null)
                value['foto'] = 'no-image.jpg';

            urlImageSabor = urlImage + '/sabores/' + value['foto'];

            item.find('.thumbnail img').attr('src', urlImageSabor);
            item.find('.nome_sabor').text(value['descricao']);
            item.find('.ingredientes').text(value['ingredientes']);
            item.find('.modal_preco_sabor').text(converterParaReal(value['preco']));

            $('.modal-list-sabores').append(item);
        });
    }

    setAdicionaisSelecionados = function(card) {
        val = '';
        card.find('[name="Pizza[TamanhoAdicional][]"]').val(0);

        $.each($('.item-adicional-modal.selected'), function(index, value) {
            id = $(this).attr('id');
            card.find('option[value="' + id + '"]').attr('selected', true);
        });
    }

    resetAdicionaisSelecionados = function(card) {
        card.find('[name="Pizza[TamanhoAdicional][]"]').val(0);
        card.children('input').val('');
    }

    setThumbsAdicionais = function(card) {
        tamanho_id = card.find('[name="Pizza[tamanho]"]').val();

        $.ajax({
            type: 'POST',
            url: ajaxGetArrayTamanhoAdicional,
            data: {
                'tamanho': tamanho_id,
            },
            complete: function(jqXHR, textStatus) {
                var jsonData = eval('(' + jqXHR.responseText + ')');

                TamanhoAdicional = getHtmlOptionBordaTipoMassa(jsonData.arrayTamanhoAdicional, 'Sem adicional');
                card.find('[name="Pizza[TamanhoAdicional][]"]').html(TamanhoAdicional);
            }
        });
    }

    setThumbsItemCombinado = function(card) {

        html = '';
        listcombinado = card.find('.list-itemcombinado');

        listcombinado.empty();

        $.each($('.item-itemcombinado-modal.selected'), function(index, value) {
            id = $(this).attr('id');
            nome = $(this).find('.nome_itemcombinado').text();
            quantidade = parseInt($(this).find('[name="ItemCombinadoPedido[quantidade]"]').val());

            urlImagem = $(this).find('img').attr('src');

            itemcombinado = $('#modelo-thumb-itemcombinado').clone();
            
            itemcombinado.attr('id', id).show();
            itemcombinado.find('img').attr('src', urlImagem);
            itemcombinado.find('.nome_itemcombinado').text(nome);
            itemcombinado.find('.quantidade_itemcombinado').val(quantidade);

            listcombinado.append(itemcombinado);
        });

        listcombinado.removeClass('vazio');
    }

    setThumbsSabores = function(card) {

        html = '';
        listsabores = card.find('.list-sabores');

        listsabores.empty();

        $.each($('.item-sabor-modal.selected'), function(index, value) {
            id = $(this).attr('id');
            descricao = $(this).find('.nome_sabor').text();
            urlImagem = $(this).find('img').attr('src');

            sabor = $('#modelo-thumb-sabor').clone();
            sabor.attr('id', id).show();
            sabor.find('img').attr('src', urlImagem);
            sabor.find('.nome_sabor').text(descricao);

            listsabores.append(sabor);
        });

        listsabores.removeClass('vazio');
    }

    validAddNewCard = function() {
        valid = true;

        if ($('.list-sabores:empty').length > 0)
            valid = false;

        return valid;
    }

    validAddNewCombinado = function() {
        valid = true;

        if ($('.list-itemcombinado:empty').length > 0)
            valid = false;

        return valid;
    }

    validaAddSabor = function(card) {
        max_qtd_sabor = card.attr('qtd-sabor-max');
        qtd_sabor = $('.item-sabor-modal.selected').length;
        return (qtd_sabor < max_qtd_sabor) ? true : false;
    }

    resetCard = function(card) {
        resetBordaTipoMassa(card);
        resetSabores(card);
        resetValor(card);
        resetAdicionais(card);
    }

    resetBordaTipoMassa = function(card) {
        card.find('[name="Pizza[TamanhoBorda]"]').val(0);
        card.find('[name="Pizza[TamanhoTipoMassa]"]').val(0);
    }

    resetItemCombinado = function(card) {
        card.find('.list-itemcombinado').attr('preco', 0).addClass('vazio').empty();
    }

    resetSabores = function(card) {
        card.find('.list-sabores').attr('preco', 0).attr('total-adicionais', 0).empty();
    }

    resetAdicionais = function(card) {
        card.find('.btn_add_adicional').hide();
        card.find('#Pizza_TamanhoAdicional').val(0);
    }

    resetValor = function(card) {
        card.find('.preco_pizza,.preco_combinado').text('R$ 0,00');
        calculaSubTotal();
    }

    setValorCombinado = function(card) {
        valor = 0;

        if($('#modal-itemcombinado').attr('preco') == '0'){

            $.each($('.item-itemcombinado-modal.selected'), function() {
                qtd = $(this).find('[name="ItemCombinadoPedido[quantidade]"]').val();

                if($.isNumeric(qtd)){
                    valor += converterParaFloat($(this).find('.modal_preco_itemcombinado').text()) * parseInt(qtd);            
                }
            });
        }
        else
            valor = $('#modal-itemcombinado').attr('preco');

        card.find('.list-itemcombinado').attr('preco', valor);
        card.find('.preco_combinado').text(converterParaReal(valor));
    }

    setValorSabor = function(card) {
        maior_valor = 0;
        $.each($('.item-sabor-modal.selected .modal_preco_sabor'), function() {
            valor = converterParaFloat($(this).text());
            maior_valor = valor > maior_valor ? valor : maior_valor;
        });

        card.find('.list-sabores').attr('preco', maior_valor).attr('total-adicionais', 0);
    }

    calculaSubTotal = function() {
        valor = calculaProdutos() + calculaPizzas() + calculaPromocao() + calculaCombinados();
        $('#sub-total-geral').text(converterParaReal(valor));
    }

    calculaPizza = function(card) {
        borda = card.find('[name="Pizza[TamanhoBorda]"]').children('option:selected').attr('preco');
        tipoMassa = card.find('[name="Pizza[TamanhoTipoMassa]"]').children('option:selected').attr('preco');
        sabores = card.find('.list-sabores').attr('preco');
        adicionais = card.find('.list-sabores').attr('total-adicionais');

        if (borda == undefined)
            borda = 0;

        if (tipoMassa == undefined)
            tipoMassa = 0;

        if (adicionais == "")
            adicionais = 0;

        total = parseFloat(borda) + parseFloat(tipoMassa) + parseFloat(sabores) + parseFloat(adicionais);
        card.find('.preco_pizza').text(converterParaReal(total));
    }

    calculaCombinados = function() {
        valor = 0;
        $.each($('.preco_combinado'), function() {
            valor = converterParaFloat($(this).text()) + valor;
        });

        return valor;
    }

    calculaPizzas = function() {
        valor = 0;
        $.each($('.preco_pizza'), function() {
            valor = converterParaFloat($(this).text()) + valor;
        });

        return valor;
    }

    calculaProdutos = function() {
        valor = 0;
        $.each($('.item-produto.selecionado'), function() {
            valor = (converterParaFloat($(this).find('.preco-produto').text()) * $(this).find('select').val()) + valor;
        });
        return valor;
    };

    calculaPromocao = function() {
        valor = 0;

        if ($('[name="Promocao[id]"]:checked').length < 1)
            return valor;

        promocoes = $('[name="Promocao[id]"]:checked');

        $.each(promocoes, function(index, value) {
            valor_item = $(this).parents('.item-promocao').attr('valor');
            valor += parseFloat(valor_item);
        });

        return valor;

    };

    converterParaFloat = function(valor) {
        if (valor == null || valor == '')
            return 0;

        valor = valor.replace('R$', '');
        valor = valor.replace(/\./g, '');
        valor = valor.replace(',', '.');
        return parseFloat(valor);
    }

    converterParaReal = function(valor) {
        valor = parseFloat(valor);
        valor = valor.toFixed(2);
        valor = valor.replace('.', ',');
        return "R$ " + valor;
    }

    $('#confirmar-pedido').click(function() {
        if (!validaPedido())
            return false;

        $(this).attr('disabled', true).text('Enviando pedido...');

        arrayPizza = getArrayPizza();
        arrayCombinado = getArrayCombinado();
        arrayProduto = getArrayProduto();
        arrayPedido = getArrayPedido();
        arrayPromocao = getArrayPromocao(),

                $.ajax({
                    type: 'POST',
                    url: ajaxSavePedido,
                    data: {
                        'arrayPizza': arrayPizza,
                        'arrayProduto': arrayProduto,
                        'arrayPromocao': arrayPromocao,
                        'arrayCombinado': arrayCombinado,
                        'arrayPedido': arrayPedido
                    },
                    complete: function(jqXHR, textStatus) {
                        var jsonData = eval('(' + jqXHR.responseText + ')');
                        jQuery().toastmessage('showToast', {
                            text: "Seu pedido foi enviado com sucesso, entraremos em contato em instantes.",
                            type: 'success',
                            sticky: false
                        });
                        
                        //window.location.href = visualizarPedido + '/codigo/' + jsonData;
                    }
                });
    });

    $('#button').toggle(
            function() {
                $('body > .container').animate({left: 250}, 'slow', function() {
                    $('#button').html('Close');
                });
            },
            function() {
                $('body > .container').animate({left: 0}, 'slow', function() {
                    $('#button').html('Menu');
                });
            }
    );

    getArrayPedido = function() {
        pedido = {
            "valor_pago": converterParaFloat($('#Pedido_troco:visible').val()),
            "forma_pagamento_id": $('#Pedido_forma_pagamento_id').val(),
            "responsavel": $('#Pedido_responsavel').val(),
            "telefone": $('#Pedido_telefone').val(),
            "complemento": $('#Pedido_complemento').val(),
            "numero": $('#Pedido_numero').val(),
            "cep": $('#Pedido_cep').val(),
            "_endereco_id": $('#Pedido__endereco_id').val(),
            "observacao": $('#Pedido_observacao').val()
        }

        return pedido;
    }

    getArrayPromocao = function()
    {
        if ($('#Pedido_promocao_vazio:checked').length > 0)
            return null;

        promocoes = [];

        $.each($('.cmp-item-promocao'),function(){

            qtd = $(this).find('input').val();

            if(parseInt(qtd) > 0 && !$(this).find('select').is(':disabled')) {
                promocao = {"item_promocao": $(this).find('select').val(), "quantidade": qtd}
                promocoes.push(promocao);
            }

        });

        return promocoes;
    }

    getArrayProduto = function() {

        produtos = [];
        card = $('.item-produto.selecionado');

        $.each(card, function() {
            id = $(this).attr('produto-id');
            quantidade = $(this).find('[name="Produtos[quantidade]"]').val();

            item_produto = {"produto_id": id, "quantidade": quantidade}

            produtos.push(item_produto);
        });

        return produtos;
    }

    getArrayCombinado = function() {

        combinados = [];

        $.each($('.card-combinado'), function() {

            itens = [];
            $.each($(this).find('.thumb-itemcombinado'), function() {
                itens.push({"produto_id" : $(this).attr('id'), "quantidade": $(this).find('.quantidade_itemcombinado').val()});
            });

            if(itens != '') {

                combinado = {
                    "combinado_id": $(this).find('[name="Pedido[combinado_id]"]').val(),
                    "itens_combinado": itens,
                    "preco":0
                }

                combinados.push(combinado);
            }
        });

        return combinados;
    }

    getArrayPizza = function() {

        pizzas = [];
        card = $('.thumb-sabor').parents('.card-pizza');

        $.each(card, function() {

            sabores = [];
            $.each($(this).find('.thumb-sabor'), function() {
                sabores.push($(this).attr('id'));
            });

            adicionais = [];
            $.each($(this).find('[name="Pizza[TamanhoAdicional][]"]').children('option:selected'), function() {
                adicionais.push($(this).attr('value'));
            });

            item_pizza = {
                "tamanho_id": $(this).find('[name="Pizza[tamanho]"]').val(),
                "tamanho_borda_id": $(this).find('[name="Pizza[TamanhoBorda]"]').val(),
                "tamanho_tipo_massa_id": $(this).find('[name="Pizza[TamanhoTipoMassa]"]').val(),
                "sabores": sabores,
                "adicionais": adicionais,
                "preco_total": 0,
            }

            pizzas.push(item_pizza);
        });

        return pizzas;
    }

    showEnderecoPedido = function(array, text) {
        $('#alert-nao-cadastrar').hide();

        $("#alert-sucesso-endereco strong").text(text);
        $('#alert-sucesso-endereco').show();

        $('[href="#aba-pedido"]').click();

        $('#form-pedido [name="Pedido[responsavel]"]').val(array["responsavel"]);
        $('#form-pedido [name="Pedido[telefone]"]').val(array["telefone"]);

        $('#form-pedido [name="Pedido[numero]"]').val(array["numero"]);
        $('#form-pedido [name="Pedido[cep]"]').val(array["cep"]);
        $('#form-pedido [name="Pedido[complemento]"]').val(array["complemento"]);
    }

    validaPedido = function() {
        $('#form-pedido input').blur();
        subtotal = converterParaFloat($('.resumo-sub-total span').text());
        total = converterParaFloat($('.resumo-total span').text());
        validaCampos = $('#form-pedido span.error:visible').length > 0;

        if (total > valorMinimo && validaCampos == false) {
            return true;
        }

        return false;

    }

    $(".card-pizza [name='Pizza[tamanho]']").change();

    $("#Pedido_troco, [name='ItemCombinadoPedido[quantidade]']").live({
        keypress: function(event) {
            if (event.which < 48 || event.which > 57) {
                return false;
            }
        }
    });

    $("#Pedido_troco:visible").keyup(function() {
        valor = converterParaFloat($(this).val());
        valorTotal = converterParaFloat($(".resumo-total span").text());

        if (valor > valorTotal || valor == 0) {
            $(this).parent('div').removeClass('error');
        } else {
            $(this).parent('div').addClass('error');
        }
    });
});