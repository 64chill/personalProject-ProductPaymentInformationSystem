<?php
define("CURRENT_PAGE", "pregled_korisnika_php.php");
include_once $_SERVER['DOCUMENT_ROOT']."/sqlClasses/dbh.class.php";
include_once $_SERVER['DOCUMENT_ROOT']."/sqlClasses/adminDashboard/pregledProizvod.class.php";
include_once $_SERVER['DOCUMENT_ROOT']."/sqlClasses/pagination.class.php";

function check_and_add_product_to_db(){
  $err_arr = [];
  if(!isset($_POST['naziv_proizvoda']) && empty($_POST['naziv_proizvoda']) ){
    $err_arr [] = "Molimo vas unesite naziv proizvoda!";
  }
  if(!isset($_POST['cena_proizvoda'])  && empty($_POST['cena_proizvoda'])){
      $err_arr [] = "Molimo vas unesite cenu proizvoda!";
  }
  if(!isset($_POST['barkod_proizvoda'])  && empty($_POST['barkod_proizvoda']) ){
      $err_arr [] = "Molimo vas unesite barkod proizvoda!";
  }
  if(!isset($_POST['kolicina_proizvoda'])  && empty($_POST['kolicina_proizvoda']) ){
      $err_arr [] = "Molimo vas unesite kolicinu proizvoda!";
  }
  if(!isset($_POST['jedinica_mere_proizvoda'])  && empty($_POST['jedinica_mere_proizvoda']) ){
      $err_arr [] = "Molimo vas unesite jedinicu mere proizvoda!";
  }
  if(!isset($_POST['naziv_kompanije_proizvoda']) && empty($_POST['naziv_kompanije_proizvoda']) ){
      $err_arr [] = "Molimo vas unesite naziv kompanije proizvoda!";
  }
  if(empty($err_arr)){
    if(strlen($_POST['naziv_proizvoda'])<4){
        $err_arr [] = "Naziv proizvoda mora biti jednak ili veći od 4 karaktera!";
      }
    if( !(double)$_POST['cena_proizvoda']>=1){
        $err_arr [] = "Cena mora biti veća ili jednaka 1!";
    }
    if( !preg_match( '/^\d{13}$/', (int)($_POST['barkod_proizvoda']) ) ){
      $err_arr [] = "Barkod mora biti 13 cifara!";
    }
    if( !(int)$_POST['kolicina_proizvoda']>0){
      $err_arr [] = "Količina mora biti veća od 0";
    }
  }

  if(empty($err_arr)){
    $obj = new PregledProizvod();
    $obj->insert_product_to_db( $_POST['naziv_proizvoda'], $_POST['cena_proizvoda'], $_POST['barkod_proizvoda'], $_POST['kolicina_proizvoda'], $_POST['jedinica_mere_proizvoda'], $_POST['naziv_kompanije_proizvoda']);
    echo "<div class=\"alert alert-success\">Uspešno unet proizvod u bazu!</div>";

  } else{
    echo " <div class=\"alert alert-danger\"><ul>";
      foreach ($err_arr as $value) {
        echo "<li>$value</li>";
      }
    }
    echo "</ul></div>";


} // end functiom check_and_add_product_to_db
/* *****************************************************************************
*   function table_ajax()
*
***************************************************************************** */

  function table_ajax($pagenumber , $orderby){
    $table_obj = new Pagination();
    echo $table_obj->create_pagination($pagenumber,2,$_POST["formName"], $orderby , $_POST['sortP']);

  }
/* *****************************************************************************
* if($_POST){
***************************************************************************** */


if($_POST){
    switch ($_POST["formName"]) {
      case 'form1_proizvod':
        check_and_add_product_to_db();
        break;
      case 'proizvodi':
        table_ajax($_POST['pagen'],$_POST['orderby']);
    } //end switch
} // end if
 ?>
