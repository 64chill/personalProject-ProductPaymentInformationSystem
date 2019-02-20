var ajax_url = "/dashboard/admin/pages/content/php_and_jsAjax/glavni_podaci_php.php";
/**************************************************************************
*     getIncomeChart
*******************************************************************************/

function getIncomeChart(in1, in2){
$.ajax({
       type: "POST",
       url: ajax_url,
       data: {method: "getIncomeChart", input1: in1, input2: in2},
       timeout:3000,
       dataType: "json",
       beforeSend: function(){
         $('#pre1').show();
       },
       complete: function(){
         $('#pre1').hide();
       },
       success: function(data){
         $('.dataTable').html('');
         /*************** create table with data ***************************/
         var salesTable = "<thead><tr><th>Vreme</th><th>Zarada</th></tr></thead><tbody>";
         for(var i = 0; i < data.length; i++) {
            salesTable += "<tr><td>" + data[i]['vreme'] + "</td><td>"+data[i]['zarada']+"" + "</td>";
          }
          salesTable += "</tbody>";
        $('#salesTable').html(salesTable);
         /**************** morris chart ***********************************/
            new Morris.Line({
               // ID of the element in which to draw the chart.
               element: 'chart1',
               // Chart data records -- each entry in this array corresponds to a point on
               // the chart.
               data: data ,
               // The name of the data record attribute that contains x-values.
               xkey: 'vreme',
               // A list of names of data record attributes that contain y-values.
               ykeys: ['zarada'],
               // Labels for the ykeys -- will be displayed when you hover over the
               // chart.
               labels: ['zarada'],
               parseTime: false
             }); //Morris.Line end;
      }, //success end;
      error: function(data){
        $('#chart1').html('<div class="bg-red">'+data.responseText+'</div>');
      }

    }); //ajax end;
  } //ajax1 end;
/*******************************************************************************
*     getSoldProductChart
*******************************************************************************/
  function getSoldProductChart(in1, in2){
    $.ajax({
           type: "POST",
           url: ajax_url,
           data: {method: "getSoldProductChart",input1: in1, input2: in2},
           timeout:3000,
           dataType: "json",
           beforeSend: function(){
             $('#pre2').show();
           },
           complete: function(){
             $('#pre2').hide();
           },
           success: function(data){
             /*****************create data 10 products *********************/
             var productTable = "<table class='table sortable'>";
             for(var i = 0; i < data.length; i++) {

                productTable += "<tr><td>" + data[i]['label'] + "</td><td>"+data[i]['value']+"" + "</td>";
              }
            productTable += "</table>";
            $('#productTable').html(productTable);
            /*************** create morris chart **************************/
             Morris.Donut({
                  element: 'chart2',
                  data: data
            }); //Morris.Donut end;
          }, //success end;
          error: function(data){
            $('#chart2').html('<div class="bg-red">'+data.responseText+'</div>');
          }
        }); //ajax end;

  }
/*******************************************************************************
*    FORM 1-
*******************************************************************************/
    $("#form1_graph").submit(function(e) {
      var inp1 = $("#form1input1").val();
      var inp2 = $("#form1input2").val();
      $("#chart1").html('');
      getIncomeChart(inp1, inp2);
      e.preventDefault(); // avoid to execute the actual submit of the form.
    });
/*******************************************************************************
*    FORM 2-
*******************************************************************************/
    $("#form2_graph").submit(function(e) {
      var inp1 = $("#form2input1").val();
      var inp2 = $("#form2input2").val();
      $("#chart2").html('');
      getSoldProductChart(inp1, inp2);
      e.preventDefault(); // avoid to execute the actual submit of the form.
    });
/*******************************************************************************
*    FORM 3-
*******************************************************************************/
      $("#form3_graph").submit(function(e) {
        $.ajax({
               type: "POST",
               url: ajax_url,
               data: $(this).serialize() + "&method=compareProductChart",//{method: "compareProductChart"},
               timeout:3000,
               dataType: "json",
               beforeSend: function(){
                 $('#chart3').html('');
                 $('#pre3').show();
               },
               complete: function(){
                 $('#pre3').hide();
               },
               success: function(data){
                 console.log(data);
                 Morris.Bar({
                  element: 'chart3',
                  data: data,
                  xkey: 'y',
                  ykeys: 'a',
                  labels: ' '
                   });//Morris.Bar( end
              }, //success end;
              error: function(data){
                $('#chart3').html('<div class="bg-red">'+data.responseText+'</div>');
              }
            }); //ajax end;
        e.preventDefault();
      }); //$("#form3_graph").submit(function(e) end;
