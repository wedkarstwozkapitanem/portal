<?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        header('Location:/logowanie');
        exit();
    }

    include "php/polocz.php";

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
                                if (!include "php/glowna/trescstrony/menu.php") {
                                    echo "Nie można wyświetlić menu";
                                };
                                ?>


    <div id="cala-strona">


        <div id="caly_profil">

<?php
                                echo '
                                <div class="wyrownaj">
                        <!--<center>-->
                            <div class="goraprofilu">
                                <div class="tlo_profilu"><img loading="lazy" src="/../foty/';
                                        if ($uzytkownik['tlo'] != "" ) {
                                            echo $uzytkownik['tlo'];
                                        } else {
                                            echo "uzytkownik.gif";
                                        }
                                        echo '" alt="tło" /></div>
                                
                                    <div class="awata_profiu"><img loading="lazy" src="/../foty/';
                                        if ($uzytkownik['profilowe'] !== "" && $uzytkownik['profilowe'] !== 'uzytkownik.gif') {
                                            echo $uzytkownik['folder'] ."/profilowe/". $uzytkownik['profilowe'];
                                        } else {
                                            echo 'uzytkownik.gif';
                                        }
                        echo '" alt="profilowe" /></div>
                                   <div class="wyrownaj"> <div style="height:68px"><h1>' . $uzytkownik['imie'] . '  ' . $uzytkownik['nazwisko'] . '</h1></div></div>
                                
                            </div>
                      <!--  </center> -->
                        </div><div class="galeria wysrodkuj"><h2 style="color:yellow;font-size:48px;width:100%;text-align:center;">Zdjecia użytkownika ' . $uzytkownik['imie'] . '  ' . $uzytkownik['nazwisko'] . ':</h2>';


        mysqli_escape_string($baza, $id);
        $sqlpostfoty = "SELECT id,foty FROM `posty` WHERE `iduzytkownika` = '$id' AND `usunieto` = 0 AND foty !='' ORDER BY id DESC";
        if (!$zapytaniepostfoty = mysqli_query($baza, $sqlpostfoty)) {
            if (!file_exists('bledy.txt')) {
                fopen('bledy/bledy.txt', 'w');
            }
            $plik = fopen('bledy/bledy.txt', 'w');
            fwrite($plik, 'Błąd ' . $blod);
            fclose($plik);
            exit();};

        $liczbafot = 0;
        if (mysqli_num_rows($zapytaniepostfoty) > 0) {
            while ($postfoty = $zapytaniepostfoty->fetch_assoc()) {
                if ($postfoty['foty'] != "") {
                    $fota = explode(",", $postfoty['foty']);
                    $liczbazdjecprofilu = count($fota) - 1;

                    for ($i = 0; $i <= $liczbazdjecprofilu; $i++) {
                            echo '<a href="/profil/'.$id.'/post/' . $postfoty['id'] . '"><img loading="lazy" src="/foty/'.$uzytkownik['folder']."/posty/".$fota[$i].'" alt="zdjęcie użytkownika"/></a>';
                            $liczbafot = $liczbafot + 1;
                    }
                }
            }
        } else {
            echo '<h1 style="text-align:center;"> Nie znaleziono zdjęć tego użytkownika</h1>';
        }




                echo "</div>";
                echo "<div class='wroc'><a href='/profil/".$id."'>Wróć do profilu</a></div>";
                            }
                        }

                   
        ?>

                    </body>
                    </html>
                    <style>
                        .galeria {
                            position: relative;
                            width: 100%;
                            display:flex;
                            justify-content: center;
                            align-items: center;
                            flex-wrap: wrap;
                        }
                        .galeria img {
                            width: 288px;
                            height: 288px;
                            margin:10px;
                            border:1px solid silver;
                            border-radius: 8px;
                        }
                    </style>