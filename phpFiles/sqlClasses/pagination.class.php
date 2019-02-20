<?php
/*
* class GlavniPodaci extends Dbh{
*   function pagination_array_print($stranica, $ukupno_stranica , $start)
*     function proizvodi_get($order_by, $num_per_page, $offset , $sort_param)
*     function korisnici_get($order_by, $num_per_page, $offset , $sort_param)
*     function racuni_get($order_by, $num_per_page, $offset , $sort_param)
*     function create_pagination($current_page, $num_per_page, $table_name, $order_by, $sort_param)
*
*/
class Pagination extends Dbh{
  //constructor ----------------------------------------------------------------
  function __construct(){}
/* *****************************************************************************
*  function pagination_array_print($stranica, $ukupno_stranica){
***************************************************************************** */
  function pagination_array_print($stranica, $ukupno_stranica , $start){
    $sredina =
    	($stranica < 3 || $stranica > $ukupno_stranica - 3)
    	? ceil($ukupno_stranica / 2)
    	: $stranica - 1;
      $sredina = array_keys(array_fill($sredina, 3, 1));
      $levo = array_keys(array_fill(1, 3, 1));
      $desno = array_keys(array_fill($ukupno_stranica-2, 3, 1));
      /* Spoj levu stranu, sredinu i desnu stranu u jedinstvenu matricu */
      $paginacija = array_merge($levo, $sredina, $desno);
      /* Ukloni eventualne duplirane vrednost */
      $paginacija = array_unique($paginacija);
      /* Sortiraj */
      asort($paginacija);
      /* Ključevi nisu po redu. Sredi to. */
      $paginacija = array_values($paginacija);
      /* Pobrini se da maksimalna vrednost ne prelazi izračunati broj stranica (moguće je!) */
      $paginacija = array_slice($paginacija, 0, array_search($ukupno_stranica, $paginacija) + 1);

      /* Gde god je na paginaciji rastojanje između članova veće od 1, ubaci međubroj ili tri tačke */
      $counter = count($paginacija);
      for($i = 1; $i < $counter; $i++) {
      	if (($dif = $paginacija[$i] - $paginacija[$i-1]) > 1) {
      		array_splice($paginacija, $i, 0, $dif == 2 ? $paginacija[$i-1] + 1 : '...');
      		$counter++;
      		$i++;
      	}
      }
      /*************** creating pagination printer ***************************/
      $current_page = $stranica;
      //$start =
      $pages_num = $ukupno_stranica;
      $previous_arrow = ""; $next_arrow = "";
      if($start == 1){$previous_arrow = 'class="disabled"';}
       else { $previous_arrow = "id='".($current_page-1)."'";}

      if( $current_page == $pages_num ){ $next_arrow = 'class="disabled"';}
        else { $next_arrow = "id='".($current_page+1)."'"; }
        //creating echo string for pagination
      $pagination_printer = '<nav>
        <ul class="pagination">
            <li '.$previous_arrow.'>
                <a href="javascript:void(0);">
                    <i class="material-icons">chevron_left</i>
                </a>
            </li>';

      foreach ($paginacija as $key => $value) {
           if($value < 0){
            continue;
          } else if($value == '...'){
            $pagination_printer.=(sizeof($paginacija) > 3 ? "<li ><a >...</a></li>" : "");
          //  $pagination_printer .= "<li ><a >...</a></li>";
          } else if ($value == $current_page){
            $pagination_printer .= "<li class=\"active\"><a href=\"javascript:void(0);\">$value</a></li>";
          } else {
            $pagination_printer .= "<li><a href=\"javascript:void(0);\" class=\"waves-effect\">$value</a></li>";
          }
      }

      $pagination_printer .= "<li $next_arrow >
            <a href=\"javascript:void(0);\" class=\"waves-effect\">
                <i class=\"material-icons\">chevron_right</i>
            </a>
          </li>
        </ul>
      </nav>";
      return $pagination_printer;

      /* Niz je formiran. Transformiši ga u string, potom brojeve pretvori u linkove ka
         odgovarajućim stranicama */
           //print_r($paginacija);
  }
/* *****************************************************************************
*  function proizvodi_get($order_by, $num_per_page, $offset , $sort_param){
***************************************************************************** */
  function proizvodi_get($order_by, $num_per_page, $offset , $sort_param){
    $table_printer = "<table class=' table table-striped'> <thead> <tr class='bg-blue-grey'> <th class='cursor-pointer' page-name='proizvodi_id'> <i class=\"material-icons\">sort</i>id</th> <th class='cursor-pointer' page-name='naziv'><i class=\"material-icons\">sort</i>Naziv Proizvoda</th> <th class='cursor-pointer' page-name='naziv_proizvodjaca'><i class=\"material-icons\">sort</i>Naziv Proizvođača</th> <th class='cursor-pointer' page-name='cena'><i class=\"material-icons\">sort</i>Cena</th> <th class='cursor-pointer' page-name='proizvodi.sifra'><i class=\"material-icons\">sort</i>Šifra</th> <th class='cursor-pointer' page-name='proizvodi.kolicina'><i class=\"material-icons\">sort</i>Količina</th> <th class='cursor-pointer' page-name='proizvodi.jedinica_mere'><i class=\"material-icons\">sort</i>Jedinica Mere</th> </tr> </thead> <tfoot> <tr class='bg-blue-grey'> <th>id</th> <th>Naziv Proizvoda</th> <th>Naziv Proizvođača</th> <th>Cena</th> <th>Šifra</th> <th>Količina</th> <th>Jedinica Mere</th> </tr> </tfoot>";
    $stmt = $this->connect()->prepare(
              "SELECT proizvodi.proizvodi_id, proizvodi.naziv, proizvodjaci.naziv_proizvodjaca, proizvodi.cena, proizvodi.sifra, proizvodi.kolicina, proizvodi.jedinica_mere
              FROM proizvodi INNER JOIN proizvodjaci ON proizvodi.proizvodjac_id = proizvodjaci.proizvodjac_id
              ORDER BY $order_by $sort_param
              LIMIT :limitvar
              OFFSET :offsetvar;"
            );
    $stmt->bindParam(':limitvar', $num_per_page, PDO::PARAM_INT);
    $stmt->bindParam(':offsetvar', $offset, PDO::PARAM_INT);
    $stmt->execute();
    /*              WHERE naziv              LIKE '%$like_param%' OR
                        proizvodi_id       LIKE '%$like_param%' OR
                        naziv_proizvodjaca LIKE '%$like_param%' OR
                        cena               LIKE '%$like_param%' OR
                        sifra              LIKE '%$like_param%' OR
                        kolicina           LIKE '%$like_param%' OR
                        jedinica_mere      LIKE '%$like_param%'*/
    //$stmt->execute([$order_by, $num_per_page, $offset ]);
    /*$stmt = $this->connect()->query(
      'SELECT proizvodi.proizvodi_id, proizvodi.naziv, proizvodjaci.naziv_proizvodjaca, proizvodi.cena, proizvodi.sifra, proizvodi.kolicina, proizvodi.jedinica_mere FROM proizvodi INNER JOIN proizvodjaci ON proizvodi.proizvodjac_id = proizvodjaci.proizvodjac_id ORDER BY proizvodi_id LIMIT 10 OFFSET 0 ; '
    );*/

            if($stmt->rowCount()>0){
              while($row = $stmt->fetch()){
                $table_printer .=
                "<tr><td>".$row['proizvodi_id']."</td>".
                "<td>".$row['naziv']."</td>".
                "<td>".$row['naziv_proizvodjaca']."</td>".
                "<td>".$row['cena']."</td>".
                "<td>".$row['sifra']."</td>".
                "<td>".$row['kolicina']."</td>".
                "<td>".$row['jedinica_mere']."</td></tr>";
              }
            }else{
                return "Greška, podaci su prazni";
            }
      $table_printer .= "</table>";
      return $table_printer;
  }

/* *****************************************************************************
*  function korisnici_get($order_by, $num_per_page, $offset , $sort_param){
***************************************************************************** */
  function korisnici_get($order_by, $num_per_page, $offset , $sort_param){
    $table_printer = "<table class='table table-striped'><thead> <tr class='bg-blue-grey'> <th class='cursor-pointer' page-name='korisnik_id'> <i class=\"material-icons\">sort</i>id</th> <th class='cursor-pointer' page-name='username'><i class=\"material-icons\">sort</i>Korisničko Ime</th> <th class='cursor-pointer' page-name='tip_naloga'><i class=\"material-icons\">sort</i>Tip Naloga</th> <th>Obriši nalog</th> </tr></thead><tfoot> <tr class='bg-blue-grey'> <th>id</th> <th>Korisničko Ime</th> <th>Tip Naloga</th> <th>Obriši nalog</th> </tr></tfoot>";
    $stmt = $this->connect()->prepare(
              "SELECT korisnik_id, username, tip_naloga
              FROM korisnici
              ORDER BY $order_by $sort_param
              LIMIT :limitvar
              OFFSET :offsetvar;"
            );
    $stmt->bindParam(':limitvar', $num_per_page, PDO::PARAM_INT);
    $stmt->bindParam(':offsetvar', $offset, PDO::PARAM_INT);
    $stmt->execute();

            if($stmt->rowCount()>0){
              while($row = $stmt->fetch()){
                $tipNaloga = ($row['tip_naloga']==1 ? "administrator" : "radnik");
                $table_printer .=
                "<tr><td class='data-id'>".$row['korisnik_id']."</td>".
                "<td class='data-username'>".$row['username']."</td>".
                "<td>".$tipNaloga."</td>".
                "<td> <button data-toggle=\"modal\" data-type=\"basic\" data-target=\"#modal_obrisi\" type=\"button\" class=\"btn bg-red waves-effect btn-xs\" id=\"".$row['korisnik_id']."\">
                <i class=\"material-icons\">delete</i></button></th> </td></tr>";
              }
            }else{
                return "Greška, podaci su prazni";
            }
      $table_printer .= "</table>";
      return $table_printer;
  }

/* *****************************************************************************
*  function racuni_get($order_by, $num_per_page, $offset , $sort_param){
***************************************************************************** */
    function racuni_get($order_by, $num_per_page, $offset , $sort_param){
      $table_printer = "<table class='table table-striped'><thead> <tr class='bg-blue-grey'> <th class='cursor-pointer' page-name='racuni_id'> <i class=\"material-icons\">sort</i>ID</th> <th class='cursor-pointer' page-name='vreme'><i class=\"material-icons\">sort</i>Vreme</th> <th class='cursor-pointer' page-name='ukupna_vrednost'><i class=\"material-icons\">sort</i>Ukupna Vrednost</th> </tr></thead><tfoot> <tr class='bg-blue-grey'> <th>ID</th> <th>Vreme</th> <th>Ukupna Vrednost</th> </tr></tfoot>";
      $stmt = $this->connect()->prepare(
                "SELECT * FROM racuni
                ORDER BY $order_by $sort_param
                LIMIT :limitvar
                OFFSET :offsetvar;"
              );
      $stmt->bindParam(':limitvar', $num_per_page, PDO::PARAM_INT);
      $stmt->bindParam(':offsetvar', $offset, PDO::PARAM_INT);
      $stmt->execute();

              if($stmt->rowCount()>0){
                while($row = $stmt->fetch()){
                  $table_printer .=
                  "<tr><td>".$row['racuni_id']."</td>".
                  "<td>".$row['vreme']."</td>".
                  "<td> ".$row['ukupna_vrednost']." </td></tr>";
                }
              }else{
                  return "Greška, podaci su prazni";
              }
        $table_printer .= "</table>";
        return $table_printer;
    }
/* *****************************************************************************
*  function create_pagination($current_page, $num_per_page, $table_name, $order_by){
***************************************************************************** */
  function create_pagination($current_page, $num_per_page, $table_name, $order_by, $sort_param){
    //$current_page = 1;
    //$table_name = "proizvodi";
    //$order_by = "proizvodi_id";

    $total_rows = $this->connect()->query(
      "SELECT count(*) as ukupno FROM ".$table_name.";"
      )->fetchColumn();
    $num_per_page = ($total_rows > 500 ? 25 : 10);
    $pages_num = ceil($total_rows / $num_per_page); //how many pages will be there
    $offset = ($current_page - 1)  * $num_per_page;

    // Some information to display to the user
    $start = $offset + 1;
    //$end = min(($offset + $num_per_page), $total_rows);
    /******************** CREATE TALE *****************************************/
    $table_printer = "";
    switch ($table_name) {
      case 'proizvodi':
        $table_printer = $this->proizvodi_get($order_by, $num_per_page, $offset, $sort_param);
        break;
      case 'korisnici':
        $table_printer = $this->korisnici_get($order_by, $num_per_page, $offset, $sort_param);
        break;
      case 'racuni':
        $table_printer = $this->racuni_get($order_by, $num_per_page, $offset, $sort_param);
        break;
    }

    /******************** END CREATE TABLE ************************************/

    /************** CREATING PAGINATION ***************************************/
    //set next and previous arrow to enable user to move
    // between pages
    $pagination_printer = $this->pagination_array_print($current_page, $pages_num, $start);
    /********************* END CREATING PAGINATION *****************************/
    //merge pagination and table below and return them
    $toNum = ((int)$num_per_page + (int)$offset);
    $toNum = ($toNum > $total_rows ? $total_rows : $toNum );
    $printer_text = $start." - ".$toNum." | od $total_rows zapisa ";
    $bottom_printer = "<div class=\"row\"><div class=\"col-md-8\">$pagination_printer</div>".
                      "<div class=\"col-md-4\"> <br>$printer_text</div></div>";
    return $table_printer .$bottom_printer;

  } // create_pagination

} // class end;
?>
