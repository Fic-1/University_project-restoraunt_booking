<?php
    session_start();
?>
<!DOCTYPE>
<html>
    <head>
        <title>Ažuriranje korisnika</title>
        <meta name="author" content="Filip Brković">
        <meta charset="UTF-8">
        <link href="stilovi/stil.css" rel="stylesheet">
        <style>
            .obavijest {
                background-color: Green;
                color: Black;
                font-size: 36px;
                font-weight: bold;
                padding: 20px;
                text-align: center;
                }
                .btn{
                display:flex;
                align-items: center;
                text-align: center;
                margin: auto;
                padding-left: 10px;
                padding-right: 10px;
                font-size: 26px;
                font-weight: bold;
                margin-top: 20px;
                border-radius: 25px;
                background-color: #69d66b;
            }
            .btn:hover {
                cursor: pointer;
                background: linear-gradient(to top left, #28b487, #7dd56f);
                transition: 1.1s;
                color: darkblue;
}
        </style>
    </head>
    <body>
<?php
include_once("funkcije.php");
prijavaProvjera($_SESSION["korisnikID"]);
$veza = spojiSeNaBazu();

$upit = "UPDATE korisnik
SET idKorisnik = " .  $_POST['idKorisnika'] .", ime = '" . $_POST['imeKorisnika'] . "', prezime = '" . $_POST['prezimeKorisnika'] . "', idTipKorisnika = " . $_POST['idTipKorisnika'] . ", email = '" . $_POST['mailKorisnika'] . "', idRestoran = " . $_POST['Restorani']. "
WHERE idKorisnik = " . $_POST['korisnik'];
echo $upit;

$rezultat = izvrsiUpit($veza,$upit);
if (!$rezultat) {
    die("Greška: " . mysqli_error($veza));}

    if ($rezultat) {
    echo "<div class='obavijest'>Uspješno ste ažurirali podatke korisnika: " . $_POST['idKorisnika'] . "</div>";
} else {
    echo "Greška: " . mysqli_error($conn);
}
?>
<form action="admin_korisnici.php">
<button class="btn">Povratak</button>
</form>
</body>
<?php
zatvoriVezuNaBazu($veza)
 ?>
 </html>