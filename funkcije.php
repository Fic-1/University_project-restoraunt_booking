<?php

define("POSLUZITELJ","localhost");
define("BAZA","iwa_2022_za_projekt");
define("BAZA_KORISNIK","iwa_2022");
define("BAZA_LOZINKA","foi2022");

function spojiSeNaBazu(){
	$veza = mysqli_connect(POSLUZITELJ,BAZA_KORISNIK,BAZA_LOZINKA);
	
	if(!$veza){
		echo "GREŠKA: 
		Problem sa spajanjem u datoteci baza.php funkcija otvoriVezu:  
		".mysqli_connect_error();
	}
	
	mysqli_select_db($veza,BAZA);
	
	if(mysqli_error($veza)!==""){
		echo "GREŠKA: 
		Problem sa odabirom baze u baza.php funkcija otvoriVezu:  
		".mysqli_error($veza);
	}
	
	mysqli_set_charset($veza,"utf8");
	
	if(mysqli_error($veza)!==""){
		echo "GREŠKA: 
		Problem sa odabirom baze u baza.php funkcija otvoriVezu:  
		".mysqli_error($veza);
	}
	
	return $veza;
}

function izvrsiUpit($veza, $upit){
	
	$rezultat = mysqli_query($veza,$upit);
	
	if(mysqli_error($veza)!==""){
		echo "GREŠKA: 
		Problem sa upitom: ".$upit." : u datoteci baza.php funkcija izvrsiUput:  
		".mysqli_error($veza);
	}
	
	return $rezultat;
}

function zatvoriVezuNaBazu($veza){
	mysqli_close($veza);
}	

function upitTop5Restorana($brojDana){
	$rezultat = "SELECT stol.idStol, COUNT(*), stol.idRestoran, stol.brojMjesta, zahtjevRezervacije.idZahtjevRezervacije, zahtjevRezervacije.datumVrijemeZavrsetka 
	FROM stol LEFT JOIN zahtjevRezervacije ON stol.idStol=zahtjevRezervacije.idStol WHERE zahtjevRezervacije.datumVrijemeZavrsetka >= DATE_SUB(CURDATE(), INTERVAL $brojDana DAY) 
	GROUP BY stol.idRestoran ORDER BY `COUNT(*)` DESC LIMIT 5";
	return $rezultat;
}

function formatVremena($redUpitaIzBaze){
	$formatVremena = date_parse($redUpitaIzBaze);
	$formatSat = $formatVremena["hour"];
	$formatMinuta = $formatVremena["minute"];
	$formatSekunda = $formatVremena["second"];
	$ispisDatuma = $formatVremena["day"] . "." . $formatVremena["month"] . "." . $formatVremena["year"] . " ";
	$ispisVremena = "";
	if($formatSat >=10){$ispisVremena .= $formatSat . ":";}else{$ispisVremena .= "0" . $formatSat . ":";} 
	if($formatMinuta>=10){$ispisVremena .= $formatMinuta. ":";}else{$ispisVremena .= "0" . $formatMinuta . ":";}
	if($formatSekunda>=10){$ispisVremena .= $formatSekunda;}else{$ispisVremena .= "0" . $formatSekunda;};

	return $ispisDatuma . " " . $ispisVremena;
}

function prijavaProvjera($session){
	$pass = "";
	if(isset($session) != true){ $pass = header('Location: index.php'); }
	return $pass;
}
?>

