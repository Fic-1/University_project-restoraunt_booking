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
                    
                    $veza = spojiSeNaBazu();
                    $upit = "SELECT stol.idRestoran, zahtjevRezervacije.*, COUNT(stol.idRestoran) FROM stol INNER JOIN zahtjevRezervacije ON stol.idStol=zahtjevRezervacije.idStol WHERE status = 2 GROUP BY stol.idRestoran ORDER BY `COUNT(stol.idRestoran)` DESC";
                    $rezultat = izvrsiUpit($veza,$upit);
                    if (!$rezultat) { 
                        die("Greška: " . mysqli_error($veza));
                      }
                    while ($red = mysqli_fetch_assoc($rezultat)) {
                        $top_restorani[] =  $red['idRestoran'];                 
                      }
                    $upit ="SELECT * FROM restoran";
                    $rezultat = izvrsiUpit($veza,$upit);
                    while ($red = mysqli_fetch_assoc($rezultat)) {
                        if(in_array($red['idRestoran'],$top_restorani)){
                            continue;
                        }else{
                            $top_restorani[count($top_restorani)] = $red['idRestoran'];
                        } 
                    }
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
                        <li class="active"><a href="administrator.php">Administrator</a></li>
                    <?php }?>
                    <?php if (isset($_SESSION['korisnikID'])== true){ ?>
                        <li><a href="odjava.php">Odjava</a></li>
                    <?php }?>
                </ul>
                </nav>

                <nav class="adminNav" style="width: 37%;">
                <ul>
                    <li class="active"><a href="administrator.php">Statistika</a></li>
                    <li><a href="admin_rezervacije.php">Rezervacije</a></li>
                    <li><a href="admin_stolovi.php">Stolovi</a></li>
                    <li><a href="admin_korisnici.php">Korisnici</a></li>
                    <li><a href="admin_restorani.php">Restorani</a></li>
                </ul>
                </nav>
                

                <div class="karticeStatistika">
                <?php 
              for($i=0; $i < count($top_restorani); $i++){
                $upitPotvrda = "SELECT stol.idRestoran, zahtjevRezervacije.*, COUNT(stol.idRestoran) FROM stol INNER JOIN zahtjevRezervacije ON stol.idStol=zahtjevRezervacije.idStol WHERE status = 2 AND idRestoran =" . $top_restorani[$i]  . "
                GROUP BY stol.idRestoran ORDER BY `COUNT(stol.idRestoran)` DESC";
                $rezultatPotvrda = izvrsiUpit($veza,$upitPotvrda);
                if (!$rezultatPotvrda) {
                    die("Greška: " . mysqli_error($veza));
                  }
                  $redPotvrde = mysqli_fetch_assoc($rezultatPotvrda);
                  $upitUkupno = "SELECT stol.idRestoran, zahtjevRezervacije.*, COUNT(stol.idRestoran) FROM stol INNER JOIN zahtjevRezervacije ON stol.idStol=zahtjevRezervacije.idStol  WHERE idRestoran =" . $top_restorani[$i]  . "
                GROUP BY stol.idRestoran ORDER BY `COUNT(stol.idRestoran)` DESC";
                $rezultatUkupno = izvrsiUpit($veza,$upitUkupno);
                if (!$rezultatUkupno) {
                    die("Greška: " . mysqli_error($veza));
                  }
                  $redUkupno = mysqli_fetch_assoc($rezultatUkupno);
                  @$potvrde = $redPotvrde['COUNT(stol.idRestoran)']; 
                  @$rezervacije = $redUkupno['COUNT(stol.idRestoran)'];
                  $upit = "SELECT * FROM `restoran` WHERE idRestoran =" . $top_restorani[$i];
                          $rezultat = izvrsiUpit($veza,$upit);
                          if (!$rezultat) {
                              die("Greška: " . mysqli_error($veza));
                            }
                            $red = mysqli_fetch_assoc($rezultat);?>
                    <div class="karticeStatistikaChild">
                    <div class="lcolStatistika" style="cursor: pointer; background-image: url(<?php echo $red['slika'];?>
                        );">
                </div>
                    <div class="rcolStatistika brisiMargine" style="margin-right: 10px;">
                        <h2></h2>
                        <h2> <?php echo $red['naziv']; ?> </h2>
                        <p>Adresa: <?php echo $red['adresa']; ?></p>
                        <p>Broj potvrđenih rezervacija: <?php echo $potvrde ?></p>
                        <p>Ukupan broj rezervacija: <?php echo $rezervacije ?></p>
                        <p>Postotak potvrđenih rezervacija: <?php if($potvrde == 0){
                            echo "0%";
                        }else{echo round((($potvrde / $rezervacije)*100),2) . "%"; }?></p>
                    </div>
                    </div>
                    <?php
                 }?>
                    
                </div>


        </div>
    </body>

    <?php 
                        zatvoriVezuNaBazu($veza)
                      ?>
</html>