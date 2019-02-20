
// ajaxGetProductInfo-----------------------------------------------------------

function ajaxGetProductInfo(productCode){
  var final_result="";
 $.ajax({
        type: "POST",
        async: false,
        url:'/simpleFunctions/worker.ajax.php',
        data: {method: 'getProductInfo', code: productCode},
        success: function(data){
           final_result = data;
        }
      });
      return final_result;
}
//APPEND TEXT-------------------------------------------------------------------
function appendText() {
  $("#errorMsg").html("");
  var productCode = $("#input1").val();
  if(productCode.trim()=="" || productCode==null){
    $("#errorMsg").html("Polje je prazno!");return;
  }
  var btnDel = "<td class=\"btn_del_product\"><button type=\"button\" name=\"button\" class=\"btn bg-red\" onclick=\"deleteThisRow(this);\">Ukloni</button></td>";
  var productData = ajaxGetProductInfo(productCode);
  if(productData==-1){
    $("#errorMsg").html("Barkod nije validan");$("#input1").val("");return;
  }
  var writeInput = "<tr><td class=\"productCode\">" + productCode +productData+ "</td>"+btnDel+"</tr>";
  $("#product_list").append(writeInput);
  $("#input1").val("");
  /*
    var txt1 = "<p>Text.</p>";              // Create text with HTML
    var txt2 = $("<p></p>").text("Text.");  // Create text with jQuery
    var txt3 = document.createElement("p");
    txt3.innerHTML = "Text.";               // Create text with DOM
    $("body").append(txt1);     // Append new elements*/
} // end appendText
//izbrisi dodate elemente-------------------------------------------------------
$('table').on('click', 'td > button', function() {
       $(this).closest("tr").remove();
   });

//setInterval(function(){ $("#errorMsg").html(""); }, 3000); // da ukloni error poruku ako postoji

/* *****************************************************************************
*         NAPRAVI RACUN
***************************************************************************** */
function create_receipt_ajax(products_codes){
  $.ajax({
         type: "POST",
         url:'/simpleFunctions/worker.ajax.php',
         data: {method: 'setReceipt', codes: products_codes},
         success: function(data){
           $(".hiddenReceipt").show();
            $("#showReceipt > div > div > div.body").html(data);
         }
       });
}
$("#createReceipt").click(function(){
  $("#errorMsg").html("");
  if( !$('.productCode').length ){
    $("#errorMsg").html("Morate uneti barkod proizvoda prvo!");return;
  }
    var products_codes="";
      $(".productCode").each(function() {
          products_codes = products_codes + $(this).html() +","; // or this.val
      });
    create_receipt_ajax(products_codes);
    $("#product_list").html("");
});
$("#closeReceipt").click(function(){
  $(".hiddenReceipt").hide();
  $("#showReceipt > div > div > div.body").html("");
});
/*******************************************************************************
Dodaj sifru js
*******************************************************************************/
$("#input1").keyup(function(){
  var current_input_text =  $(this).val();

  if($.trim(current_input_text).length === 0 || isNaN(current_input_text) ){
    $("#live-search-suggestion").html("");
    return;
  }

  $("#live-search-suggestion").html(current_input_text);
      $.ajax({
               type: "POST",
               async: false,
               url:'/simpleFunctions/worker.ajax.php',
               data: {method: 'liveSearch', searchInput: current_input_text},
               success: function(data){
                  $("#live-search-suggestion").html(data);
               }
      });
    }); // end keyup

    $('#live-search-suggestion').on('click', 'ul > li > a', function() {
          $("#input1").val($(this).attr('id'));
          $("#live-search-suggestion").html("");
       });
