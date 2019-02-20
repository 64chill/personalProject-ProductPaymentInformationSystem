<?php
class PregledRacun extends Dbh{
  //constructor ----------------------------------------------------------------
  function __construct(){}

    /* *************************************************************************
    *
    *           echo_data_as_table
    *
    ************************************************************************* */
      public function echo_data_as_table(){
        $finalStr="";
        $stmt = $this->connect()->prepare(
                  "SELECT * FROM racuni"
                );
        $stmt->execute();
                if($stmt->rowCount()>0){
                  while($row = $stmt->fetch()){
                    $finalStr.= '<tr><th>'.
                    $row['racuni_id']."</th><th>".
                    $row['vreme']."</th><th> ".
                    $row['ukupna_vrednost']."</th>"."</tr> ";/*.
                    "<th><button data-toggle=\"modal\" data-type=\"basic\" data-target=\"#modal_izmeni\" type=\"button\" class=\"btn bg-orange waves-effect btn-xs\" id=\"".$row['racuni_id']."\">
                    <i class=\"material-icons\">create</i></button></th><th> ".
                    "<button data-toggle=\"modal\" data-type=\"basic\" data-target=\"#modal_obrisi\" type=\"button\" class=\"btn bg-red waves-effect btn-xs\" id=\"".$row['racuni_id']."\">
                    <i class=\"material-icons\">delete</i></button></th></tr> ";*/
                  }
                }else{
                    echo "-1";
                }
                return $finalStr;
      } // echo_data_as_table end
}




 ?>
