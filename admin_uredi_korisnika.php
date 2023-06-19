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
                background-color: Green;
                color: Black;
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
prijavaProvjera($_SESSION["korisnikID"]);
$veza = spojiSeNaBazu();
$korisnikId = $_POST['korisnik'];
$upit = "SELECT * FROM korisnik WHERE idKorisnik=" . $_POST['korisnik'];
$rezultat = izvrsiUpit($veza,$upit);
if (!$rezultat) {
    die("Greška: " . mysqli_error($veza));}
?>
<form action="admin_korisnici.php">
<button class="btn">Povratak</button>
</form>
<div class="tablicaAzuriranje">
<?php $red = mysqli_fetch_assoc($rezultat)?>
<form action="admin_uredi_korisnika_proc.php" method="POST"><ul><li>
<li><label for="idKorisnika">ID korisnika</label>
<input type="text" style="margin-bottom: 10px;" name="idKorisnika" value="<?php echo $red['idKorisnik']; ?>"><br></li>
<li><label for="imeKorisnika">Ime korisnika:</label>
<input type="text" style="margin-bottom: 10px;" name="imeKorisnika" value="<?php echo $red['ime']; ?>"><br></li>
<li><label for="prezimeKorisnika">Prezime korisnika:</label>
<input type="text" style="margin-bottom: 10px;" name="prezimeKorisnika" value="<?php echo $red['prezime']; ?>"><br></li>
<li><label for="idTipKorisnika">Tip korisnika:</label>
<select style="margin-bottom: 10px;" id="idTipKorisnika" name="idTipKorisnika">
    <option value="2">Običan</option>    
    <option value="1">Moderator</option>
    <option value="0">Administrator</option>
    </select><br>
<li><label for="mailKorisnika">Mail korisnika:</label>
<input type="text" style="margin-bottom: 10px;" name="mailKorisnika" value="<?php echo $red['email']; ?>"><br></li>
<li><label for="Restorani">Restoran:</label>
            <select style="margin-bottom: 10px;" id="Restorani" name="Restorani">
                <?php
                     $upit = "SELECT * FROM `restoran`";
                     $rezultat = izvrsiUpit($veza,$upit);
                     if (!$rezultat) {
                         die("Greška: " . mysqli_error($veza));
                       }
                     while ($red = mysqli_fetch_assoc($rezultat)) {
                         echo "<option value=" . $red['idRestoran'] . ">" . $red['naziv'] . "</option>";
                         $imeRestorana[] = $red['naziv'];
                         
                       } ?>
            </select><br></li>
                    </ul>
<input type='hidden' name='korisnik' value='<?php echo $korisnikId ?>'>
</div>
</tr>
                <input class="btn" type="submit" value ="Potvrdi">
                </form>
                
</body>
<?php
zatvoriVezuNaBazu($veza)
?>
 </html>