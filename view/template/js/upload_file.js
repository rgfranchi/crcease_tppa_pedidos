document.getElementById("file_spreadsheet").onchange = function () {
  document.getElementById("file_form").submit();
};

$("a.column_delete").click(function () {
  // recebe da coluna.
  var th_element = $(this).parent();
  var column_id = th_element.attr("column_id");
  // localiza elementos da coluna para excluir
  $('td[column_id="' + column_id + '"]').each(function () {
    $(this).remove();
  });
  th_element.remove();
  topBarResize();
});

$("a.row_delete").click(function () {
  // recebe linha do elemento.
  var tr_element = $(this).parents("tr");
  tr_element.remove();
});

$("select.typeField").change(function () {
  var objSelect = $(this);
  var valueSelect = objSelect.val();

  $("select.typeField").each(function () {
    var currentObject = $(this);
    var currentValue = currentObject.val();
    if (currentValue == "null") {
      return;
    }
    if (currentObject.is(objSelect)) {
      console.log("SAME OBJECT");
      return;
    }
    if (currentValue == valueSelect) {
      alert("Campo já selecionado");
      objSelect.val("null").change();
    }
    console.log(currentObject, "other");
    console.log(valueSelect);
  });

  // recebe da coluna.
  //   var th_element = $(this).parent();
  //   var column_id = th_element.attr("column_id");
  //   // localiza elementos da coluna para excluir
  //   $('td[column_id="' + column_id + '"]').each(function () {
  //     $(this).remove();
  //   });
  //   th_element.remove();
});



  // Inclui barra de navegação superior.
  $("div.scrollTopTable").parent().prepend('<div class="scrollTop" style="overflow-x: scroll;"> <div class="scrollTopInner" style="height: 1px;"></div></div>');
  //
  $("button#sidebarToggle").click(topBarResize);

  // configura dimensões dos elementos.
  topBarResize();
  function topBarResize() {
    $("div.scrollTop").width($("div.scrollTopTable").width());
    $("div.scrollTopInner").width($("div.scrollTopTable").find("table").width());
  }
  // altera scroll inferior quando superior é alterado.
  $("div.scrollTop").scroll(function(){
    $("div.scrollTopTable").scrollLeft($("div.scrollTop").scrollLeft());
  });
  // altera scroll superior quando inferior é alterado.
  $("div.scrollTopTable").scroll(function(){
    $("div.scrollTop").scrollLeft($("div.scrollTopTable").scrollLeft());
  });

  