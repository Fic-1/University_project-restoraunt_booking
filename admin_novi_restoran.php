<?php
    session_start();
    include_once("funkcije.php");
    prijavaProvjera($_SESSION["korisnikID"]);
?>
<!DOCTYPE>
<html>
    <head>
        <title>Dodaj novi restoran</title>
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

$veza = spojiSeNaBazu();
$upit = "SELECT idRestoran FROM restoran ORDER BY idRestoran DESC LIMIT 1;";
$rezultat = izvrsiUpit($veza,$upit);
if (!$rezultat) {
   die("Greška: " . mysqli_error($veza));}
$red = mysqli_fetch_assoc($rezultat);
$zadnjiId = $red['idRestoran'] + 1;
$kontrola = true;
?>

<div class="tablicaAzuriranje">
<form action="" method="POST"><ul><li>
<li><label for="idRestoran">ID Restorana: <?php echo $zadnjiId ; ?></label>
<br></li>
<li><label for="naziv">Naziv:</label>
<input type="text" style="margin-bottom: 10px; width: 200px;" name="naziv" value="" required><br></li>
<li><label for="adresa">Adresa:</label>
<input type="text" style="margin-bottom: 10px; width: 350px;" name="adresa" value=""required><br></li>
<li><label for="slika">Slika:</label>
<input type="text" style="margin-bottom: 10px; width: 550px;" name="slika" placeholder="[HTTPS link]"required><br></li>
                    </ul>
<input type='hidden' name='restoran' value='<?php echo $restoranId ?>'>
</div>
</tr>
        <div style="display: flex;justify-content: space-evenly; align-items: center;     flex-direction: column;">
                <input class="btn" type="submit" value ="Potvrdi ✔">
                </form>

<?php
    if(isset($_POST['naziv']) && isset($_POST['adresa']) && isset($_POST['slika']) && $kontrola === true){
    $upitNovo = "INSERT INTO restoran (naziv, adresa, slika) VALUES ('" . $_POST['naziv'] ."', '" . $_POST['adresa'] ."', '" . $_POST['slika'] . "');";
    echo "Uspješno dodanao";
    $kontrola = false;
    izvrsiUpit($veza,$upitNovo);
    }
?>
                <form action="admin_restorani.php">
                <button class="btn">Povratak ⬅</button>
                </form>
        </div>
        <footer id="footer"> 
                <p>Filip Brković - IWA 2022/2023<br> 
                fbrkovic20@student.foi.hr</p>
        </footer>  
</body>
<?php
zatvoriVezuNaBazu($veza)
?>
 </html>