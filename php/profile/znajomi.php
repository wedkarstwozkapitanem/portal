<?php

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    exit();
}

include "php/polocz.php";
global $baza;

if (!$_SESSION['uzytkwonik_pixi_id']) {
    session_start();
} else {
    $sesja = (int) mysqli_real_escape_string($baza, htmlspecialchars($_SESSION['uzytkwonik_pixi_id']));
}



if (!$sesja) {
    header('Location:/logowanie');
    exit();
}

if (!$id) {
    include "bledy/nieznaleziono.php";
    exit();
}

?>
<!DOCTYPE html>
<html lang="pl">
<?php
$id = mysqli_real_escape_string($baza, $id);
(string) $sqluzytkownik = "SELECT * FROM `uzytkownicy` WHERE `id` = '$id' LIMIT 1";
try {
    $zapytanieuzytkownik = mysqli_query($baza, $sqluzytkownik);
} catch (Exception $blod) {
    echo "błąd";
    header('Location:/');
    exit();
}


if (mysqli_num_rows($zapytanieuzytkownik) > 0) {
    while ($uzytkownik = $zapytanieuzytkownik->fetch_assoc()) {
?>

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Profil użytkownika</title>
            <link href="/../css/profil.css" rel="stylesheet" type="text/css">
            <link href="/../css/posty.css" rel="stylesheet" type="text/css">
            <link href="/../css/menu.css" rel="stylesheet" type="text/css">
            <link rel="shortcut icon" href="foty/logo.png">
            <meta name="description" content="Pixi.Twoje miejsce do rozmów,rozrywki i czatu z kapitanem">
        </head>

        <body>
            <?php
            if (!include "php/glowna/trescstrony/menu.php") echo "Nie można wyświetlić menu";
            ?>


            <div id="cala-strona">


                <div id="caly_profil">

                    <?php
                    echo '
                        <div class="wyrownaj">
                <!--<center>-->
                    <div class="goraprofilu">
                        <div class="tlo_profilu"><img loading="lazy" src="/../foty/';
                    if ($uzytkownik['tlo'] != "") {
                        echo $uzytkownik['tlo'];
                    } else {
                        echo "uzytkownik.gif";
                    }
                    echo '" alt="tło" /></div>
                        
                            <div class="awata_profiu"><img loading="lazy" src="/../foty/';
                    if ($uzytkownik['profilowe'] !== "" && $uzytkownik['profilowe'] !== 'uzytkownik.gif') {
                        echo $uzytkownik['folder'] . "/profilowe/" . $uzytkownik['profilowe'];
                    } else {
                        echo 'uzytkownik.gif';
                    }
                    echo '" alt="profilowe" /></div>
                           <div class="wyrownaj"> <div style="height:0;" class="nazwauzytkownika"><h1>' . $uzytkownik['imie'] . '  ' . $uzytkownik['nazwisko'] . '</h1></div></div>
                        
                    </div>
              <!--  </center> -->
                </div>';
                    echo '<h2 style="color:yellow;font-size:48px;width:100%;text-align:center;">Znajomi użytkownika ' . $uzytkownik['imie'] . '  ' . $uzytkownik['nazwisko'] . ':</h2>';



                    $id_uzyt = $uzytkownik['id'];
                    $znajomi = mysqli_query($baza, "SELECT * FROM `znajomi`  where (`znajomi`.`iduzytkownika` = '$id_uzyt' or `znajomi`.`iduzytkownik` = '$id_uzyt') and `znajomi`.`czyprzyjeto` = 1");
                    echo '<div class="znajomi">';
                    if (mysqli_num_rows($znajomi) > 0) {
                        while ($znajomy =  mysqli_fetch_assoc($znajomi)) {
                            if ($znajomy['iduzytkownika'] == $id) {
                                $id_znajomego = $znajomy['iduzytkownik'];
                            } else {
                                $id_znajomego = $znajomy['iduzytkownika'];
                            }
                            $znajomydane = mysqli_query($baza, "SELECT * FROM `uzytkownicy` WHERE `id` = '$id_znajomego' LIMIT 1");

                            while ($uzytkownikznajomy = mysqli_fetch_assoc($znajomydane)) {
                    ?>
                                <a href="/profil/<?php echo $uzytkownikznajomy['id'] ?>" style="border-radius:28px;margin-bottom:48px;">
                                    <div class="znajomy">
                                        <?php if ($uzytkownikznajomy['profilowe'] !== "") {  ?>
                                            <img src="/../foty/<?php echo $uzytkownikznajomy['folder'] ?>/profilowe/<?php echo $uzytkownikznajomy['profilowe'] ?>" alt="profilowe znajomego " style="border-radius:28px;" />
                                        <?php } else { ?>
                                            <img src="/../foty/uzytkownik.gif" alt="profilowe znajomego " />
                                        <?php } ?>
                                        <div style="text-align:center;color:white;font-size:18px"><?php echo $uzytkownikznajomy['imie'] . ' ' . $uzytkownikznajomy['nazwisko'] ?></div>
                                    </div>
                                </a>
            <?php
                            }
                        }
                    } else {
                        echo "<div style='font-size:32px;'>Nie ma znajomych ten użytkownik</div>";
                    }

                    echo "</div>";

                    echo "<div class='wroc'><a href='/profil/" . $id . "'>Wróć do profilu</a></div>";
                }
            }


            ?>

            <script src="/js/profil.js"></script>
        </body>

</html>
<style>
    .znajomy {
        width: 288px;
    }

    .znajomy img {
        width: 288px !important;
    }

    .znajomi a {
        width: 288px !important;
    }
</style>