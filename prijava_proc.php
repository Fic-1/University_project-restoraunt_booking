
<?php var_dump(isset($_POST['submit']));
if(isset($_POST['submit'])){ 
    include_once("funkcije.php");
    


$korIme = $_POST['korIme'];
$password = $_POST['password'];
if(empty($korIme) || empty($password)){
        header("location: prijava.php?error=emptyinput");
    }
    $veza = spojiSeNaBazu();
    $upit =  "SELECT * FROM `korisnik` WHERE lozinka = '" . $_POST['password'] . "'" . " AND korime = '" . $_POST['korIme'] . "'";
    $rezultat = izvrsiUpit($veza,$upit);
    $red = mysqli_fetch_assoc($rezultat);
    $uvijetRez = $red['korime'];
        if (isset($uvijetRez)) {
                session_start();
                $_SESSION["korisnikID"] = $red['idKorisnik'];
                $_SESSION["korisnikTip"] = $red['idTipKorisnika'];
                $_SESSION["korisnikIme"] = $red['ime'];
                $_SESSION["korisnikRestoranId"] = $red['idRestoran'];
    $rezultat = izvrsiUpit($veza,$upit);
    $red = mysqli_fetch_assoc($rezultat);
                header ("location: index.php?uspjeh= uspjesno ste se priavili!");
    } else {
        header ("location: prijava.php?krivo=Upisani su krivi podaci!");
        die("Greška: " . mysqli_error($veza));
    }
}
else {
    header("location: prijava.php");
}



zatvoriVezuNaBazu($veza);
