// Inclui barra de navegação superior.
$("div.scrollTopTable").parent().prepend('<div class="scrollTop" style="overflow-x: scroll;"> <div class="scrollTopInner" style="height: 1px;"></div></div>');
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
