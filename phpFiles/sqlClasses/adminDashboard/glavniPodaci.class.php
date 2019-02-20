<?php
/*
* class GlavniPodaci extends Dbh{
*     function json_encode_income_chart($fromDate, $toDate)
*       function json_encode_sold_product_chart($fromDate, $toDate)
*       function check_if_record_exist($checker)
*       function json_encode_compare_products_chart($fromDate, $toDate, $status, $firstProductID, $secondProductID)
*
*
*/
class GlavniPodaci extends Dbh{
  //constructor ----------------------------------------------------------------
  function __construct(){}
    /* *************************************************************************
    *
    *           json_encode_income_chart
    ************************************************************************* */
  function json_encode_income_chart($fromDate, $toDate){
    $returnArray = array();
    $stmt = $this->connect()->prepare(
      "SELECT (ukupna_vrednost - ukupna_nabavna_cena) AS zarada, vreme FROM racuni
      WHERE `vreme` between ? and ? GROUP BY vreme;");

    $stmt->execute([$fromDate , $toDate]);
            if($stmt->rowCount()>0){
              while($row = $stmt->fetch()){
              $returnArray [] = array('vreme'   =>  $row['vreme'],
                                      'zarada'  =>  $row['zarada']
                                    );
              } // END while
            }else{
              return "";
            }

    return json_encode($returnArray);

  } //json_encode_income_chart end;
  /* *************************************************************************
  *
  *           json_encode_sold_product_chart
  ************************************************************************* */
  function json_encode_sold_product_chart($fromDate, $toDate){
    $returnArray = array();
    $stmt = $this->connect()->prepare(
      "SELECT proizvodi.naziv , proizvodjaci.naziv_proizvodjaca, count(kupljeni_proizvodi.kolicina) as ukupna_kolicina
      FROM kupljeni_proizvodi
      INNER JOIN proizvodi ON kupljeni_proizvodi.sifra = proizvodi.sifra
      INNER JOIN proizvodjaci ON proizvodi.proizvodjac_id = proizvodjaci.proizvodjac_id
      INNER JOIN racuni ON kupljeni_proizvodi.racuni_id = racuni.racuni_id
      WHERE `vreme` between ? and ?
      GROUP BY kupljeni_proizvodi.sifra
      ORDER BY ukupna_kolicina DESC
      LIMIT 1,10 ;");
      $stmt->execute([$fromDate,$toDate]);
        if($stmt->rowCount()>0){
            while($row = $stmt->fetch()){
                $returnArray [] = array(
                    'label'     =>  $row['naziv'] . " [".$row['naziv_proizvodjaca'] ."]",
                    'value'     =>  $row['ukupna_kolicina']
                );
                } // END while
              }else{
                return "";
              }

      return json_encode($returnArray);
  }
/* *****************************************************************************
* check_if_records_exist($arr)
***************************************************************************** */
  function check_if_record_exist($checker){
      $stmt = $this->connect()->prepare(
        "SELECT COUNT(*) AS count FROM proizvodi WHERE sifra=?"
        );
      $stmt->execute([$checker]);
      if($stmt->rowCount()>0){
          while($row = $stmt->fetch()){
            if ($row['count'] == 0) {
              return false;
            }
          }
      }
      return true;
    }

  /* *************************************************************************
  *
  *           json_encode_compare_products_chart
  *               $status - by income / by numbers sold
  ************************************************************************* */
  function json_encode_compare_products_chart($fromDate, $toDate, $status, $firstProductID, $secondProductID){
    $returnArray = array();
    if ($status == 1){ // po ukupnoj zaradi od datog proizvoda-------------------------------------------------------
      $arrayHelper = array();
      // da dobijemo ukupnu kolicinu----------------------------------------------------------
      $stmt1 = $this->connect()->prepare(
        "SELECT sum(kupljeni_proizvodi.kolicina) AS kolicina, kupljeni_proizvodi.sifra
            FROM kupljeni_proizvodi
              INNER JOIN racuni ON kupljeni_proizvodi.racuni_id = racuni.racuni_id
            WHERE (kupljeni_proizvodi.sifra = ? OR kupljeni_proizvodi.sifra = ?)
              AND (racuni.vreme BETWEEN ? AND ?)
            GROUP BY kupljeni_proizvodi.sifra;");
        $stmt1->execute([$firstProductID, $secondProductID,$fromDate , $toDate]);
          if($stmt1->rowCount()>0){
              while($row1 = $stmt1->fetch()){
                  $arrayHelper [] = array(
                      'kolicina'  => $row1['kolicina'] ,
                      'sifra'     =>  $row1['sifra']
                  );
                  } // END while
                }else{
                  return "";
                }

    //////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////

    $stmt2 = $this->connect()->prepare(
      "SELECT (proizvodi.cena - proizvodi.nabavna_cena) AS zarada , proizvodi.naziv, proizvodjaci.naziv_proizvodjaca, proizvodi.sifra
        FROM kupljeni_proizvodi
        	INNER JOIN proizvodi ON kupljeni_proizvodi.sifra = proizvodi.sifra
            INNER JOIN proizvodjaci ON proizvodi.proizvodjac_id = proizvodjaci.proizvodjac_id
        WHERE proizvodi.sifra = ? OR proizvodi.sifra = ?
        GROUP BY proizvodi.sifra;");
      $stmt2->execute([$firstProductID,$secondProductID]);
        if($stmt2->rowCount()>0){
            while($row2 = $stmt2->fetch()){
                $returnArray [] = array(
                    'a'          => $row2['zarada'] ,
                    'y'          => $row2['naziv'] . " [".$row2['naziv_proizvodjaca'] ."]",
                    'sifra'      => $row2['sifra']
                );
                } // END while
              }else{
                return "";
              }
        //zarada * kolicina proizvoda u datom periodu
        if ($returnArray[0]['sifra'] == $arrayHelper[0]['sifra']){
          $returnArray[0]['a'] = (double)$returnArray[0]['a'] * (double)$arrayHelper[0]['kolicina'];
          $returnArray[1]['a'] = (double)$returnArray[1]['a'] * (double)$arrayHelper[0]['kolicina'];
        } else if($returnArray[1]['sifra'] == $arrayHelper[0]['sifra']){
          $returnArray[1]['a'] = (double)$returnArray[1]['a'] * (double)$arrayHelper[0]['kolicina'];
          $returnArray[0]['a'] = (double)$returnArray[0]['a'] * (double)$arrayHelper[1]['kolicina'];
        }
        //ponisti sifru da se ne salje posto nam nije potrebna
        unset($returnArray[0]['sifra']);
        unset($returnArray[1]['sifra']);

    } else if ($status == 2){ //po broju prodatih---------------------------------------------------------
      $stmt1 = $this->connect()->prepare( // da dobijemo ukupnu kolicinu
        "SELECT sum(kupljeni_proizvodi.kolicina) AS kolicina, proizvodi.naziv, proizvodjaci.naziv_proizvodjaca
          FROM kupljeni_proizvodi
            INNER JOIN racuni ON kupljeni_proizvodi.racuni_id = racuni.racuni_id
            INNER JOIN proizvodi ON kupljeni_proizvodi.sifra = proizvodi.sifra
            INNER JOIN proizvodjaci ON proizvodi.proizvodjac_id = proizvodjaci.proizvodjac_id
          WHERE (kupljeni_proizvodi.sifra = ? OR kupljeni_proizvodi.sifra = ?)
            AND (racuni.vreme BETWEEN ? AND ?)
          GROUP BY proizvodi.sifra");
        $stmt1->execute([$firstProductID,$secondProductID, $fromDate , $toDate]);
          if($stmt1->rowCount()>0){
              while($row1 = $stmt1->fetch()){
                  $returnArray [] = array(
                      'a'  => $row1['kolicina'] ,
                      'y'     =>  $row1['naziv'] . " [".$row1['naziv_proizvodjaca'] ."]"
                  );
                  } // END while
                }else{
                  return "";
                }
    }
    return json_encode($returnArray);
}// json_encode_compare_products_chart end;

}
?>
