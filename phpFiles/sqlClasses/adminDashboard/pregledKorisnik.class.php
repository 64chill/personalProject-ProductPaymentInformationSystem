<?php
/*
* class PregledKorisnik extends Dbh
*     -   public function echo_data_as_table  ()
*     -   public function set_user_db         ($usr, $pwd, $type)
*     -   public function check_if_user_db    ($username)
*     -   public function del_user_from_db    ($uidx)
*     -   public function edit_user_db      ($username=false, $pwd=false)
*/
class PregledKorisnik extends Dbh{
  //constructor ----------------------------------------------------------------
  function __construct(){}
 // __construct end
/* *************************************************************************
*
*           echo_data_as_table
*       vraca podatke kao td,tr i dodatna polja....
*
************************************************************************* */
  public function echo_data_as_table(){
    $stmt = $this->connect()->prepare(
              "SELECT korisnik_id, username, tip_naloga
              FROM korisnici;"
            );
    $stmt->execute();
            if($stmt->rowCount()>0){
              while($row = $stmt->fetch()){
                if($row['tip_naloga']==1){
                  $tipNaloga = "administrator";
                } else{
                  $tipNaloga = "radnik";
                }
                echo '<tr><th class="data-id">'.
                $row['korisnik_id']."</th><th class=\"data-username\">".
                $row['username']."</th><th> ".
                $tipNaloga."</th>"./*
                "<th><button data-toggle=\"modal\" data-type=\"basic\" data-target=\"#modal_izmeni\" type=\"button\" class=\"btn bg-orange waves-effect btn-xs\" id=\"".$row['korisnik_id']."\">
                <i class=\"material-icons\">create</i></button></th><th> ".*/
                "<th><button data-toggle=\"modal\" data-type=\"basic\" data-target=\"#modal_obrisi\" type=\"button\" class=\"btn bg-red waves-effect btn-xs\" id=\"".$row['korisnik_id']."\">
                <i class=\"material-icons\">delete</i></button></th></tr> ";
              }
            }else{
                echo "";
            }
  } // echo_data_as_table end


/* *************************************************************************
*set_user_db
*
*
************************************************************************* */
  public function set_user_db($usr, $pwd, $type){
    $Hashed_pwd = password_hash($pwd, PASSWORD_DEFAULT);
    $stmt = $this->connect()->prepare(
              "INSERT INTO korisnici (username, password, tip_naloga)
              VALUES (?,?,?);"
            );
    $stmt->execute([$usr, $Hashed_pwd ,$type]);

  } // end set_user_db

  /* *************************************************************************
  *check_if_user_db
  *
  *
  ************************************************************************* */
    public function check_if_user_db($username){
      $stmt = $this->connect()->prepare(
                "SELECT * FROM korisnici WHERE username =?;"
              );
      $stmt->execute([$username]);
      while($row = $stmt->fetch()){
        return true;
      }
      return false;

    } // end check_if_user_db

  /*
  *del_user_from_db
  *
  *
  */
    public function del_user_from_db($uidx){
      $stmt = $this->connect()->prepare("DELETE FROM korisnici WHERE korisnik_id =?;");
      $stmt->execute([$uidx]);
    } // end del_user_db

} // class PregledKorisnik end


 ?>
