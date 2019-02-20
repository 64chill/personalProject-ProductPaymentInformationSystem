<?php
define("CURRENT_PAGE", "pregled_racuna_php.php");
include_once $_SERVER['DOCUMENT_ROOT']."/sqlClasses/dbh.class.php";
include_once $_SERVER['DOCUMENT_ROOT']."/sqlClasses/pagination.class.php";

 function table_ajax($pagenumber , $orderby){
    $table_obj = new Pagination();
    echo $table_obj->create_pagination($pagenumber,2,$_POST["formName"], $orderby , $_POST['sortP']);

  }
if($_POST){
    switch ($_POST["formName"]) {
      case 'racuni':
        table_ajax($_POST['pagen'],$_POST['orderby']);
    } //end switch
} // end if
 ?>
