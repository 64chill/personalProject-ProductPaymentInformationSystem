<?php

define("CURRENT_PAGE", "glavni_podaci_php.php");
include_once $_SERVER['DOCUMENT_ROOT']."/sqlClasses/dbh.class.php";
include_once $_SERVER['DOCUMENT_ROOT']."/sqlClasses/adminDashboard/glavniPodaci.class.php";
/* *****************************************************************************
*   function checkDateParams($date1, $date2){
***************************************************************************** */
function checkDateParams($date1, $date2){
//  if( (DateTime::createFromFormat('Y-m-d G:i:s', $date1) !== FALSE ) )
  if ( (false === strtotime($date1)) || (false === strtotime($date2)) ){
    echo '<div class="bg-red">Polja [Od Datuma] i [Do Datuma] moraju biti u formatu datuma!</div>';
    exit;
  } 
  if ($date1 > $date2  ){
      echo '<div class="bg-red">Polje [Od Datuma] mora biti manje od polja [Do Datuma]</div>';
      exit;
    }
}
function issetDateParam(){
  if (!isset($_POST["input1"]) && !isset($_POST["input2"])){
    echo '<div class="bg-red">Problem pri slanju polja [Od Datuma] i [Do Datuma], Molimo vas probajte ponovo!</div>';
    exit;
  }
}
/* *****************************************************************************
*   function check_compare_product_fields($i1, $i2, $i3, $i4, $i5 ){
***************************************************************************** */
function check_compare_product_fields($i1, $i2, $i3, $i4, $i5 ){
  $greske = "<div class=\"bg-red\"><ul>";
  //status
  if (!(int)$i3 == 1 ||!(int)$i3 == 2){
    $greske .= "<li> Greška kod učitavanja statusa, molimo vas učitajte stranicu ponovo</li>";
  }
  //date
  if ( (false === strtotime($i1)) && (false === strtotime($i2)) ){
    $greske .=  '<li>Polja [Od Datuma] i [Do Datuma] moraju biti u formatu datuma!</li>';
  }
  if ($i1 > $i2  ){
      $greske .=  '<li>Polje [Od Datuma] mora biti manje od polja [Do Datuma]</li>';
    }
  //product 1 and 2 check_if_records_exist
    $obj = new GlavniPodaci();
  if (!$obj->check_if_record_exist($i4)){
    $greske .= '<li>Polje [Sifra Proizvoda 1] neispravno</li>';
  }
  if (!$obj->check_if_record_exist($i5)){
    $greske .= '<li>Polje [Sifra Proizvoda 2] neispravno</li>';
  }
  if($greske=="<div class=\"bg-red\"><ul>"){
    return;
  } else {
    echo $greske . "</ul></div>";exit;
  }
}
/* *****************************************************************************
*   if (isset($_POST["method"])){
***************************************************************************** */
if (isset($_POST["method"])){
  switch ($_POST["method"]) {
    case 'getIncomeChart':
        issetDateParam();
        checkDateParams($_POST["input1"],$_POST["input2"]);
        $obj = new GlavniPodaci();
        print $obj->json_encode_income_chart($_POST["input1"],$_POST["input2"]);
        break;

    case 'getSoldProductChart':
        issetDateParam();
        checkDateParams($_POST["input1"],$_POST["input2"]);
        $obj = new GlavniPodaci();
        print $obj->json_encode_sold_product_chart($_POST["input1"],$_POST["input2"]);
        break;
    case 'compareProductChart':
      check_compare_product_fields($_POST["odDatum1form3"], $_POST["doDatum1form3"], $_POST["status3"], $_POST["sp1"], $_POST["sp2"]);
      $obj = new GlavniPodaci();
      print $obj->json_encode_compare_products_chart($_POST["odDatum1form3"], $_POST["doDatum1form3"], $_POST["status3"], $_POST["sp1"], $_POST["sp2"]);

      break;
  } // switch end;

} //if (isset($_POST["method"])) end;



 ?>
