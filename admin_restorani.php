<?php
    session_start();
    include_once("funkcije.php");
    prijavaProvjera($_SESSION["korisnikID"]);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Upravljaj restoranom</title>
        <meta name="author" content="Filip Brković">
        <meta charset="UTF-8">
        <link href="stilovi/stil.css" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Yusei+Magic&display=swap" rel="stylesheet">
        <style>
            table{
                margin: 20px;
            }
            #profil{
                display: flex;
                flex-direction: row;
            }
            #lstupac{
                flex: 40;
                padding-right: 20px;
            }
            #rstupac{
                flex: 60;
                padding-right: 20px;
            }
            .brojCentar{
                text-align: center;
            }
            .btn{
                font-size: 12px;
                margin-top: 6px;
                margin: 0;
            }

            #btnIzbor{
                padding-right: 1vw;
            }
            .btnStolRez{
                font-size: 24px;
                margin-top: 6px;
            }
            img {
                height:100px;
                width: 200px;
            }
            </style>
        <?php 
            include_once("funkcije.php");
        ?>
        <?php
                    $veza = spojiSeNaBazu();
        ?>

    </head>
    <body style="font-family: Yusei Magic, sans-serif;">
        <div ID="container">
            <nav style="width: 100%;">
                <ul>
                    <li><span>Food-o-mat</span></li>
                    <li><a href="index.php">Početna</a></li>
                    <li><a href="o_autoru.php">O autoru</a></li>
                    <?php if (isset($_SESSION['korisnikID']) <= 0){ ?>
                        <li><a href="prijava.php">Prijava</a></li>
                        <?php } ?>
                      <?php if ((@$_SESSION['korisnikID'])> 0){ ?>
                        <li><a href="rezervacija_stola.php">Rezerviraj stol</a></li>
                        <li><a href="moj_profil.php">Moj Profil</a></li>
                        <?php }?>
                    <?php if ((@$_SESSION["korisnikTip"] === '1')){ ?>
                        <li class="active"><a href="moderator.php">Upravljaj restoranom</a></li>
                    <?php }?>
                    <?php if ((@$_SESSION["korisnikTip"] === '0')){ ?>
                        <li><a href="administrator.php">Administrator</a></li>
                    <?php }?>
                    <?php if (isset($_SESSION['korisnikID'])== true){ ?>
                        <li><a href="odjava.php">Odjava</a></li>
                    <?php }?>
                </ul>
                </nav>
                <nav class="adminNav" style="width: 37%;">
                <ul>
                    <li><a href="administrator.php">Statistika</a></li>
                    <li><a href="admin_rezervacije.php">Rezervacije</a></li>
                    <li><a href="admin_stolovi.php">Stolovi</a></li>
                    <li><a href="admin_korisnici.php">Korisnici</a></li>
                    <li class="active"><a href="admin_restorani.php">Restorani</a></li>
                </ul>
                </nav>
            <?php



                    $upit = "SELECT * FROM korisnik WHERE idKorisnik =" . $_SESSION["korisnikID"];
                    $rezultat = izvrsiUpit($veza,$upit);
                        if (!$rezultat) {
                            die("Greška: " . mysqli_error($veza));
                        }
                        $red = mysqli_fetch_assoc($rezultat); 
                        $korime = $red['korime'];
                        $ime = $red['ime'];
                        $prezime = $red['prezime'];
                        $email = $red['email'];
                        $korID = $red['idKorisnik'];
                        $restoranId = $red['idRestoran'];
                        
                ?>
                    
                <div ID="rstupac">
                <table class="tablica" style="text-align: center;"border="2px"> 
                        <tr>
                            <th>ID Restorana</th>
                            <th>Naziv</th>
                            <th>Adresa</th>
                            <th>Slika</th>
                            <th>📝</th>
                        </tr>
            <div style="display: flex;justify-content: flex-start;">
            <div style="flex: 87;justify-content: flex-start;">
            <form action="" method="GET">
            <label for="trazi">Pretraži po nazivu: </label>
            <input type="text" style="margin-bottom: 10px;" name="trazi" value="">
            <input class="btn" style="display: inline;  margin-left: 5px;"  type="submit" value ="🔎"></form>
            </div>
            <div style="flex:5;justify-content: flex-end;">
            <form action="admin_novi_restoran.php">
            <input class="btn" style="height: 50px; margin-left: 5px; height: 38px; font-size: 18px;"  type="submit" value ="➕ Dodaj novi restoran"></form>
            </div>
            </div><?php 
            if(@is_null($_GET['trazi'])){
                $upit = "SELECT * FROM restoran";
            }else{
            $upit = "SELECT * FROM restoran WHERE naziv LIKE '%". $_GET['trazi']."%'";
            }
            $rezultat = izvrsiUpit($veza,$upit);
            if (!$rezultat) {
                die("Greška: " . mysqli_error($veza));
              }
            while ($red = mysqli_fetch_assoc($rezultat)){?>
                <tr> 
                    <td><?php $restoranId = $red['idRestoran'];
                        echo $restoranId ; ?> </td>
                    <td><?php echo $red['naziv']; ?> </td>
                    <td><?php echo $red['adresa']; ?> </td>
                    <td><img src="<?php echo $red['slika']?>"></td>
                <td><form action='admin_uredi_restoran.php' target='blank' method='POST'>
                    <input type='hidden' name='restoran' value='<?php echo $restoranId ?>'>
                    <input type='submit' class="btn" value='🔨'>
                    </form>
                    </td>
                </tr> <?php }?>
       
        </div>
        </div>
    </body>

    <?php 
                        zatvoriVezuNaBazu($veza)
                      ?>
</html>