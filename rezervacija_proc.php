<?php
session_start(); 
include_once("funkcije.php");
prijavaProvjera($_SESSION["korisnikID"]);
$veza = spojiSeNaBazu();
date_default_timezone_set("Europe/Zagreb");
setcookie("imeRestorana", $_GET['imeRestorana']);
setcookie("idStola", $_GET['idStola']);
setcookie("brojOsoba", $_GET['brojOsoba']);
setcookie("datum", $_GET['datum']);
setcookie("vrijemeDolaska", $_GET['vrijeme']);

$formatDatuma = date("Y-m-d", strtotime($_GET['datum']));
$datumPlusSati = strtotime($_GET['datum']);
$satiBoravljenja = settype($_GET['brojSati'], "int");
if($satiBoravljenja > 1){
    $satiBoravljenja ="+" . $_GET['brojSati'] . " hours";
}else{
    $satiBoravljenja = "+" . $_GET['brojSati'] . " hour";
}
$vrijemeDolaska = $_GET['vrijeme'];
$vrijemeOdlaska = date("H:i:s", strtotime($satiBoravljenja, strtotime($vrijemeDolaska)));

$upit = "INSERT INTO `zahtjevRezervacije`( `idKorisnik`, `idStol`, `datumVrijemePocetka`, `datumVrijemeZavrsetka`, `status`, `brojOsoba`) VALUES (" . $_SESSION['korisnikID'] . ", " . $_GET['idStola'] . ", '" . $formatDatuma . " " . $_GET['vrijeme'] . "', '" . $formatDatuma . " " . $vrijemeOdlaska . "', 0," . $_GET['brojOsoba'] . ")";
$rezultat = izvrsiUpit($veza,$upit);
    zatvoriVezuNaBazu($veza);

setcookie("vrijemeOdlaska", $vrijemeOdlaska);
header('Location: potvrda_rez_izvjestaj.php')
?>