<!DOCTYPE>
<html>
    <head>
        <title>Brisanje rezervacije</title>
        <meta name="author" content="Filip Brković">
        <meta charset="UTF-8">
        <style>
            .obavijest {
                background-color: red;
                color: white;
                font-size: 36px;
                font-weight: bold;
                padding: 20px;
                text-align: center;
                }
        </style>
    </head>
    <body>
<?php
include_once("funkcije.php");
prijavaProvjera($_SESSION["korisnikID"]);
$veza = spojiSeNaBazu();
echo $_POST['Upit'];
$upit =  $_POST['Upit'];

$rezultat = izvrsiUpit($veza,$upit);
if (!$rezultat) {
    die("Greška: " . mysqli_error($veza));}

    if ($rezultat) {
    echo "<div class='obavijest'>Uspješno ste obrisali rezervaciju broj: " . $_POST['brojRez'] . "</div>";
} else {
    echo "Greška: " . mysqli_error($conn);
}
?>
</body>
<?php
zatvoriVezuNaBazu($veza)
 ?>
 </html>