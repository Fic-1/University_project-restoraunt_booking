<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>O autoru stranice</title>
        <meta name="author" content="Filip Brković">
        <meta charset="UTF-8">
        <link href="stilovi/stil.css" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Yusei+Magic&display=swap" rel="stylesheet">
        <style>
            .tablica{
                width: auto;
                margin: 10px auto;
            }
            .stupac1{
                text-align: right;
            }
            .stupac2{
                text-align: center;
                font-weight: bold;
            }
        </style>
    </head>    
    <body style="font-family: Yusei Magic, sans-serif;">
        <div ID="container">
            <nav style="width: 100%;">
                <ul>
                    <li><span>Food-o-mat</span></li>
                    <li ><a href="index.php">Početna</a></li>
                    <li class="active"><a href="o_autoru.php">O autoru</a></li>
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
            <table class="tablica" border="2px">
                <tr>
                    <th rowspan="5" style="width:300px; height:300px;"><img src="slike/ja1.jpg" style="width:300px; height:400px;"></th>
                </tr>
                <tr>
                    <td class="stupac1">Ime i prezime:</td>
                    <td class="stupac2">Filip Brković</td>
                </tr>
                <tr>
                    <td class="stupac1">Broj indeksa/JMBAG:</td>
                    <td class="stupac2">0135242398</td>
                </tr>
                <tr>
                    <td class="stupac1">Mail adresa:</td>
                    <td class="stupac2">fbrkovic20@foi.hr</td>
                </tr>
                <tr>
                    <td class="stupac1">Centar i godina:</td>
                    <td class="stupac2">Zabok - 2022/2023</td>
                </tr>
            </table>
            
        </div>

        <footer id="footer"> 
                <p>Filip Brković - IWA 2022/2023<br> 
                fbrkovic20@student.foi.hr</p>
        </footer>  
    </body>
</html>