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
            *{
                font-size: 20px;
            }
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
    .tablicaAzuriranje{
        justify-content: space-around;
    }
        </style>

        </style>
    </head>
    <body>
<?php
include_once("funkcije.php");
$veza = spojiSeNaBazu();
echo $_POST['restoran'];
$restoranId = $_POST['restoran'];
$upit = "SELECT * FROM restoran WHERE idRestoran=" . $_POST['restoran'];
$rezultat = izvrsiUpit($veza,$upit);
if (!$rezultat) {
    die("Greška: " . mysqli_error($veza));}
?>
<form action="admin_korisnici.php">
<button class="btn">Povratak</button>
</form>
<div class="tablicaAzuriranje">
<?php $red = mysqli_fetch_assoc($rezultat)?>
<form action="admin_uredi_restoran_proc.php" method="POST"><ul><li>
<li><label for="idRestoran">ID Restorana </label>
<input type="text" style="margin-bottom: 10px; width: 38px;" name="idRestoran" value="<?php echo $red['idRestoran']; ?>"><br></li>
<li><label for="naziv">Naziv:</label>
<input type="text" style="margin-bottom: 10px; width: 200px;" name="naziv" value="<?php echo $red['naziv']; ?>"><br></li>
<li><label for="adresa">Adresa:</label>
<input type="text" style="margin-bottom: 10px; width: 350px;" name="adresa" value="<?php echo $red['adresa']; ?>"><br></li>
<li><label for="slika">Slika:</label>
<input type="text" style="margin-bottom: 10px; width: 550px;" name="slika" value="<?php echo $red['slika']; ?>"><br></li>
                    </ul>
<input type='hidden' name='restoran' value='<?php echo $restoranId ?>'>
</div>
</tr>
                <input class="btn" type="submit" value ="Potvrdi">
                </form>
</body>
<?php
zatvoriVezuNaBazu($veza)
?>
 </html>