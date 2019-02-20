<?php
/**
 *  class receiptMaker extends Dbh{
 *    function  generate_td_product_info     ($productCode)
 *    function  create_receipt_get_id        ($arr){
 *    function  check_if_records_exist       ($arr){
 *    function  get_value_sum                ($arr){
 *    function  insert_bought_products       ($arr, $racuni_id){
 *    function  show_reciept_with_products   ($id){
 */
class receiptMaker extends Dbh{

  function __construct(){}
/* *****************************************************************************
* generate_td_product_info
***************************************************************************** */
  function generate_td_product_info($productCode){
    if( ((int)$productCode <= 0) && strlen($productCode) != 13 ){
      return -1;
    }
    $stmt = $this->connect()->prepare(
      " SELECT naziv, cena, kolicina, jedinica_mere , naziv_proizvodjaca
        FROM proizvodi INNER JOIN proizvodjaci ON proizvodjaci.proizvodjac_id = proizvodi.proizvodjac_id
        WHERE sifra=?;"
      );
      $stmt->execute([$productCode]);
              if($stmt->rowCount()>0){
                while($row = $stmt->fetch()){
                $name         = $row["naziv"];
                $manufacturer = $row["naziv_proizvodjaca"];
                $quantity     = $row["kolicina"] . " " .$row["jedinica_mere"];
                $price        = $row["cena"];
                return "<td>".$name."</td><td>".$manufacturer."</td><td>".$quantity."</td><td>".$price."</td>";
                }
              }else{
                  return "-1";
              }

  }
/* *****************************************************************************
* create_receipt_get_id()$valueSum)
***************************************************************************** */
function create_receipt_get_id($arr){
  $returnArray= $this->get_value_sum($arr);
  if($returnArray == "-1"){return "-1";}
  $timestamp = date('Y-m-d G:i:s');
  $stmt = $this->connect()->prepare(
    " INSERT INTO racuni
      (vreme, ukupna_vrednost,ukupna_nabavna_cena)
      VALUES (?,?,?);"
    );
  $stmt->execute([$timestamp, $returnArray['sum_value'], $returnArray['sum_purchase_price']]);
  $last_id = $this->getLastRecordID();
  $this->insert_bought_products($arr,$last_id);
  return $last_id;
}
/* *****************************************************************************
* check_if_records_exist($arr)
***************************************************************************** */
function check_if_records_exist($arr){
  if(empty($arr))
      return false;
  foreach ($arr as $key => $value) {
    $stmt = $this->connect()->prepare(
      "SELECT COUNT(*) AS count FROM proizvodi WHERE sifra=?"
      );
    $stmt->execute([$key]);
    if($stmt->rowCount()>0){
        while($row = $stmt->fetch()){
          if ($row['count'] == 0) {
            return false;
          }
        }
    }

  }
  return true;
}
/* *****************************************************************************
* get_value_sum($arr)
***************************************************************************** */
function get_value_sum($arr){
  if(!$this->check_if_records_exist($arr)){
    return false;
  }
  $stmtString="SELECT nabavna_cena, cena, sifra FROM proizvodi WHERE";
  $counter=0;
  foreach ($arr as $key => $value) {
    if($counter==0){
      $stmtString.=" sifra=\"".$key."\"";
    } else{
      $stmtString.=" OR sifra=\"$key\"";
    }
    $counter++;

  } //END foreach
  $sum_value=0;
  $sum_purchase_price=0;
  $stmt = $this->connect()->prepare(
    $stmtString.";"
    );
  $stmt->execute();
  if($stmt->rowCount()>0){
    while($row = $stmt->fetch()){
        $sum_value+= $arr[$row["sifra"]] * $row["cena"];
        $sum_purchase_price += $arr[$row["sifra"]] * $row["nabavna_cena"];
    }
  }else{
      return "-1";
  }
  $returnArray = array(
    'sum_value' => $sum_value,
    'sum_purchase_price' => $sum_purchase_price
  );
  return $returnArray;

} // end get_value_sum
/* *****************************************************************************
* check_if_records_exist($arr)
***************************************************************************** */
function insert_bought_products($arr, $racuni_id){
  foreach ($arr as $key => $value) {
      $stmt = $this->connect()->prepare(
        " INSERT INTO kupljeni_proizvodi
          (sifra, kolicina, racuni_id)
          VALUES (?,?,?);"
        );
      $stmt->execute([$key, $value, $racuni_id]);
    }//end foreach
}

//end functions for create_receipt_get_id($arr)---------------------------------
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------

/* *****************************************************************************
* show_reciept_with_products($id)
***************************************************************************** */
function show_reciept_with_products($id){
  $returnString="<table class=\"table\"><tbody>";
//get receipt data --------------
  $stmt = $this->connect()->prepare(
    " SELECT vreme, ukupna_vrednost FROM racuni WHERE racuni_id=?;"
    );
    $stmt->execute([$id]);
            if($stmt->rowCount()>0){
              while($row = $stmt->fetch()){
              $time         = $row["vreme"];
              $valueSum     = $row["ukupna_vrednost"];
              $returnString.="<tr class=\"col-indigo\"><td>VREME</td><td>".$time." </td><td>CENA UKUPNO</td><td>".$valueSum." din</td></tr>";
              }
            }else{
                return "-1";
            }
      $returnString.="<tr><td> ---------- </td><td> ---------- </td><td> ---------- </td><td> ---------- <td> ---------- </td></tr>";
//get product data --------------
    $stmt = $this->connect()->prepare(
      "SELECT proizvodi.naziv, proizvodi.cena, proizvodi.kolicina, proizvodi.jedinica_mere, kupljeni_proizvodi.kolicina AS ukupno, proizvodjaci.naziv_proizvodjaca
      FROM kupljeni_proizvodi
      INNER JOIN proizvodi ON kupljeni_proizvodi.sifra = proizvodi.sifra
      INNER JOIN proizvodjaci ON proizvodjaci.proizvodjac_id = proizvodi.proizvodjac_id
      WHERE kupljeni_proizvodi.racuni_id =?;"
      );
      $stmt->execute([$id]);
              if($stmt->rowCount()>0){
                while($row = $stmt->fetch()){
                $name         = $row["naziv"];
                $quantity     = $row["kolicina"] . " " .$row["jedinica_mere"];
                $price        = $row["cena"];
                $manufacturer = $row["naziv_proizvodjaca"];
                $quantityProducts =  "x".$row["ukupno"];
                $returnString.= "<tr><td>".$name."</td><td>".$quantity."</td><td>".$price." din.</td><td>".$manufacturer."</td><td>".$quantityProducts."</td></tr>";
                }
              }else{
                  return "-1";
              }

  $returnString.="</tbody></table>";
  return $returnString;
} // end show_reciept_with_products

/* *****************************************************************************
* makeList_for_liveSearchSuggestion($input)
***************************************************************************** */
function makeList_for_liveSearchSuggestion($input){
  $returnString="<ul>";
  $stmt = $this->connect()->prepare(
    "SELECT proizvodi.sifra, proizvodi.naziv, proizvodjaci.naziv_proizvodjaca
      FROM proizvodi INNER JOIN proizvodjaci
      ON proizvodi.proizvodjac_id = proizvodjaci.proizvodjac_id
      WHERE sifra LIKE ?;"
    );
    $stmt->execute([$input . "%"]);
    if($stmt->rowCount()>0){
      while($row = $stmt->fetch()){
        $product_code = $row["sifra"];
        $product_name = $row["naziv"];
        $manufacturer = $row["naziv_proizvodjaca"];
        $returnString .="<li><a href='javascript:void(0);' id='$product_code'>".$product_code." | " . $manufacturer." : " . $product_name."</a></li>";
      } // end while
    }else{
      return "";
  }
  $returnString .="</ul>";
  return $returnString;
}


} //end receiptMaker
?>
