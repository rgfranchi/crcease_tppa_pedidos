
$("#sidebarToggle").click(function() {
    // console.log("teste");
    $.get('index.php?controller=Session&action=menu');
    // .done(function(data){
    //     console.log(data);
    // })
    // .fail(function(err){
    //     console.error(err.responseText);
    // });
});