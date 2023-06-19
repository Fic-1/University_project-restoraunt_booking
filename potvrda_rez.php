<!DOCTYPE html>
<?php session_start();
include_once("funkcije.php");
prijavaProvjera($_SESSION["korisnikID"]);
$imeCookie = "slika";
$vrijednostCookie = ""; 
setcookie($imeCookie,$vrijednostCookie,3600);
?>
<html>
    <head>
        <title>Potvrda rezervacije - Vidimo se!</title>
        <meta name="author" content="Filip Brković">
        <meta charset="UTF-8">
        <link href="stilovi/stil.css" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Yusei+Magic&display=swap" rel="stylesheet">
        <?php
            $veza = spojiSeNaBazu();
            date_default_timezone_set("Europe/Zagreb");
        ?>
        <style>
            input{
                Height: 40px; 
                font-size: 32px; 
                text-align:center;
            }
            label{
                font-size: 32px;
            }
            
        </style>

</head>
<body style="font-family: Yusei Magic, sans-serif;">
    <div ID="container">
        <nav style="width: 100%;">
                <ul>
                    <li><span>Food-o-mat</span></li>
                    <li ><a href="index.php">Početna</a></li>
                    <li><a href="o_autoru.php">O autoru</a></li>
                    <?php if (isset($_SESSION['korisnikID']) <= 0){ ?>
                        <li><a href="prijava.php">Prijava</a></li>
                        <?php } ?>
                      <?php if ((@$_SESSION['korisnikID'])> 0){ ?>
                        <li class="active"><a href="rezervacija_stola.php">Rezerviraj stol</a></li>
                        <li><a href="moj_profil.php">Moj Profil</a></li>
                        <?php }?>
                    <?php if ((@$_SESSION["korisnikTip"] === '1')){ ?>
                        <li><a href="moderator_rezervacije.php">Upravljaj restoranom</a></li>
                    <?php }?>
                    <?php if ((@$_SESSION["korisnikTip"] === '0')){ ?>
                        <li><a href="administrator.php">Administrator</a></li>
                    <?php }?>
                    <?php if (isset($_SESSION['korisnikID'])== true){ ?>
                        <li><a href="odjava.php">Odjava</a></li>
                    <?php }?>
                </ul>
                </nav>
        <h1 style="text-align: center;">Potvrda rezervacije</h1>
       <?php   $upit = 'SELECT * FROM restoran WHERE idRestoran =' . $_POST['idRestoran'];
                    $rezultat = izvrsiUpit($veza,$upit);
                        if (!$rezultat) { 
                        die("Query failed: " . mysqli_error($veza));} ?>
         <div class="potvrda" style="background-image: url(<?php
                        $red = mysqli_fetch_assoc($rezultat);
                        echo $red['slika'];
                        $_SESSION["slikaRezervacija"] = $red['slika'];
                        $vrijednostCookie = $red['slika']; ?>">
        </div>
         <?php 
          $maxDatum = date("d-m-Y", strtotime('+3 months'));
          $maxVrijeme= date("H:i:s", strtotime('+3 hours'));
          $danas = date("d-m-Y");
          $sada = date("H:i:s");
         ?> 
           <?php
           $imeRestoran = $_POST['imeRest'];
           $idStola = $_POST['idStol'] ;
           ?>
        <form action="rezervacija_proc.php" method="GET">
        <div class="centar">
            Restoran: <?php echo $imeRestoran;?><br>
            <input type='hidden' value="<?php echo $imeRestoran ?>" name='imeRestorana' >
            Broj Stola: <?php echo $idStola;?><br>
            <input type='hidden' value="<?php echo $idStola ?>" name='idStola'>
        </div>
            <div ID="brOsoba">
                <label for='brojOsoba'>Broj osoba:</label>   
                <select id='brojOsoba' name='brojOsoba' style='Height: 40px; Width: 50px; font-size: 32px; text-align:center; required'>
                <?php for ($i=1; $i<=$_POST['brojMjesta'];$i++){
                        echo "<option value='" . $i ."'>" . $i ."</option>";
                        }  ?></select>
                        <?php 

                        $datumPar = date_parse($_POST['vrijemeOd']);
                        $vrijemeFormat = $datumPar["hour"] . ":" . $datumPar["minute"];
                        $datumFormat = date('d.m.Y', strtotime($_POST['datum']));
                        date("HH.MM", strtotime($vrijemeFormat));
                        $time =strtotime($vrijemeFormat);
                        ?>
         </div>
            <span><label for="datum">Datum rezervacije</label></span>
            <input type="text" id="datum" name="datum" value="<?php echo $datumFormat ?>"  max="<?php echo $maxDatum; ?>" 
            required><br>
            <label for="vrijeme">Vrijeme rezervacije</label>
            <input type="text" id="vrijeme" name="vrijeme" value="<?php echo $_POST['vrijemeOd']?>" 
            min="08:00" max="21:00" required><br>
            <label for="brojSati">Vrijeme boravka(1:00 - 3:00 sata):</label>
            <input type="time" id="brojSati" name="brojSati" value="01:00" min="01:00" max="03:00" required autofocus><br>
            <input id="potvrdiBtn" type="submit" value="Potvrdi">
            </form>
            <footer id="footer"> 
                <p>Filip Brković - IWA 2022/2023<br> 
                fbrkovic20@student.foi.hr</p>
        </footer>  
</body>
                    <?php
                        zatvoriVezuNaBazu($veza)
                      ?>
</html>
<?php setcookie($imeCookie,$vrijednostCookie); ?>