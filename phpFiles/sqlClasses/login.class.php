<?php

function pogresan_unos(){
  echo " <div class='icon-circle bg-red'> Pogrešan unos podataka, probajte ponovo </div>";
}

function set_my_cookie($cookie_name, $val){
  if(!isset($_COOKIE[$cookie_name])) {setcookie($cookie_name, "", time() - 3600);}
  setcookie($cookie_name, $val, time() + (86400 * 15), "/"); // 15days
}
/*
* class Login extends Dbh
*   public function generateRandomString($length = 10)
*   private function set_login_cookie($u_id)
*   public function startSessionIfUserExists()
*   public function startSessionIfCookieExists()
*   public function set_rememberme($val)
*
*/


class Login extends Dbh{
  //atributes--------------------------------------------------------------------
    private $firstInput;
    private $password;
    private $rememberme = "off";

    //constructor---------------------------------------------------------------
    function __construct($un="-1",$pwd="-1"){
      $this->firstInput=$un;
      $this->password=$pwd;
      $this->rememberme = "off";
    }
    /*--------------------------------------------------------------------------
                        random string
    --------------------------------------------------------------------------*/
  public function generateRandomString($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
  }

  /*--------------------------------------------------------------------------
                            PUT Cooike
    --------------------------------------------------------------------------*/
        private function set_login_cookie($u_id){
          /*cookie postoji?
          da li je u tabeli korisnik_login_cookie??*/
          $stmtC = $this->connect()->prepare(
                    "SELECT *
                    FROM korisnik_login_cookie
                    WHERE korisnik_id=? ;"
                  );
          $stmtC-> execute([$u_id]);
          if($stmtC->rowCount()>0){ //ukoliko postoji series_identifier

            while($row = $stmtC->fetch()){//promeni token token
                  $newToken=$this->generateRandomString(20);
                    $statement1 = $this->connect()->prepare(
                      "UPDATE korisnik_login_cookie
                      SET cookie_token =?
                      WHERE series_identifier=? AND
                      korisnik_id=?
                      ;"
                    );
                    $statement1->execute([$newToken,$row["series_identifier"],$u_id]);
                    //cookie 1
                    set_my_cookie("series_identifier",$row["series_identifier"]);
                    //cookie 2
                    set_my_cookie("cookie_token",$newToken);
                }//end while

          } else{//ako postoje zapisi u nasoj tabeli
              $statement2 = $this->connect()->prepare(
                "INSERT INTO korisnik_login_cookie(korisnik_id,series_identifier,cookie_token) VALUES(?,?,?)"
              );
              $a1=$this->generateRandomString(30);//series_identifier
              $a2=$this->generateRandomString(30);//cookie_token
              $statement2->execute([$u_id, $a1,$a2]);
              //PUT cookie -----------------------------------------------------
              //cookie 1
              set_my_cookie("series_identifier", $a1);

              //cookie 2
              set_my_cookie("cookie_token", $a2);
            }

        }
  /*--------------------------------------------------------------------------
                                startSessionIfUserExists
    --------------------------------------------------------------------------*/
  public function startSessionIfUserExists(){
      $stmt = $this->connect()->prepare(
                "SELECT *
                FROM korisnici
                WHERE username=?;"
              );
      $stmt-> execute([$this->firstInput]);
      if($stmt->rowCount()>0){
        while($row = $stmt->fetch()){
          $u_id=$row["korisnik_id"];
          $u_username=$row["username"];
          $u_pwd=$row["password"];
          $u_type=$row["tip_naloga"];
          if(password_verify($this->password, $u_pwd)){ //pwd
          session_start();
          $_SESSION["korisnik_id"] = $u_id;
          $_SESSION["username"] = $u_username;
          $_SESSION["tip_naloga"] = $u_type;
          //TODO
          ($this->rememberme=="on")?$this->set_login_cookie($u_id):false;
          /*if($var_cookie==1){
            $this->set_login_cookie($u_id);
          }*/
          if($u_type==1){
              header("Location: dashboard/admin/indexAdmin.php?page=glavni_podaci");
          } else if($u_type==2) {
              header("Location: dashboard/worker/indexWorker.php");
          }
        }else{
          pogresan_unos();
          }
        }// END while
      }else{
        pogresan_unos();
      }
    } // startSessionIfUserExists end

    /*--------------------------------------------------------------------------
                                startSessionIfCookieExists
    --------------------------------------------------------------------------*/
    public function startSessionIfCookieExists(){
      if(!(isset($_COOKIE["series_identifier"]) && isset($_COOKIE["cookie_token"]))) {
        return false;
      }
      // ako postoji preuzima vrednosti
      $si = $_COOKIE["series_identifier"];//series_identifier
      $cookiet = $_COOKIE["cookie_token"];//cookie_token
      ///////////////////////////////////////////////////////////////////////
      $stmtC = $this->connect()->prepare(
                "SELECT    korisnik_login_cookie.korisnik_id, korisnik_login_cookie.series_identifier, korisnik_login_cookie.cookie_token, korisnici.username, korisnici.tip_naloga
                FROM       korisnik_login_cookie
                INNER JOIN korisnici
                ON         korisnici.korisnik_id = korisnik_login_cookie.korisnik_id
                WHERE      korisnik_login_cookie.series_identifier=? AND korisnik_login_cookie.cookie_token=?;"
              );
      $stmtC-> execute([$si, $cookiet]); // preuzmi iz baze ako postoji
      if($stmtC->rowCount()>0){
        while($row = $stmtC->fetch()){//promena tokena i kreairanje sesije
          //novi token i novi kolacic--------------------------------------------
              $cookiet=$this->generateRandomString(20); // new token random
              $statement1 = $this->connect()->prepare(
                "UPDATE korisnik_login_cookie
                SET cookie_token =?
                WHERE series_identifier=? AND
                korisnik_id=?
                ;"
              );
                $statement1->execute([$cookiet,$si,$row["korisnik_id"]]);

                //cookie 1
                set_my_cookie("series_identifier",$si);

                //cookie 2
                set_my_cookie("cookie_token",$cookiet);

                //PUT $_SESSION----------------------------------------------------------------------------------
                session_start();
                $_SESSION["korisnik_id"] = $row["korisnik_id"];
                $_SESSION["username"] = $row["username"];
                $_SESSION["tip_naloga"] = $row["tip_naloga"];

                return true;
            } //end while
          } // end if ->rowCount
          else{
            return false;
          }
        } // startSessionIfCookieExists end
      //////////////////////////////////////////////////////////////////////

    public function set_rememberme($val){
        $this->rememberme = $val;
    } // set_rememberme end

} // class end


 ?>
