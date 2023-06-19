<?php
    session_start();
    include_once("funkcije.php");
    prijavaProvjera($_SESSION["korisnikID"]);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Moj profil</title>
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
                flex: 20;
                padding-right: 20px;
            }
            #rstupac{
                flex: 80;
                padding-right: 20px;
            }
            .brojCentar{
                text-align: center;
            }
            .btn{
                font-size: 15px;
                margin-top: 6px;
            }
            </style>
        <?php 
            
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
                    <li ><a href="index.php">Početna</a></li>
                    <li><a href="o_autoru.php">O autoru</a></li>
                    <?php if (isset($_SESSION['korisnikID']) <= 0){ ?>
                        <li><a href="prijava.php">Prijava</a></li>
                        <?php } ?>
                      <?php if ((@$_SESSION['korisnikID'])> 0){ ?>
                        <li><a href="rezervacija_stola.php">Rezerviraj stol</a></li>
                        <li class="active"><a href="moj_profil.php">Moj Profil</a></li>
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
            <?php
                    $upit = "SELECT * FROM korisnik WHERE idKorisnik =" . $_SESSION["korisnikID"];
                    $rezultat = izvrsiUpit($veza,$upit);
                        if (!$rezultat) {
                            die("Greška: " . mysqli_error($veza));
                        }
                        while ($red = mysqli_fetch_assoc($rezultat)) {
                        $korime = $red['korime'];
                        $ime = $red['ime'];
                        $prezime = $red['prezime'];
                        $email = $red['email'];
                        $korID = $red['idKorisnik'];
                        }
                ?>
                <?php
                     $upit = "SELECT * FROM `restoran`";
                     $rezultat = izvrsiUpit($veza,$upit);
                     if (!$rezultat) {
                         die("Greška: " . mysqli_error($veza));
                       }
                     while ($red = mysqli_fetch_assoc($rezultat)) {
                         $imeRestorana[] =$red['naziv'];
                       }
                        ?>
            <div ID="profil">
                <div ID="lstupac">     
                    <table class="tablica" border="2px">
                        <tr>
                            <td class="stupac1">Korisnicko ime:</td>
                            <td class="stupac2"><?php echo $korime ;?></td>
                        </tr>
                        <tr>
                            <td class="stupac1">Ime i Prezime:</td>
                            <td class="stupac2"><?php echo $ime . " " . $prezime ;?></td>
                        </tr>
                        <tr>
                            <td class="stupac1">Mail adresa:</td>
                            <td class="stupac2"><?php echo $email ;?></td>
                        </tr>
                    </table>
                    </div>
                <div ID="rstupac">
                <table class="tablica" border="2px"> 
                        <tr>
                            <th>Ime Restorana</th>
                            <th>Broj rezervacije</th>
                            <th>ID - Broj Stola</th>
                            <th>Broj osoba</th>
                            <th>Datum i vrijeme rezervacije</th>
                            <th>Status</th>
                            <th>📝</th>
                        </tr>
                        <?php
                     $upit = "SELECT stol.idRestoran, zahtjevRezervacije.* FROM stol INNER JOIN zahtjevRezervacije ON stol.idStol=zahtjevRezervacije.idStol WHERE idKorisnik =" . $korID . " ORDER BY `zahtjevRezervacije`.`datumVrijemePocetka` DESC";
                     $rezultat = izvrsiUpit($veza,$upit);
                     $rezultatUpdate = izvrsiUpit($veza,$upit);
                     if (!$rezultat) {
                         die("Greška: " . mysqli_error($veza));
                       }
                     while ($red = mysqli_fetch_assoc($rezultat)) { 
                        $formatDatumPocetka = date_parse($red['datumVrijemePocetka']);
                        $formatDatumZavrsetka = date_parse($red['datumVrijemeZavrsetka']);
                        $upitUpdateDa = "UPDATE zahtjevRezervacije SET status = 2 WHERE 
                        idZahtjevRezervacije = "  . $red['idZahtjevRezervacije'];
                        $upitUpdateNe = "UPDATE zahtjevRezervacije SET status = 3 WHERE 
                        idZahtjevRezervacije = "  . $red['idZahtjevRezervacije'];
                        $status = $red['status'];
                        if($status == 1){
                            $status = "Potvrda novog vremena";
                            }elseif ($status == 2) {
                                $status = "Odobreno";
                            }elseif($status == 3) {
                                $status = "Odbijeno";}
                            else{ $status = "Čeka na odobrenja";}                       
                          echo  "<tr>";
                          echo "<td>" . $imeRestorana[$red['idRestoran']-1] . "</td>";
                          echo  "<td class='brojCentar'>" . $red['idZahtjevRezervacije'] . "</td>" ;
                          echo  "<td class='brojCentar'>" . $red['idStol'] . "</td>";
                          echo  "<td class='brojCentar'>" . $red['brojOsoba'] . "</td>";
                          echo "<td class='brojCentar'>"  .  formatVremena($red['datumVrijemePocetka']) . " - " . formatVremena($red['datumVrijemeZavrsetka']) ; 
                          echo "</td>";

                          echo  "<td>" . $status . "</td>";

                        if($red['status'] == '1'){
                          echo  "<td style=''><table><tr><td class='btnOrder'><form action='upit.php' target='blank' method='POST'>
                        <input type='hidden' name='Upit' value='" . $upitUpdateDa ."'>
                        <input type='hidden' name='brojRez' value='" . $red['idZahtjevRezervacije'] ."'>
                          <input class='btn' type='submit' value='✔'>
                          </td></form>
                          <td><form action='upit.php' target='blank' method='POST'>
                        <input type='hidden' name='Upit' value='" . $upitUpdateNe ."'>
                        <input  type='hidden' name='brojRez' value='" . $red['idZahtjevRezervacije'] ."'>
                          <input class='btn' type='submit' value='❌'>
                          </td> </form></td></tr></table>";
                        }else{echo " ";}
                            echo "</tr>";
                    }
                          ?>
                    </table>
                </div>


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