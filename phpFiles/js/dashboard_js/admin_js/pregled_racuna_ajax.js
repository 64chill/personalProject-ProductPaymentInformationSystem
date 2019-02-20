var order_by_table = "racuni_id";
var sortParam = "ASC";
$(document).ready(function(){
  console.log("here");
  table_ajax(1);
});

function table_ajax(pageNum){
  $.ajax({
         type: "POST",
         url: "/dashboard/admin/pages/content/php_and_jsAjax/pregled_racuna_php.php",
         data: {formName: "racuni" , pagen: pageNum, orderby: order_by_table, sortP:sortParam},
         success: function(data){
            console.log(data);
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
                table_ajax(pageNum , -1);
            }); // $('.pagination li').click
            /********** table effect ******************************************/
          $('table tr').hover(function(){
            $(this).addClass('bg-teal');
          });
          $('table tr').mouseleave(function(){
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
            table_ajax(1 , -1);
          });
         },
         error: function(data){console.log(data);}
       });
}