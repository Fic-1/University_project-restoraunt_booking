<?php
    session_start();
?>
<!DOCTYPE>
<html>
    <head>
        <title>Ažuriranje rezervacije</title>
        <meta name="author" content="Filip Brković">
        <meta charset="UTF-8">
        <link href="stilovi/stil.css" rel="stylesheet">
        <style>
            .obavijest {
                background-color: green;
                color: white;
                font-size: 36px;
                font-weight: bold;
                padding: 20px;
                text-align: center;
                }
                .buttonDiv{
                diplay: flex;
                align-items: center;
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

        </style>
    </head>
    <body>
<?php
include_once("funkcije.php");
prijavaProvjera($_SESSION["korisnikID"]);
$veza = spojiSeNaBazu();
$danas = date("d.m.Y");
$sada = date("H:i:00");
$sadaKasnije = date("H:i:00", strtotime('+1 hour'));
if($_POST['status'] !== '1'){
echo $_POST['status'];
$upit =  $_POST['Upit1'] ." " . $_POST['status'] . " " . $_POST['Upit2'];
$rezultat = izvrsiUpit($veza,$upit);
if (!$rezultat) {
    die("Greška: " . mysqli_error($veza));}

    if ($rezultat) {
    echo "<div class='obavijest'>Uspješno ste ažurirali rezervaciju broj: " . $_POST['brojRez'] . "</div>";
} else {
    echo "Greška: " . mysqli_error($conn);
}?>
<form action="moj_profil.php">
<button class="btn">Povratak</button>
</form>
<?php }else{ ?>
<div class="tablicaAzuriranje">
    <table border="2px">
                <tr><form action="novovrijeme_proc.php" method="POST">
                    <td class="stupac1">Korisnik:</td>
                    <td class="stupac2"><?php echo $_POST['imePrezime'];?></td>
                </tr>
                <tr>
                    <td class="stupac1">Broj rezervacije:</td>
                    <td class="stupac2"><?php echo $_POST['brojRez']; ?></td>
                <tr>
                    <td class="stupac1">Datum i vrijeme dolaska:</td>
                    <td class="stupac2"><?php echo $_POST['vrijemePocetka']; ?></td>
                </tr>
                <tr>
                    <td class="stupac1">Datum i vrijeme odlaska</td>
                    <td class="stupac2"><?php echo $_POST['vrijemeZavrsetka']; ?></td>
                </tr> 
                <td class="stupac1">Novi datum Rezervacije:</td>
                    <td class="stupac2"><input type="text" id="datum" name="datum" placeholder="<?php echo $danas; ?>" required><br></td>
                </tr>
                <tr>
                    <td class="stupac1">Novo vrijeme dolaska:</td>
                    <td class="stupac2"><input type="text" id="vrijemeOd" name="vrijemeOd" placeholder="<?php echo $sada; ?>" required></td>
                </tr>
                <tr>
                    <td class="stupac1">Novo vrijeme odlaska</td>
                    <td class="stupac2"><input type="text" id="vrijemeDo" name="vrijemeDo" placeholder="<?php echo $sadaKasnije; ?>" required></td>  
                    <input type='hidden' name='brojRez' value='<?php echo $_POST['brojRez']; ?>'> 
            </table>
</div>
</tr>
                <input class="btn" type="submit" value ="Potvrdi">
                </form>
<?php
} ?>

                    
</body>
<?php
zatvoriVezuNaBazu($veza)
?>
 </html>