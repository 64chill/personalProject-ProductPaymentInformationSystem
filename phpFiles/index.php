<?php
define("CURRENT_PAGE", "index.php");

//---------------------------------------------------------------- FUNCTIONS
function removeCookie($cookieName){
  if(isset($_COOKIE[$cookieName])){
    setcookie($cookieName, "", time() - 3600);
  }
}

function check_parameters_POST(){
  // provera da li postoji $_POST i ako postoji provera/ulaz u nalog
  if($_POST){
    if(isset($_POST["username"]) && !empty($_POST["username"]) &&
       isset($_POST["password"]) && !empty($_POST["password"]) ){
         $usr = preg_match('/^\w+$/', $_POST["username"], $usr);
         if($usr==0){
           echo " <div class='icon-circle bg-red'> Pogrešan unos podataka, probajte ponovo </div>";
           return;
         }
         $object = new Login($_POST["username"], $_POST["password"]);
         (isset($_POST["rememberme"]) && $_POST["rememberme"]=="on")? $object->set_rememberme("on") :false;

         $object->startSessionIfUserExists();
    }
  }
}
//---------------------------------------------------------klase za pristup bazi
include_once $_SERVER['DOCUMENT_ROOT'] . "/sqlClasses/dbh.class.php";
include_once $_SERVER['DOCUMENT_ROOT'] ."/sqlClasses/login.class.php";
//---------------------------------------------------------------- provera Login
$object = new Login();
$bol = $object->startSessionIfCookieExists();
$newURL="";
if($bol==1){
  if($_SESSION["tip_naloga"]==1)
    $newURL = "dashboard/admin/indexAdmin.php?page=glavni_podaci";
  else if($_SESSION["tip_naloga"]==2){
    $newURL = "dashboard/worker/indexWorker.php";
  }

    header("Location: $newURL");
}

  if($newURL==""){
    removeCookie("series_identifier");
    removeCookie("cookie_token");
  }


//-------------------------------------------------------- ostalo za stranicu
include_once 'additionalPhp/headerMain.php';
check_parameters_POST();
include_once "additionalPhp/indexMain.php"; // unos html strukture, bez header i body tag-a
include_once 'additionalPhp/footerMain.php';
 ?>
