var order_by_table = "korisnik_id";
var sortParam = "ASC";
$(document).ready(function(){
  table_ajax(1);
});


// FORM 1--------------------------------------------------------------------------
  $("#dodajKorisnikaForma").submit(function(e) {
    var form = $(this);
    var url = form.attr('action');
    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), // send for fields via name=value in post
           success: function(data){
              $('#resultMsgAddUsr').html(data);
              table_ajax(1);
           }
         });
    e.preventDefault(); // avoid to execute the actual submit of the form.
});
/*********************************************************************************
/*********************************************************************************
/*********************************************************************************
/*********************************************************************************

// FORM 2--------------------------------------------------------------------------------------------------------------
var $usr_edit_id;
$(".btn.bg-orange:has(i)").click(function() {
    var $row = $(this).closest("tr");    // Find the row
    $usr_edit_id  = $row.find(".data-id").text(); // GET id
    var $usr_name = $row.find(".data-username").text(); // GET username
    $("#izmenaUsername").val($usr_name);

});
//submit------------------------------------------------
$("#izmenaKorisnikaForma").submit(function(e) {
  var form = $(this);
  var url = form.attr('action');
  $.ajax({
         type: "POST",
         url: url,
         data: form.serialize() + "&user_id=" + $usr_edit_id, //
         success: function(data){
            $('#resultMsgEditUsr').html(data);
         }
       });
  e.preventDefault(); // avoid to execute the actual submit of the form.
});
**********************************************************************************
**********************************************************************************
**********************************************************************************
**********************************************************************************
**********************************************************************************/




/* *****************************************************************************
*   table_ajax()
** *****************************************************************************/
function table_ajax(pageNum){
  $.ajax({
         type: "POST",
         url: "/dashboard/admin/pages/content/php_and_jsAjax/pregled_korisnika_php.php",
         data: {formName: "korisnici" , pagen: pageNum, orderby: order_by_table, sortP:sortParam},
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
                table_ajax(pageNum , -1);
            }); // $('.pagination li').click
            /********** table effect ******************************************/
          $('#content-table-show table tr').hover(function(){
            $(this).addClass('bg-teal');
          });
          $('table tr').mouseleave(function(){
            $(this).removeClass('bg-teal');
          });
          /************************* sorting **********************************/
          $('#content-table-show table thead tr th').click(function(){
            if(typeof $(this).attr('page-name') == 'undefined'){
              return;
            }
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
            table_ajax(pageNum);
          }); //$('#content-table-show table thead tr th').click(function(){ end;
            /*********************** DELETE USER **********************************/
          var usr_del_id;
          $(".btn.bg-red:has(i)").click(function() {
              var $row = $(this).closest("tr");    // Find the row
              usr_del_id  = $row.find(".data-id").text(); // GET id
              var usr_name = $row.find(".data-username").text(); // GET username
              console.log(usr_del_id);
              $("#obrisi_k_ime").html(usr_name);

          }); //  $(".btn.bg-red:has(i)").click(function() { END;
          // FORM 3-------------------------------------------------------------------------------------------------------------
            $("#izbrisiKorisnikaForma").submit(function(e) {
              e.preventDefault(); // avoid to execute the actual submit of the form.
              var form = $(this);
              var url = form.attr('action');
              $.ajax({
                     type: "POST",
                     url: url,
                     data: form.serialize() + "&user_id=" + usr_del_id, //
                     success: function(data)
                     {
                        $('#resultMsgDelUsr').html(data);
                        table_ajax(1);
                        setTimeout(function() {
                          $('#resultMsgDelUsr').html('');
                        }, 2000);
                     }
                   });
          }); // $("#izbrisiKorisnikaForma").submit(function(e) end;
        }, //success end;
         error: function(data){console.log(data);}
       });
}
