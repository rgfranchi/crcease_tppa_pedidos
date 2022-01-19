function sumPedidos() {

    var valor_total = 0;
    var numberFormat = Intl.NumberFormat('pt-BR', {
        minimumFractionDigits:2
    })
    $('td.valor_unitario').each( function (i, obj) {
        var valor = reverseFormatNumber(obj.innerText, 'pt-BR');
        // var valor = parseFloat(obj.innerText.replace(",",".").replace(".",""));
        var qtd = parseInt($('input#item_id_'+obj.id).val());
        if(isNaN(qtd)) {
            qtd = 0;
        }
        valor_total += qtd * valor;
    });
    function reverseFormatNumber(val,locale){
        var group = new Intl.NumberFormat(locale).format(1111).replace(/1/g, '');
        var decimal = new Intl.NumberFormat(locale).format(1.1).replace(/1/g, '');
        var reversedVal = val.replace(new RegExp('\\' + group, 'g'), '');
        reversedVal = reversedVal.replace(new RegExp('\\' + decimal, 'g'), '.');
        return Number.isNaN(reversedVal)?0:reversedVal;
    }

    $('span#total_pedido').text(numberFormat.format(valor_total));
}

sumPedidos();