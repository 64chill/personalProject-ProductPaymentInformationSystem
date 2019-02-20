<?php
define("CURRENT_PAGE", "worker.ajax.php");
include_once $_SERVER['DOCUMENT_ROOT']."/sqlClasses/dbh.class.php";
include_once $_SERVER['DOCUMENT_ROOT']."/sqlClasses/workerDashboard/receiptMaker.class.php";
$obj = new receiptMaker();

function makeReceipt(){
    $arrayProducts = explode(',', $_POST["codes"]);
    $vals = array_count_values($arrayProducts);
    $vals2=[];
    foreach ($vals as $key => $value) {
      if($key!="" && strlen($key) == 13 ){ //&& (int)$key > 0 && strlen($key) == 11
      $vals2[$key] = $value;
      }
    } // end foreach
    $obj = new receiptMaker();
    $this_receipt_id = $obj->create_receipt_get_id($vals2);
    echo $obj->show_reciept_with_products($this_receipt_id);
} // delete makeReceipt

if($_POST){
  if($_POST["method"]=="getProductInfo"){
    echo $obj->generate_td_product_info( trim($_POST["code"]) );
  } else if($_POST["method"]=="setReceipt"){
    makeReceipt();
  } else if ($_POST["method"]=="liveSearch"){

    if ( preg_match('/^\d{1,13}$/', trim($_POST["searchInput"])) ){
    //!ctype_digit($_POST["searchInput"])
      echo $obj->makeList_for_liveSearchSuggestion( trim($_POST["searchInput"]) );
    }
  }// end else if ($_POST["method"]=="liveSearch"){
} // end if($_POST){



 ?>
