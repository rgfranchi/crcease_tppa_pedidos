$(document).ready(function () {
  $("input.money").inputmask("decimal", {
    alias: "numeric",
    groupSeparator: ".",
    autoGroup: true,
    digits: 2,
    radixPoint: ",",
    digitsOptional: false,
    allowMinus: false,
    rightAlign: false,
    // prefix: "R$ ",
    placeholder: "0.000,00",
  });

  $("button#backLink").click(function (event) {
    event.preventDefault();
    history.back(1);
  });

  $("a.delete").click(function () {
    return confirm("Excluir registro?");
  });

  $("a.delete_others").click(function () {
    var related = $(this).attr('related');
    let bool = confirm("Exclui registros relacionados ? (" + related + ")");
    if(bool) {
      return !confirm("Clique em CANCELAR para confirmar.")
    }
    return false;
  });

  $("a.deleteAll").click(function () {
    let bool = confirm("Excluir TODOS os Registros?");
    if(bool) {
      return !confirm("Clique em CANCELAR para confirmar.")
    }
    return false;
  });

});
