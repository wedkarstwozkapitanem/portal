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
                </div>';
?>
<h2 style="color:yellow;font-size:48px;width:100%;text-align:center;">Informacje o użytkowniku <?php echo $uzytkownik['imie'] . '  ' . $uzytkownik['nazwisko'] ?>:</h2>
<div id="informacje_profilowe" >

<div class="informacje_profilowe">
<h3>Podstawowe informacje: </h3>
<p>Imie: <strong><?php echo $uzytkownik['imie']?></strong></p>
<p>Nazwisko: <strong><?php echo $uzytkownik['nazwisko']?></strong></p>
<p>Pseudomin: <strong> brak informacji do wyświetlenia </strong></p>
<p>Data urodzenia: <strong> <?php echo $uzytkownik['wiek']?> </strong></p>
<p>Wiek: <strong> <?php echo ((int) date('Y') - (int) substr($uzytkownik['wiek'],0,4)) ?> lat</strong></p>
</div>

<div class="informacje_profilowe">
<h3>Informacje kontaktowe: </h3>
<p>Telefon: <strong><a href="Tel:<?php echo $uzytkownik['numertelefonu']?>"><?php echo $uzytkownik['numertelefonu'] ?></a></strong></p>
</div>

<div class="informacje_profilowe">
<h3>Zainterosowania: </h3>
                    <?php   if ($uzytkownik['hobby'] != "") {
                            $hobby = explode(',',$uzytkownik['hobby']);
                    for ($i = 0; $i < count($hobby); $i++) {
                        echo '
                    <div class="hobbby">
                        <strong> ' . $hobby[$i] . ' </strong>
                    </div>
                   ';
                    }
                } else {
                    echo "<p>Brak informacji do wyświetlenia</p>";
                }?>
</div>

<div class="informacje_profilowe">
<h3>Praca: </h3>
<?php if($uzytkownik['praca']!="") { ?>
<p>Pracuje w: <strong><?php echo $uzytkownik['praca']?></strong></p>
<?php } else {
                    echo "<p>Brak informacji do wyświetlenia</p>"; } ?>
</div>



</div>
<div class='wroc'><a href='/profil/<?php echo $id ?>'>Wróć do profilu</a></div>
<?php

                            }
                        }

                   
        ?>
    <script src="/js/profil.js"></script>
        </body>
</html>
<style>
    #informacje_profilowe {
        display:flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
    } 
    .informacje_profilowe {
        background:silver;
        border: 3px solid wheat;
        border-radius:8px;
        margin-top:28px;
        width:98%;
    }
    #informacje_profilowe p {
        color:black;
        font-size:28px;
    }
    h3 {
        color:black;
        font-size:40px;
    }
    .hobbby {
        font-size:28px;
        color:black;
    }
</style>