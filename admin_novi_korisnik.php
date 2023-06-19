<?php
    session_start();
    include_once("funkcije.php");
    prijavaProvjera($_SESSION["korisnikID"]);
?>
<!DOCTYPE>
<html>
    <head>
        <title>Dodaj novog korisnika</title>
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
$upit = "SELECT idKorisnik FROM korisnik ORDER BY idKorisnik DESC LIMIT 1;";
$rezultat = izvrsiUpit($veza,$upit);
if (!$rezultat) {
   die("Greška: " . mysqli_error($veza));}
$red = mysqli_fetch_assoc($rezultat);
$zadnjiId = $red['idKorisnik'] + 1;
$kontrola = true;
$bezRestorana = null;
?>

<div class="tablicaAzuriranje">
<form action="" method="POST"><ul><li>
<li style="margin-bottom: 10px; ><label for="idKorisnika">ID korisnika: <?php echo $zadnjiId ; ?></label>
<br></li>
<li><label for="idTipKorisnika">Tip korisnika:</label>
<select style="margin-bottom: 10px;" id="idTipKorisnika" name="idTipKorisnika">
    <option value="2" selected>Običan</option>    
    <option value="1">Moderator</option>
    <option value="0">Administrator</option>
    </select><br>
    <li><label for="Restorani">Restoran:</label>
            <select style="margin-bottom: 10px;" id="Restorani" name="Restorani">
                <?php
                     $upit = "SELECT * FROM `restoran`";
                     $rezultat = izvrsiUpit($veza,$upit);
                     if (!$rezultat) {
                         die("Greška: " . mysqli_error($veza));
                       }
                    ?><option value="<?php echo $bezRestorana ?>" selected>--Bez restorana--</option><?php
                     while ($red = mysqli_fetch_assoc($rezultat)) {
                         echo "<option value=" . $red['idRestoran'] . ">" . $red['naziv'] . "</option>";
                         $imeRestorana[] = $red['naziv'];
                         
                       } ?>
            </select><br></li>
<li><label for="korime">Korisnicko ime:</label>
<input type="text" style="margin-bottom: 10px; width: 200px;" name="korime" value="" required><br></li>
<li><label for="lozinka">Lozinka:</label>
<input type="password" style="margin-bottom: 10px; width: 200px;" name="lozinka" value="" required><br></li>
<li><label for="ponLozinka">Ponovljena lozinka:</label>
<input type="password" style="margin-bottom: 10px; width: 200px;" name="ponLozinka" value="" required><br></li>
<li><label for="email">E - adresa:</label>
<input type="text" style="margin-bottom: 10px; width: 350px;" name="email" value=""required><br></li>
<li><label for="ime">Ime:</label>
<input type="text" style="margin-bottom: 10px; width: 200px;" name="ime" value="" required><br></li>
<li><label for="prezime">Prezime:</label>
<input type="text" style="margin-bottom: 10px; width: 200px;" name="prezime" value="" required><br></li>
</div>
</tr>
        <div style="display: flex;justify-content: space-evenly; align-items: center;     flex-direction: column;">
                <input class="btn" type="submit" value ="Potvrdi ✔">
                </form>

<?php
    if(isset($_POST['korime']) && isset($_POST['email']) && isset($_POST['ime']) && isset($_POST['prezime']) && $kontrola === true && ($_POST['lozinka'] === $_POST['ponLozinka'])){
        if($_POST['Restorani']>= 1){
    $upitNovo = "INSERT INTO korisnik (idTipKorisnika, idRestoran, korime, lozinka, email, ime, prezime) 
    VALUES ('" . $_POST['idTipKorisnika'] . "', '" . $_POST['Restorani'] . "', '" . $_POST['korime'] . "', '" . $_POST['lozinka'] . "', '" . $_POST['email'] . "', '" . $_POST['ime'] ."', '" . $_POST['prezime'] ."');";
        }else{
    $upitNovo = "INSERT INTO korisnik (idTipKorisnika, korime, lozinka, email, ime, prezime) 
    VALUES ('" . $_POST['idTipKorisnika'] . "', '" . $_POST['korime'] . "', '" . $_POST['lozinka'] . "', '" . $_POST['email'] . "', '" . $_POST['ime'] ."', '" . $_POST['prezime'] ."');";        
        }
    echo "Uspješno dodanao";
    $kontrola = false;
    izvrsiUpit($veza,$upitNovo);
    }
?>
                <form action="admin_korisnici.php">
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