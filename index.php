 <?php session_start(); ?>
 <!DOCTYPE html>

<html>
    <head>
        <title>Food-o-mat - Početna</title>
        <meta name="author" content="Filip Brković">
        <meta charset="UTF-8">
        <link href="stilovi/stil.css" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Yusei+Magic&display=swap" rel="stylesheet">
        <?php 
            include_once("funkcije.php");
        ?>

        <?php
                    $veza = spojiSeNaBazu();
                    $upit = upitTop5Restorana(30);
                    $rezultat = izvrsiUpit($veza,$upit);
                    if (!$rezultat) { 
                        die("Greška: " . mysqli_error($veza));
                      }
                    while ($red = mysqli_fetch_assoc($rezultat)) {
                        $top_restorani[] =  $red['idRestoran']; 
                        $broj_rezervacija[] = $red['COUNT(*)'];                     
                      }
                      ?>

    </head>    
    <body style="font-family: Yusei Magic, sans-serif;">
        <div ID="container">
            <header>
            <nav style="width: 100%;">
                <ul>
                    <li><span>Food-o-mat</span></li>
                    <li class="active"><a href="index.php">Početna</a></li>
                    <li><a href="o_autoru.php">O autoru</a></li>
                    <?php if (isset($_SESSION['korisnikID']) <= 0){ ?>
                        <li><a href="prijava.php">Prijava</a></li>
                        <?php } ?>
                      <?php if ((@$_SESSION['korisnikID'])> 0){ ?>
                        <li><a href="rezervacija_stola.php">Rezerviraj stol</a></li>
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
                    </header>
                
            <h1 style="text-align: center;"><?php if(isset($_SESSION["korisnikIme"])){ echo "Pozdrav " . $_SESSION["korisnikIme"] . " 😊 <br>";} ?>Najpopularniji restorani</h1>

            <div class="kartice">
                <div class="lcol" onclick="location.href='rezervacija_stola.php?restoran=<?php echo $top_restorani[0] ?>';" style="cursor: pointer; background-image: url(<?php 
                    $upit = "SELECT * FROM restoran WHERE idRestoran = '$top_restorani[0]'";
                    $rezultat = izvrsiUpit($veza,$upit);
                    if (!$rezultat) { 
                        die("Query failed: " . mysqli_error($veza));} 
                        $red = mysqli_fetch_assoc($rezultat);
                        echo $red['slika'];
                        ?>
                        );">
                </div>
                <div class="rcol brisiMargine" ID="prvi_rest_rcol">
                    <h2 style="color: #896C05; font-weight: bold;">#1</h2>
                    <h2> <?php echo $red['naziv']; ?> </h2>
                    <p>Adresa: <?php echo $red['adresa']; ?></p>
                    <p>Broj rezervacija prošli mjesesc:<?php echo " " . $broj_rezervacija[0]; ?></p>
                </div>  
            </div>
                <div class="kartice">
                    <div class="lcol" onclick="location.href='rezervacija_stola.php?restoran=<?php echo $top_restorani[1] ?>';" style="cursor: pointer; background-image: url(<?php 
                    $upit = "SELECT * FROM restoran WHERE idRestoran = '$top_restorani[1]'";
                    $rezultat = izvrsiUpit($veza,$upit);
                    if (!$rezultat) { 
                        die("Query failed: " . mysqli_error($veza));} 
                        $red = mysqli_fetch_assoc($rezultat);
                        echo $red['slika'];
                        ?>
                        );">
                </div>
                    <div class="rcol brisiMargine" style="margin-right: 10px;">
                        <h2>#2</h2>
                        <h2> <?php echo $red['naziv']; ?> </h2>
                        <p>Adresa: <?php echo $red['adresa']; ?></p>
                        <p>Broj rezervacija prošli mjesesc:<?php echo " " . $broj_rezervacija[1]; ?></p>
                    </div>  
                
                    <div class="lcol" onclick="location.href='rezervacija_stola.php?restoran=<?php echo $top_restorani[2] ?>';" style="cursor: pointer;background-image: url(<?php 
                    $upit = "SELECT * FROM restoran WHERE idRestoran = '$top_restorani[2]'";
                    $rezultat = izvrsiUpit($veza,$upit);
                    if (!$rezultat) { 
                        die("Query failed: " . mysqli_error($veza));} 
                        $red = mysqli_fetch_assoc($rezultat);
                        echo $red['slika'];
                        ?>
                        );">
                </div>
                    <div class="rcol brisiMargine" style="margin-right: 10px;">
                        <h2>#3</h2>
                        <h2> <?php echo $red['naziv']; ?> </h2>
                        <p>Adresa: <?php echo $red['adresa']; ?></p>
                        <p>Broj rezervacija prošli mjesesc:<?php echo " " . $broj_rezervacija[2]; ?></p>
                    </div>     
                </div>     
                <div class="kartice">
                    <div class="lcol" onclick="location.href='rezervacija_stola.php?restoran=<?php echo $top_restorani[3] ?>';" style="cursor: pointer;background-image: url(<?php 
                    $upit = "SELECT * FROM restoran WHERE idRestoran = '$top_restorani[3]'";
                    $rezultat = izvrsiUpit($veza,$upit);
                    if (!$rezultat) { 
                        die("Query failed: " . mysqli_error($veza));} 
                        $red = mysqli_fetch_assoc($rezultat);
                        echo $red['slika'];
                        ?>
                        );">
                </div>
                    <div class="rcol brisiMargine" style="margin-right: 10px;">
                        <h2>#4</h2>
                        <h2> <?php echo $red['naziv']; ?> </h2>
                        <p>Adresa: <?php echo $red['adresa']; ?></p>
                        <p>Broj rezervacija prošli mjesesc:<?php echo " " . $broj_rezervacija[3]; ?></p>
                    </div>    

                    <div class="lcol" onclick="location.href='rezervacija_stola.php?restoran=<?php echo $top_restorani[4] ?>';" style="cursor: pointer;background-image: url(<?php 
                    $upit = "SELECT * FROM restoran WHERE idRestoran = '$top_restorani[4]'";
                    $rezultat = izvrsiUpit($veza,$upit);
                    if (!$rezultat) { 
                        die("Query failed: " . mysqli_error($veza));} 
                        $red = mysqli_fetch_assoc($rezultat);
                        echo $red['slika'];
                        ?>
                        );">
                </div>
                    <div class="rcol brisiMargine" style="margin-right: 10px;">
                        <h2>#5</h2>
                        <h2> <?php echo $red['naziv']; ?> </h2>
                        <p>Adresa: <?php echo $red['adresa']; ?></p>
                        <p>Broj rezervacija prošli mjesesc:<?php echo " " . $broj_rezervacija[4]; ?></p>
                    </div> 
                </div>
                <footer id="footer"> 
                <p>Filip Brković - IWA 2022/2023<br> 
                fbrkovic20@student.foi.hr</p>
        </footer>    
        </div>       
    </body>
                      <?php 
                        zatvoriVezuNaBazu($veza)
                      ?>
</html>