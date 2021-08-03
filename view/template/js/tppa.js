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
});
