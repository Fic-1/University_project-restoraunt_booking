<?php
    session_start();
    include_once("funkcije.php");
    prijavaProvjera($_SESSION["korisnikID"]);
?>
<!DOCTYPE>
<html>
    <head>
        <title>Dodaj novi stol</title>
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
$upit = "SELECT idStol FROM stol ORDER BY idRestoran DESC LIMIT 1;";
$rezultat = izvrsiUpit($veza,$upit);
if (!$rezultat) {
   die("Greška: " . mysqli_error($veza));}
$red = mysqli_fetch_assoc($rezultat);
$zadnjiId = $red['idStol'] + 1;
$kontrola = true;
?>

<div class="tablicaAzuriranje">
<form action="" method="POST"><ul><li>
<li><label for="idStol">ID stola: <?php echo $zadnjiId ; ?></label>
<br></li>
<li><label for="Restorani">Izaberi restoran:</label>
            <select style="margin-bottom: 10px;" id="Restorani" name="Restorani">
                <?php
                     $upitRestoran = "SELECT * FROM `restoran`";
                     $rezultat = izvrsiUpit($veza,$upitRestoran);
                     $onClikGet = !empty( $_GET['restoran'] ) ? $_GET['restoran'] : '';
                     if (!$rezultat) {
                         die("Greška: " . mysqli_error($veza));
                       }
                     while ($red = mysqli_fetch_assoc($rezultat)) { ?>
                         <option value="<?php echo $red['idRestoran']?>"> 
                         <?php echo "[" . $red['idRestoran'] . "] -->" . $red['naziv'] ?> </option>";
                        <?php $imeRestorana[] = $red['naziv'];
                         
                       } ?>
            </select><br></li>
<li><label for="brojMjesta">Broj mjesta za sjedenje:</label>
<input type="text" style="margin-bottom: 10px; width: 50px;" name="brojMjesta" value=""required><br></li>
</div>
</tr>
        <div style="display: flex;justify-content: space-evenly; align-items: center;     flex-direction: column;">
                <input class="btn" type="submit" value ="Potvrdi ✔">
                </form>

<?php
    if(isset($_POST['Restorani']) && isset($_POST['brojMjesta']) && $kontrola === true){
    $upitNovo = "INSERT INTO stol (idRestoran, brojMjesta) VALUES ('" . $_POST['Restorani'] ."', '" . $_POST['brojMjesta'] . "');";
    echo "Uspješno dodanao";
    $kontrola = false;
    izvrsiUpit($veza,$upitNovo);
    }
?>
                <form action="admin_stolovi.php">
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