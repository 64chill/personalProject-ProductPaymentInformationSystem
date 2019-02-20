<?php
define("CURRENT_PAGE", "pregled_korisnika_php.php");
include_once $_SERVER['DOCUMENT_ROOT']."/sqlClasses/dbh.class.php";
include_once $_SERVER['DOCUMENT_ROOT']."/sqlClasses/adminDashboard/pregledKorisnik.class.php";
include_once $_SERVER['DOCUMENT_ROOT']."/sqlClasses/pagination.class.php";

/*
*function addUserCheckAndSubmit(){-----------------------------------------------------------------------
*
*/
function addUserCheckAndSubmit(){
  $obj = new PregledKorisnik();
    $errArray = [];
          if(isset($_POST["username"]) && trim($_POST["username"])){
             $usr = preg_match('/^\w+$/', $_POST["username"], $usr);
              if ($usr == 0){
                   $errArray[] = "Korisničko ime, samo slova su dozvoljena!";
                 }

               if ($usrExist=$obj->check_if_user_db(trim($_POST["username"]))){ // true - postoji korisnik
                   $errArray[] = "Postoji izabrano korisničko ime!";
                 }
          } else {
            $errArray[] = "Molimo vas unesite korisničko ime!";
          }
          if(!isset($_POST["password"])){
            $errArray[] = "Molimo vas unesite lozinku!";
          }
          if( !isset($_POST["tip"]) || !((int)$_POST["tip"]==1 ||(int)$_POST["tip"]==2) ){
            $errArray[] = "Greška kod biranja tipa naloga!";
          }
          if(empty($errArray)){
            $obj->set_user_db($_POST["username"], $_POST["password"], (int)$_POST["tip"]);
            echo "<div class=\"alert alert-success\">Uspešno unet korisnik u bazu!</div>";

          } else{
            echo " <div class=\"alert alert-danger\"><ul>";
              foreach ($errArray as $value) {
                echo "<li>$value</li>";
              }
            }
            echo "</ul></div>";
} // end function addUserCheckAndSubmit

/* ******************************************************************************
*function delUserCheckAndSubmit(){
*
****************************************************************************** */
function delUserCheckAndSubmit(){
$obj = new PregledKorisnik();
  if((int)$_POST["user_id"] > 0){
      $obj->del_user_from_db((int)$_POST["user_id"]);
      echo "<div class=\"alert alert-success\">Uspešno uklonjen korisnik iz baze!</div>";
  } else {
    echo '<div class="alert alert-danger"> Došlo je do greške, molimo vas probajte da učitate stranicu ponovo!</div>';
  }

} // end function delUserCheckAndSubmit

/* ******************************************************************************
*function delUserCheckAndSubmit(){
*
****************************************************************************** */
function reloadTable(){
  $obj = new PregledKorisnik();
  $obj->echo_data_as_table();
} // end function delUserCheckAndSubmit

/* ******************************************************************************
*function editUserCheckAndSubmit(){
*
****************************************************************************** */
function editUserCheckAndSubmit(){
  } // end function editUserCheckAndSubmit

/* *****************************************************************************
*   function table_ajax()
*
***************************************************************************** */

  function table_ajax($pagenumber , $orderby){
    $table_obj = new Pagination();
    echo $table_obj->create_pagination($pagenumber,2,$_POST["formName"], $orderby , $_POST['sortP']);

  }
/* *****************************************************************************
*  "Main"
*
***************************************************************************** */
if($_POST){
  switch ($_POST["formName"]) {
    case 'form1':
      addUserCheckAndSubmit();
      break;
    case 'form2':
      print_r($_POST);
      break;
    case 'form3':
      delUserCheckAndSubmit();
      break;
    case 'korisnici':
      table_ajax($_POST['pagen'],$_POST['orderby']);
      break;
      case 'reloadTable':
        reloadTable();
        break;
    default:
      echo "Došlo je do greške, molimo vas učitajte ponovo stranicu!";
      break;
  }

}




 ?>
