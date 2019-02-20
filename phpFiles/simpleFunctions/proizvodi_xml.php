<meta charset="utf-8">
<?php

$conn = new mysqli("localhost", "root", "", "naplataproizvoda");

$sql = "SELECT proizvodi.proizvodi_id, proizvodi.naziv, proizvodjaci.naziv_proizvodjaca, proizvodi.cena, proizvodi.sifra, proizvodi.kolicina, proizvodi.jedinica_mere
FROM proizvodi INNER JOIN proizvodjaci ON proizvodi.proizvodjac_id = proizvodjaci.proizvodjac_id;";
$result = $conn->query($sql);

$xml = new DOMDocument('1.0', 'utf-8');
$xml->formatOutput=true;

$proizvodi = $xml->createElement("proizvodi");
$xml->appendChild($proizvodi);

while ($row = $result->fetch_assoc()) {
 $proizvod = $xml->createElement("proizvod");
 $proizvodi->appendChild($proizvod);
 $proizvod->setAttribute("id" ,  $row['proizvodi_id']);

 $naziv_proizvoda = $xml->createElement("nazivProizvoda", $row['naziv']);
 $proizvod->appendChild($naziv_proizvoda);

 $naziv_proizvodjaca = $xml->createElement("naziv_proizvodjaca", $row['naziv_proizvodjaca']);
 $proizvod->appendChild($naziv_proizvodjaca);

 $cena = $xml->createElement("cena", $row['cena']);
 $proizvod->appendChild($cena);

 $sifra = $xml->createElement("sifra", $row['sifra']);
 $proizvod->appendChild($sifra);

 $kolicina = $xml->createElement("kolicina", $row['kolicina']);
 $proizvod->appendChild($kolicina);

 $jedinica_mere = $xml->createElement("jedinica_mere", $row['jedinica_mere']);
 $proizvod->appendChild($jedinica_mere);
}

echo "<xmp>" . $xml->saveXML(). "</xmp>";
?>
