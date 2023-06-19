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
            }
            #btnIzbor{
                padding-right: 1vw;
            }
            .btnStolRez{
                font-size: 24px;
                margin-top: 6px;
            }
            </style>
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
                        <li class="active"><a href="moderator_rezervacije.php">Upravljaj restoranom</a></li>
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
                    <li class="active"><a href="admin_rezervacije.php">Rezervacije</a></li>
                    <li><a href="admin_stolovi.php">Stolovi</a></li>
                    <li ><a href="admin_korisnici.php">Korisnici</a></li>
                    <li><a href="admin_restorani.php">Restorani</a></li>
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
                    </div>
                <div ID="rstupac">
                </div>
                <div ID="rstupac">
                <table class="tablica" style="text-align: center;"border="2px"> 
                        <tr>
                            <th>Ime restorana</th>
                            <th>ID restorana</th>
                            <th>ID rezervacije</th>
                            <th>Broj stola</th>
                            <th>Ime i prezime korisnika</th>
                            <th>Broj osoba</th>
                            <th>Datum i vrijeme rezervacije</th>
                            <th>Status</th>
                            <th>📝</th>
                        </tr>
            <div style="display: flex;justify-content: flex-start;">
            <div style="flex: 87;justify-content: flex-start;">
            <form action="" method="GET">
            <label for="trazi">Pretraži po broju rezervacije: </label>
            <input type="text" style="margin-bottom: 10px;" name="trazi" value="">
            <input class="btn" style="display: inline;  margin-left: 5px;"  type="submit" value ="🔎"></form>
            </div>
            </div><?php 
            if(@is_null($_GET['trazi'])){
            $upit = "SELECT stol.idRestoran, zahtjevRezervacije.* FROM stol INNER JOIN zahtjevRezervacije ON stol.idStol=zahtjevRezervacije.idStol";
        }else{
            $upit = "SELECT stol.idRestoran, zahtjevRezervacije.* FROM stol INNER JOIN zahtjevRezervacije ON stol.idStol=zahtjevRezervacije.idStol WHERE idZahtjevRezervacije LIKE '%". $_GET['trazi']."%'";
            }
            $rezultat = izvrsiUpit($veza,$upit);
            if (!$rezultat) {
                die("Greška: " . mysqli_error($veza));
              }
            while ($red = mysqli_fetch_assoc($rezultat)){
                $status = $red['status'];
                        if($status == 1){
                            $status = "Potvrda novog vremena";
                            }elseif ($status == 2) {
                                $status = "Odobreno";
                            }elseif($status == 3) {
                                $status = "Odbijeno";}
                            else{ $status = "Čeka na odobrenja";} ?>
                <tr> 
                    <td><?php $upitRestoran = "SELECT * FROM restoran WHERE idRestoran=" . $red['idRestoran'];
                    $rezultatRestoran = izvrsiUpit($veza,$upitRestoran);
                    $redRestoran = mysqli_fetch_assoc($rezultatRestoran);
                    echo $redRestoran['naziv']?></td>
                    <td><?php echo $red['idRestoran']; ?> </td>
                    <td><?php echo $red['idZahtjevRezervacije']; ?> </td>
                    <td><?php echo $red['idStol']; ?> </td>
                    <td><?php $upitKorisnik = "SELECT * FROM korisnik WHERE idKorisnik=" . $red['idKorisnik'];
                    $rezultatKorisnik = izvrsiUpit($veza,$upitKorisnik);
                    $redKorisnik = mysqli_fetch_assoc($rezultatKorisnik);
                    $imePrezimeKorisnika = $redKorisnik['ime'] . " " . $redKorisnik['prezime'];
                    echo $imePrezimeKorisnika; ?></td>
                    <td><?php echo $red['brojOsoba']; ?> </td>
                    <td><?php 
                    $vrijemePocetka = formatVremena($red['datumVrijemePocetka']);
                    $vrijemeZavrsetka = formatVremena($red['datumVrijemeZavrsetka']); 
                    echo $vrijemePocetka . " - " . $vrijemeZavrsetka;
                    ?></td>
                    <td><?php echo $status ?> </td>
                    <td><form action='upit_azuriranje.php' target='blank' method='POST'>
                                    <select name ='status'>
                                <?php for($i=1; $i <= 3;$i++){
                                    if($i == 1){
                                        echo "<option value ='" . $i . "'";
                                        echo ">Novo vrijeme </option>";
                                        }elseif ($i == 2) {
                                            echo "<option value ='" . $i . "'";
                                            echo ">Odobri</option>";
                                        }elseif($i == 3) {
                                            echo "<option value ='" . $i . "'";
                                            echo ">Odbij";
                                            }
                                        else{ echo "Čeka na odobrenja</option>";}}?> 
                            </select> </td>
                           <td><?php 
                            $upitAzuriranje1 = "UPDATE zahtjevRezervacije SET status = ";
                            $upitAzuriranje2 = "WHERE idZahtjevRezervacije = " . $red['idZahtjevRezervacije'] ; ?>
                            <input type='hidden' name='Upit1' value='<?php echo $upitAzuriranje1 ?>'>
                            <input type='hidden' name='Upit2' value='<?php echo $upitAzuriranje2 ?>'>
                            <input type='hidden' name='brojRez' value='<?php echo $red['idZahtjevRezervacije'] ?>'>
                            <input type='hidden' name='vrijemePocetka' value='<?php echo $vrijemePocetka ?>'>
                            <input type='hidden' name='vrijemeZavrsetka' value='<?php echo $vrijemeZavrsetka ?>'>
                            <input type='hidden' name='imePrezime' value='<?php echo $imePrezimeKorisnika ?>'>
                            <input type='submit' class="btn" value='✔'>
                            </form>
                            </td>
                </tr>
            <?php }?>
       
        </div>
    </body>

    <?php 
                        zatvoriVezuNaBazu($veza)
                      ?>
</html>