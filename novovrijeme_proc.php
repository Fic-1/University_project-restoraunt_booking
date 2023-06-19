<?php
session_start(); 
include_once("funkcije.php");
prijavaProvjera($_SESSION["korisnikID"]);
$veza = spojiSeNaBazu();
date_default_timezone_set("Europe/Zagreb");

$formatDatuma = date("Y-m-d", strtotime($_POST['datum']));
$noviDatumOd = $formatDatuma . " " . $_POST['vrijemeOd'];
$noviDatumDo = $formatDatuma . " " . $_POST['vrijemeDo'];

$upit ="UPDATE zahtjevRezervacije SET datumVrijemePocetka = '". $noviDatumOd . "', " . "datumVrijemeZavrsetka = " . "'" . $noviDatumDo . "', status = 1 WHERE idZahtjevRezervacije = " . $_POST['brojRez'];
echo $upit;
 $rezultat = izvrsiUpit($veza,$upit);
    zatvoriVezuNaBazu($veza);
header('Location: moderator_rezervacije.php');
?>