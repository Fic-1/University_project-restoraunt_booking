<?php
    session_start();
?>
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
    </head>
 
    <body style="font-family: Yusei Magic, sans-serif;">
        <div ID="container">
            <nav style="width: 100%;">
                <ul>
                    <li><span>Food-o-mat</span></li>
                    <li ><a href="index.php">Početna</a></li>
                    <li><a href="o_autoru.php">O autoru</a></li>
                    <?php if (isset($_SESSION['korisnikID']) <= 0){ ?>
                        <li class="active"><a href="prijava.php">Prijava</a></li>
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
            </div>
            <div class="login">
                <div ID="loginForm">
                   <?php if(@$_GET["krivo"] == true){
                        echo "<p class='alert'>" . $_GET["krivo"] . "</p>"; 
                    }?>
                <form action="prijava_proc.php" method="POST">
                    <label for="korIme">Korisničko ime:</label><br>
                    <input type="text" id="korIme" name="korIme" value="" required><br><br>
                    <label for="korIme">Lozinka:</label><br>
                    <input type="password" id="password" name="password" value="" required><br><br><br>
                    <input ID="submit" type="submit" name="submit" value="Prijavi se">
                </form>
                </div>
            </div>
        


        

    
    </body>

</html>