/*******************************************************************************
Dodaj sifru js 1
*******************************************************************************/
      $("#sp1").keyup(function(){
        //alert(current_input_text.length > 3);
        //if(parseInt(current_input_text.length) > 3){return;}
        var current_input_text =  $(this).val();
        //if(parseInt(current_input_text.length) < 3){return;}
        if($.trim(current_input_text).length === 0 || isNaN(current_input_text) ){
          $("#live-search-suggestion1").html("");
          return;
        }
        $("#live-search-suggestion1").html(current_input_text);
            $.ajax({
                     type: "POST",
                     async: false,
                     url:'/simpleFunctions/worker.ajax.php',
                     data: {method: 'liveSearch', searchInput: current_input_text},
                     success: function(data){
                        $("#live-search-suggestion1").html(data);
                     }
            });
          }); // end keyup
          $('#live-search-suggestion1').on('click', 'ul > li > a', function() {
                $("#sp1").val($(this).attr('id'));
                $("#live-search-suggestion1").html("");
             });
/*******************************************************************************
Dodaj sifru js 2
*******************************************************************************/
     $("#sp2").keyup(function(){
        var current_input_text =  $(this).val();
        if($.trim(current_input_text).length === 0 || isNaN(current_input_text) ){
         $("#live-search-suggestion2").html("");
         return;
       }
       $("#live-search-suggestion2").html(current_input_text);
           $.ajax({
                    type: "POST",
                    async: false,
                    url:'/simpleFunctions/worker.ajax.php',
                    data: {method: 'liveSearch', searchInput: current_input_text},
                    success: function(data){
                         $("#live-search-suggestion2").html(data);
                    }
           });
         }); // end keyup
         $('#live-search-suggestion2').on('click', 'ul > li > a', function() {
               $("#sp2").val($(this).attr('id'));
               $("#live-search-suggestion2").html("");
            });
/*******************************************************************************
*    Remove Autocomplete suggestion when click outside OR on element
*******************************************************************************/
$('body').click(function(e){
  $('#live-search-suggestion1').html('');
  $('#live-search-suggestion2').html('');
});
/*******************************************************************************
*    $(document).ready(function()
*******************************************************************************/

$(document).ready(function(){
  $('#pre3').hide();
  getIncomeChart($("#form1input1").val(),$("#form1input2").val());
  getSoldProductChart($("#form2input1").val(),$("#form2input2").val());
})





















/**function ajax_vreme_zarada(){
  $.ajax({
         type: "POST",
         url: "/testing.php",
         data: {method: "getIncomeChart"},
         success: function(data){
          console.log(data);
          var vremeJson = [];
          var zaradaJson = [];
          for (var i in data){
            vremeJson.push(data[i].vreme);
            zaradaJson.push(data[i].zarada);
          } // end for each

          var chartdata = {
            labels: vremeJson,
            //labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            //datasets: {[1,2,3,4,5,6,7,8]}
            datasets: [{data: zaradaJson,
              backgroundColor:"red",
  					  borderColor: "red",}],
            fill: false,
          };

          var ctx = $("#canvas1");

          var lineGraph = new Chart(ctx, {
            type: 'line',
            data: chartdata,
            options: {
                  				responsive: true,
                  				title: {
                  					display: true,
                  					text: 'Pregled Zarada'
                  				},
                  				tooltips: {
                  					mode: 'index',
                  					intersect: false,
                  				},
                  				hover: {
                  					mode: 'nearest',
                  					intersect: true
                  				},
                  				scales: {
                  					xAxes: [{
                  						display: true,
                  						scaleLabel: {
                  							display: true,
                  							labelString: 'datum'
                  						}
                  					}],
                  					yAxes: [{
                  						display: true,
                  						scaleLabel: {
                  							display: true,
                  							labelString: 'zarada'
                  						}
                  					}]
                  				}
                  			}

          });

        }
       });
}
function aaaaa(){
  config = {
    type: 'line',
    data: {
        labels: ["January", "February", "March", "April", "May", "June", "July"],
        datasets: [{
            label: "My First dataset",
            data: [65, 59, 80, 81, 56, 55, 40],
            borderColor: 'rgba(0, 188, 212, 0.75)',
            backgroundColor: 'rgba(0, 188, 212, 0.3)',
            pointBorderColor: 'rgba(0, 188, 212, 0)',
            pointBackgroundColor: 'rgba(0, 188, 212, 0.9)',
            pointBorderWidth: 1
        }, {
                label: "My Second dataset",
                data: [28, 48, 40, 19, 86, 27, 90],
                borderColor: 'rgba(233, 30, 99, 0.75)',
                backgroundColor: 'rgba(233, 30, 99, 0.3)',
                pointBorderColor: 'rgba(233, 30, 99, 0)',
                pointBackgroundColor: 'rgba(233, 30, 99, 0.9)',
                pointBorderWidth: 1
            }]
    },
    options: {
        responsive: true,
        legend: false
    }
}
return config;
}
*/
/*
//$(document).ready(function(){
ajax_vreme_zarada();
//});
*/
