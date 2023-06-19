<!DOCTYPE html>
<?php session_start(); 
include_once("funkcije.php");
prijavaProvjera($_SESSION["korisnikID"]);
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
            .stupac2{
                font-weight: bold;
                text-align: center;
            }
            .buttonDiv{
                diplay: flex;
                align-items: center;
            }
            button{
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
            Button:hover {
                cursor: pointer;
                background: linear-gradient(to top left, #28b487, #7dd56f);
                transition: 1.1s;
                color: darkblue;
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
            <h1 id="zahvala" style="">Hvala ti na rezervaciji <?php echo $_SESSION["korisnikIme"]?>! 😄</h1>
         <div class="potvrda" style="background-image: url(<?php
                        echo $_SESSION["slikaRezervacija"];?>)">
            </div>
            <?php 
            ?>
            <table class="tablica" border="2px">
                <tr>
                    <td class="stupac1">Ime restorana</td>
                    <td class="stupac2"><?php echo $_COOKIE['imeRestorana'];?></td>
                </tr>
                <tr>
                    <td class="stupac1">Broj rezerviranog stola:</td>
                    <td class="stupac2"><?php echo $_COOKIE['idStola']; ?></td>
                </tr>
                <tr>
                    <td class="stupac1">Broj osoba:</td>
                    <td class="stupac2"><?php echo $_COOKIE['brojOsoba']; ?></td>
                </tr>
                <tr>
                    <td class="stupac1">Datum Rezervacije:</td>
                    <td class="stupac2"><?php echo $_COOKIE['datum']; ?></td>
                </tr>
                <tr>
                    <td class="stupac1">Vrijeme dolaska:</td>
                    <td class="stupac2"><?php echo $_COOKIE['vrijemeDolaska']; ?></td>
                </tr>
                <tr>
                    <td class="stupac1">Vrijeme odlaska</td>
                    <td class="stupac2"><?php echo $_COOKIE['vrijemeOdlaska']; ?></td>
                </tr>
            </table>
            <div id="buttonDiv">
                <form action="moj_profil.php">
                    <button>Vidimo se!</button>
                </form>
        </div>
        </body>
</html>