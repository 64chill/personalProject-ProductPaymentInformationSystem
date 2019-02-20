<?php
/*
* class PregledProizvod extends Dbh{
*     public function   echo_data_as_table                (){
*     public function   get_option_product_companies      (){
*
*/
class PregledProizvod extends Dbh{
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
                  "SELECT proizvodi.proizvodi_id, proizvodi.naziv, proizvodjaci.naziv_proizvodjaca, proizvodi.cena, proizvodi.sifra, proizvodi.kolicina, proizvodi.jedinica_mere
                  FROM proizvodi INNER JOIN proizvodjaci ON proizvodi.proizvodjac_id = proizvodjaci.proizvodjac_id;"
                );
        $stmt->execute();
                if($stmt->rowCount()>0){
                  while($row = $stmt->fetch()){
                    $finalStr.= '<tr><th>'.
                    $row['proizvodi_id']."</th><th>".
                    $row['naziv']."</th><th> ".
                    $row['naziv_proizvodjaca']."</th><th> ".
                    $row['cena']."</th><th> ".
                    $row['sifra']."</th><th> ".
                    $row['kolicina']."</th><th> ".
                    $row['jedinica_mere']."</th>"."</tr>";/*.
                    "<th><button data-toggle=\"modal\" data-type=\"basic\" data-target=\"#modal_izmeni\" type=\"button\" class=\"btn bg-orange waves-effect btn-xs\" id=\"".$row['proizvodi_id']."\">
                    <i class=\"material-icons\">create</i></button></th><th> ".
                    "<button data-toggle=\"modal\" data-type=\"basic\" data-target=\"#modal_obrisi\" type=\"button\" class=\"btn bg-red waves-effect btn-xs\" id=\"".$row['proizvodi_id']."\">
                    <i class=\"material-icons\">delete</i></button></th></tr> ";*/
                  }
                }else{
                    echo "-1";
                }
                return $finalStr;
      } // echo_data_as_table end
      /* *************************************************************************
      *
      *           echo_data_as_table
      *
      ************************************************************************* */
        public function get_option_product_companies(){
          $finalStr="";
          $stmt = $this->connect()->prepare(
                    "SELECT proizvodjac_id as id, naziv_proizvodjaca as name FROM proizvodjaci;"
                  );
          $stmt->execute();
                  if($stmt->rowCount()>0){
                    while($row = $stmt->fetch()){
                      $finalStr.= '<option value="'.$row['id'].'">'.
                      $row['name']."</option> ";
                    }
                  }else{
                      echo "-1";
                  }
                  return $finalStr;
        }
    /* *************************************************************************
    *
    *           check_if_manufacturer_exist($manufacturerID)
    *
    ************************************************************************* */
    public function check_if_manufacturer_exist($manufacturerID){
      $stmt = $this->connect()->prepare(
                "      SELECT proizvodjac_id FROM proizvodjaci WHERE proizvodjac_id=?;"
              );
      $stmt->execute([$manufacturerID]);
      while($row = $stmt->fetch()){
        return true;
      }
      return false;
    }
    /* *************************************************************************
    *
    *           insert_product_to_db()
    *
    ************************************************************************* */
    public function insert_product_to_db($name, $price, $barcode, $quantity, $unit_of_measure, $manufacturerID, $purchase_price){
      if( !$this->check_if_manufacturer_exist($manufacturerID) ){
        return "-1";
      }
      $stmt = $this->connect()->prepare(
                "INSERT INTO proizvodi (naziv, cena, sifra, kolicina, jedinica_mere, proizvodjac_id, nabavna_cena)
                VALUES (?,?,?,?,?,?,?);"
              );
      $stmt->execute([$name, $price ,$barcode, $quantity , $unit_of_measure , $manufacturerID, $purchase_price ]);
      echo $name ." ". $price." ".$barcode." ".$quantity." ".$unit_of_measure." ".$manufacturerID." ".$purchase_price;

    }
} // end class




 ?>
