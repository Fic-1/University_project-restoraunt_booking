<?php session_start();
include_once("funkcije.php");
prijavaProvjera($_SESSION["korisnikID"]); ?>
<!DOCTYPE html>

<html>
    <head>
        <title>Rezerviraj stol!</title>
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
                font-size: 20px; 
                text-align:center;
            }
            label{
                font-size: 20px;
            }
            select{
                font-size: 20px;
            }
            input[type="submit"]{

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
        <div>
        <form action="" method="GET" style="margin-top: 15px; margin-bottom: 30px;">
            <label for="Restorani">Izaberi restoran:</label>
            <select style="margin-bottom: 10px;" id="Restorani" name="Restorani">
                <?php
                     $upit = "SELECT * FROM `restoran`";
                     $rezultat = izvrsiUpit($veza,$upit);
                     $onClikGet = !empty( $_GET['restoran'] ) ? $_GET['restoran'] : '';
                     if (!$rezultat) {
                         die("Greška: " . mysqli_error($veza));
                       }
                     while ($red = mysqli_fetch_assoc($rezultat)) { ?>
                         <option value="<?php echo $red['idRestoran']?>" 
                         <?php echo $onClikGet == $red['idRestoran'] ? 'selected' : ''; ?>> 
                         <?php echo $red['naziv'] ?> </option>";
                        <?php $imeRestorana[] = $red['naziv'];
                         
                       } ?>
            </select><br>
            <label for="datum">Datum rezervacije</label>
            <?php
            $maxDatum = date("d.m.Y", strtotime('+3 months'));
            $maxVrijeme= date("H:i:s", strtotime('+3 hours'));
            $danas = date("d.m.Y");
            $sada = date("H:i:s");
            $sadaKasnije = date("H:i:s", strtotime('+1 hour'));
            ?>
            <input type="text" style="margin-bottom: 10px;" id="datum" name="datum" value="<?php echo $danas; ?>"  max="<?php echo $maxDatum; ?>" required><br>
            <label for="vrijemeOd">Okvirna rezervacija od:</label>
            <input type="text" id="vrijemeOd" name="vrijemeOd" value="<?php echo $sada; ?>" min="08:00" max="21:00" required>
            <label for="vrijemeDo">do:</label>
            <input type="text" id="vrijemeDo" name="vrijemeDo" value="<?php echo $sadaKasnije; ?>" min="08:00" max="21:00" required>
            <input type="submit" value="Pretraži">
            <?php
            if(isset($_GET['vrijemeOd'])){
                $restoran = $_GET['Restorani'];
                $resIme = $imeRestorana[settype($_GET['Restorani'], "string")];
                $datum = date('Y-m-d', strtotime($_GET['datum']));
                $vrijemeOd =  date('H:i:s', strtotime($_GET['vrijemeOd']));
                $vrijemeDo = date('H:i:s', strtotime($_GET['vrijemeDo']));
            ?>
        </form>
            
        <table rules="all" style=" margin-top:10px; border: 1px; solid black; padding:2px; width:70%">
       <?php
            $upit = "SELECT * FROM `stol` WHERE idRestoran = " . $restoran;
            $rezultat = izvrsiUpit($veza,$upit);
                if (!$rezultat) {
                    die("Greška: " . mysqli_error($veza));
                }
                while ($red = mysqli_fetch_assoc($rezultat)) {
                    $idStol[] = $red['idStol'];
                }
            echo "Upit za: " .  $imeRestorana[$restoran - 1] . " ". $datum . " " . $vrijemeOd . " - " . $vrijemeDo;
            ?>
            <tr>
                <th>Ime Restorana</th>
                <th>ID - Broj Stola</th>
                <th>Broj sjedećih mjesta</th>
                <th>Rezerviraj</th>
            </tr>
            <?php
            $upit = "SELECT stol.idStol, stol.idRestoran, stol.brojMjesta, zahtjevRezervacije.idZahtjevRezervacije, zahtjevRezervacije.datumVrijemePocetka, zahtjevRezervacije.datumVrijemeZavrsetka FROM stol LEFT JOIN zahtjevRezervacije ON stol.idStol=zahtjevRezervacije.idStol WHERE idRestoran = " . $restoran . " AND (". "'" . $datum . " " . $vrijemeOd . "'" . " NOT BETWEEN datumVrijemePocetka AND datumVrijemeZavrsetka) AND (". "'" . $datum . " " . $vrijemeDo . "'" . " NOT BETWEEN datumVrijemePocetka AND datumVrijemeZavrsetka OR datumVrijemeZavrsetka IS NULL)  GROUP BY idStol";
            echo "<br>";
            $rezultat = izvrsiUpit($veza,$upit);
                if (!$rezultat) {
                    die("Greška: " . mysqli_error($veza));
                }
                while ($red = mysqli_fetch_assoc($rezultat)) {
                                echo "<form action='potvrda_rez.php' method='POST'>";
                                echo "<tr style=' text-align: center;'>";
                                echo "<td>" . "<input type='hidden' value='" . $imeRestorana[(($restoran)-1)] ."' name='imeRest' >" . $imeRestorana[(($restoran)-1)] . "</td>";
                                echo "<td>" . "<input type='hidden' value='" . $red['idStol'] ."' name='idStol' >" . $red['idStol'] . "</td>" ;
                                echo "<td>" . "<input type='hidden' value='" . $red['brojMjesta'] ."' name='brojMjesta' >" . $red['brojMjesta'] . 
                                            "<input type='hidden' value='" . $datum ."' name='datum' >"   
                                            . "<input type='hidden' value='" . $vrijemeOd ."' name='vrijemeOd' >" . "</td>"
                                            . "<input type='hidden' value='" . $restoran ."' name='idRestoran' >" . "</td>";
                                echo "<td>" . "<input type='submit' class='rezerviraj' value='Rezerviraj'>" . "</td>";
                                echo "</tr></form>";
            }
        }?>
</body>
                    <?php
                        zatvoriVezuNaBazu($veza)
                      ?>
</html>