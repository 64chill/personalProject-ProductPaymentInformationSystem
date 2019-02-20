var order_by_table = "proizvodi_id";
var sortParam = "ASC";
$(document).ready(function(){
  table_ajax(1);
});
// FORM 1--------------------------------------------------------------------------
  $("#dodajProizvodForma").submit(function(e) {
    var form = $(this);
    var url = form.attr('action');
    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), // send for fields via name=value in post
           success: function(data)
           {
              $('#resultMsgAddProduct').html(data);
           }
         });
    e.preventDefault(); // avoid to execute the actual submit of the form.
});

/* *****************************************************************************
*   table_ajax()
** *****************************************************************************/
function table_ajax(pageNum){
  $.ajax({
         type: "POST",
         url: "/dashboard/admin/pages/content/php_and_jsAjax/pregled_proizvoda_php.php",
         data: {formName: "proizvodi" , pagen: pageNum, orderby: order_by_table, sortP:sortParam},
         success: function(data){
            $('#content-table-show').html(data);
            /********* pagination numbers *************************************/
            $('.pagination li').click(function(){
                if($(this).hasClass( "disabled" )){
                  return;
                }
                if ($(this).text()=="..."){
                  return;
                }
                var pageNum = $(this).find('a').text();

                if ($.trim(pageNum) == "chevron_right" || $.trim(pageNum) == "chevron_left"){
                  pageNum = $(this).closest('li').attr('id');
                }
                table_ajax(pageNum);
            }); // $('.pagination li').click
            /********** table effect ******************************************/
          $('table.table-striped tr').hover(function(){
            $(this).addClass('bg-teal');
          });
          $('table.table-striped tr').mouseleave(function(){
            $(this).removeClass('bg-teal');
          });
          /************************* sorting **********************************/
          $('#content-table-show table thead tr th').click(function(){
            if (order_by_table == $(this).attr('page-name') ){
              if(sortParam == "ASC"){
                sortParam = "DESC";
              } else {
                sortParam = "ASC";
              }
            } else {
              order_by_table = $(this).attr('page-name');
              sortParam = "ASC";
            }
            table_ajax(1);
          });
         },
         error: function(data){console.log(data);}
       });
}

$('#getXML').click(function(e){
  var win = window.open('/simpleFunctions/proizvodi_xml.php', '_blank');
  win.focus();
});
/*
  $.ajax({
         type: "POST",
         url: "/dashboard/admin/pages/content/php_and_jsAjax/pregled_proizvoda_php.php",
         data: {formName: "getXML" },
         success: function(data){
           var win = window.open('/temp/track1.mp3', '_blank');
           win.focus();
         },
         error: function(data){console.log(data);}
       });
});*/
