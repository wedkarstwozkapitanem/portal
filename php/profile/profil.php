<?php
try {
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        header('Location:/logowanie');
        exit();
    }

    include "php/polocz.php";

    if (!$_SESSION['uzytkwonik_pixi_id']) {
        session_start();
    } else {
        $sesja = (int) mysqli_real_escape_string($baza,htmlentities($_SESSION['uzytkwonik_pixi_id']));
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

            try {
                if (mysqli_num_rows($zapytanieuzytkownik) > 0) {
                    while ($uzytkownik = $zapytanieuzytkownik->fetch_assoc()) { 
                        ?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil użytkownika</title>
    <link href="../css/profil.css" rel="stylesheet" type="text/css">
    <link href="../css/posty.css" rel="stylesheet" type="text/css">
    <link href="../css/menu.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="foty/logo.png">
    <meta name="description" content="Pixi.Twoje miejsce do rozmów,rozrywki i czatu z kapitanem">
</head>

<body>
<?php
        if (!include "php/glowna/trescstrony/menu.php") {
            echo "Nie można wyświetlić menu";
        }
        ;
        ?>


    <div id="cala-strona">


        <div id="caly_profil">

<?php
                        echo '
                <div class="wyrownaj">
        <!--<center>-->
            <div class="goraprofilu">
                <div class="tlo_profilu"><img src="/../foty/';
                        if ($uzytkownik['tlo'] != "" ) {
                            echo $uzytkownik['tlo'];
                        } else {
                            echo "uzytkownik.gif";
                        }
                        echo '" alt="tło" /></div>
                
                    <div class="awata_profiu"><img src="/../foty/';
                        if ($uzytkownik['profilowe'] !== "" && $uzytkownik['profilowe'] !== 'uzytkownik.gif') {
                            echo $uzytkownik['folder'] ."/profilowe/". $uzytkownik['profilowe'];
                        } else {
                            echo 'uzytkownik.gif';
                        }
                        echo '" alt="profilowe" /></div>
                   <div class="wyrownaj"> <div><h1>' . $uzytkownik['imie'] . '  ' . $uzytkownik['nazwisko'] . '</h1></div></div>
                
            </div>
      <!--  </center> -->
        </div>
        <div class="wyrownaj">';



                        echo '</div>';

                        if ($id != $sesja) {
                            echo '<button onclick="otworzdymekwiadomosc(' . $uzytkownik['id'] . ')" style="left:108px;" class="dodajznajomego wiad"> Napisz wiadomość </button>';



                            $sqlczyznaj = "SELECT * FROM (SELECT * FROM `znajomi` where `iduzytkownika` = '$sesja' OR `iduzytkownik` = '$sesja') as p where `iduzytkownika` = '$id' OR `iduzytkownik` = '$id' LIMIT 1";
                            $czyznaj = mysqli_query($baza, $sqlczyznaj);
                            if (mysqli_num_rows($czyznaj) > 0) {
                                while ($czyznajomy = $czyznaj->fetch_assoc()) {
                                    if ($czyznajomy['czyprzyjeto'] == 1) {
                                        echo '<button onclick="dodajznajomego()" style="right:108px;background:white !important;" class="dodajznajomego" id="dodajznaj" > Znajomi </button>';
                                    } else {
                                        if ($czyznajomy['iduzytkownika'] == $sesja) {
                                            echo '<button onclick="dodajznajomego();" style="right:108px;background:silver !important;" class="dodajznajomego" id="dodajznaj" > Zaproszenie wysłane </button>';
                                        } else {
                                            echo '<button onclick="dodajznajomego();" style="right:108px;background:yellow !important;" class="dodajznajomego" id="dodajznaj" > Przyjmij zaproszenie </button>';
                                        }
                                    }
                                }
                            } else {
                                echo '<button onclick="dodajznajomego();" style="right:108px;" class="dodajznajomego" id="dodajznaj"> Dodaj do znajomych </button>';
                            }
                        }
                        echo '<div class="profilwszystko">
        <div class="lewa_burta">
            <div class="lewa_burta_info">
  
                <h2 style="width:58%;float:left;text-align:center;">Informacje:</h2><a style="position:relative;top:28px;margin-left:12px;" href="profil?id=' . $uzytkownik['id'] . '&informacje=' . $uzytkownik['id'] . '">Zobacz szczegółowe informacje</a><div style="clear:both;"></div>';
                        if ($sesja == $uzytkownik['id']) { //mój profil
                            echo '<center><button class="profiledytujinformacje" id="profiledytujinformacje"> Edytuj informacje </button></center>';

                            echo '
                    <div class="wyrownaj">
                    <!--<center>-->
                    <div class="profiledytujinfo" style="display: none;">
                    <div class="dodawanie_informacji">
                    <h1 style="float:left;color:black;"> Edytuj informacje: </h1>
                    <div class="profilzamknijedytujinfo" style="float:right;" onclick="document.querySelector(\'.profiledytujinfo\').style.display=\'none\';document.getElementById(\'profiledytujinformacje\').style.display = \'block\';document.getElementById(\'profilinfo\').style.display = \'block\'" > X </div>
                    <hr style="clear:both;">
                    <form method="POST" action="centrum-dowodzenia.php">
                    <input type="hidden" name="akcja" value="edytujinformacjeprof" />
                    
                    <h3> Adres zamieszkania:</h3>
                    <input type="text" placeholder="Gdzie mieszkasz?" name="miejscowosc" value="' . $uzytkownik['miejscowosc'] . '"/>
                    <h3>Praca:</h3>
                    <input type="text" placeholder="Gdzie pracujesz?" name="praca" value="' . $uzytkownik['praca'] . '" />
                    <h3>  Hobby: </h3>
                    <input type="text" placeholder="Twoje hobby" name="hobby" value="' . $uzytkownik['hobby'] . '"/>
                    <h3>linki:</h3>
                    <input type="text" placeholder="linki" name="linki" value="' . $uzytkownik['linki'] . '" />
                    
                    <input type="submit" value="Zatwierdz" />
                    </form>
                    
                    </div>
                    </div>
                   <!-- </center> -->
                    </div>
                    <script>
                    document.getElementById(\'profiledytujinformacje\').addEventListener(\'click\', () => {
                document.querySelector(\'.profiledytujinfo\').style.display = "block";
                document.getElementById(\'profiledytujinformacje\').style.display = "none";
                document.getElementById(\'profilinfo\').style.display = \'none\';

                    })
                </script>
                    ';
                        }
                        echo '
                <div id="profilinfo" style="max-width: 100%;">';
                        if ($uzytkownik['miejscowosc'] != "") {
                            echo '<p>Mieszka w ' . $uzytkownik['miejscowosc'] . '</p>';
                        }
                        if ($uzytkownik['praca'] != "") {
                            echo '<p>Pracuje w: ' . $uzytkownik['praca'] . '</p>';
                        }
                        if ($uzytkownik['hobby'] != "") {
                            $hobby = str_replace(",", "</div><div>", $uzytkownik['hobby']);
                            echo '<p>Hobby:
                    <div class="hobby">
                        <div> ' . $hobby . ' </div>
                    </div>
                    </p>';
                        }
                        if ($uzytkownik['linki'] != "") {
                            echo '<p style="color:blue;">Liniki: <br>
                        <a href="' . $uzytkownik['linki'] . '">' . $uzytkownik['linki'] . '</a>
                    </p>';
                        }
                        echo '     
                    <p>Wiek: ' . $uzytkownik['wiek'] . ' lat </p>
                    ';
                        echo '        
                    <p>Data dołączenia:' . $uzytkownik['datadoloczenia'] . '</p>
                    ';



                        echo '
                </div>
            </div>';






                        echo '<div class="lewa_burta_info"><h2 style="width: 44%;float: left;">Zdjęcia:</h2><a href="profil.php?id=' . $uzytkownik['id'] . '&zdjecia=' . $uzytkownik['id'] . '" style="position:relative;top:28px;margin-left:8px;">Przejdz do wszystkich zdjęć</a><div style="clear:both"></div><div class="zdjecia_profilu">';
//posty
                        mysqli_escape_string($baza, $id);
                        $sqlpostfoty = "SELECT id,foty FROM `posty` WHERE `iduzytkownika` = '$id' ORDER BY id DESC LIMIT 9";
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
                                        if ($liczbafot <= 8) {
                                            echo '<a href="/profil/'.$id.'/post/' . $postfoty['id'] . '"><img src="/foty/'.$uzytkownik['folder']."/posty/".$fota[$i].'" alt="zdjęcie użytkownika"/></a>';
                                            $liczbafot = $liczbafot + 1;
                                        } else {
                                            break;
                                        }
                                    }
                                }
                            }
                        } else {
                            echo '<h1 style="text-align:center;"> Nie znaleziono zdjęć tego użytkownika</h1>';
                        }







                        echo '                  </div> </div>';











                        echo '<div class="lewa_burta_info"><h2 style="width: 44%;float: left;">Znajomi:</h2><a href="profil.php?id=' . $uzytkownik['id'] . '&znajomi=' . $uzytkownik['id'] . '" style="position:relative;top:28px;margin-left:8px;">Zobacz wszystkich znajomych</a></div>';









                        echo '
            </div>
             <div id="profil_posty" class="wysrodkuj">
<div style="top:10px;" class="posty">Posty:</div>


            <center>';
                        if ($sesja == $uzytkownik['id']) {
                            echo '<button class="profiledytujinformacje dodaj-post" style="margin-top:68px !important;">Dodaj posta </button>
            ';
                        }
                    }


                    $zapytanie_post = "SELECT * FROM `posty` WHERE `iduzytkownika` = '$id' ORDER BY `id` DESC";
                    $wynik_post = mysqli_query($baza, $zapytanie_post);

                    if (mysqli_num_rows($wynik_post) > 0) {
                        while ($post = mysqli_fetch_assoc($wynik_post)) {


                            $idu = htmlentities($post['iduzytkownika']);
                            mysqli_real_escape_string($baza, $idu);
                            $zapytanie_profil = "SELECT `id`,`imie`,`nazwisko`,`profilowe`,`folder` FROM `uzytkownicy` where `id` = '$idu'";
                            $wynik_profil = mysqli_query($baza, $zapytanie_profil);

                            while ($uzytkownik = mysqli_fetch_row($wynik_profil)) {
                                ?>
                            <article>
                                <div class="post">
                                    <div class="post_informacje"><a href='/profil/<?php echo $post['iduzytkownika'] ?>' style="z-index:12;">
                                            <div>
                                                <?php 
                                                if ($uzytkownik[3] !== "" && $uzytkownik[3] !== "uzytkownik.gif")  {
                                                ?>
                                                <img src="/../foty/<?php echo $uzytkownik[4] ?>/posty/<?php echo $uzytkownik[3] ?>" alt="profilowe" />
<?php } else { ?>
    <img src="/../foty/uzytkownik.gif" alt="profilowe" />
    <?php } ?>
    </div>
                                        </a>
                                        <a href="/profil/<?php echo $post['iduzytkownika'] ?>">
                                            <div class="post_imie"><?php echo $uzytkownik[1] . ' ' . $uzytkownik[2] ?></div>
                                        </a>
                                        <div class="post_data"><a href="/profil/<?php echo $post['iduzytkownika'] ?>/post/<?php echo $post['id'] ?>"><time><?php echo $post['datadodania'] ?></time></a><button style="border-radius:8px;margin: 2px 0 0 8px;background:silver;">Dodał/a posta</button></div>
                                        <div class="opcjeposta opcjeposta_usuwanie wysrodkowanie" onclick="menuposta(this)" data-postid="<?php echo $post['id'] ?>"><span style="top:-10px;">...</span></div>
                                    
                                        <div class="menu_posta_opcje" style="display:none;" data-opcje_posta="<?php echo $post['id'] ?>">
                                            <?php if($post['iduzytkownika'] == $sesja) { ?>
                                            <?php if ($post['foty'] != "" && isset($post['foty'])) { ?>
                                            <button onclick="zaktalizuj_profilowe(<?php echo $post['id'] ?>)">Zaktalizuj profilowe tym zdjęciem</button>
                                            <?php } ?>
                                            <button>Usuń</button>
                                            <?php } else { ?>
                                            <button>Zgłoś</button>
                                            <button>Zapisz</button>
                                           <?php } ?>
                                        </div>


                                    </div>
                                    <div class="post_tresc">
                                        <?php echo $post['tresc'] ?>
                                        <div class="post_zdjecia">
                                        <?php
                                        if ($post['foty'] != "" && isset($post['foty'])) {
                                            if ((array) $lista_fot = explode(",", $post['foty'])) {
                                                if ($lista_fot[0] !== "" && !empty($lista_fot)) {
                                                    foreach ($lista_fot as $fotka) {
                                                        echo "<img src='/foty/" . $uzytkownik[4] . "/posty/" . $fotka . "' alt='zdjecie posta' />";
                                                    }
                                                }
                                            }
                                        }
                    ?>
                                        </div>
                                    </div>
                                    <div class="licznik_posta">
                
                                        <?php
                                        (int)$id_posta = htmlentities($post['id']);
                                        mysqli_escape_string($baza, $id_posta);
                                        $sprawdz = "SELECT `id_uzytkownika`,`id_posta` FROM `polubienia` WHERE `id_posta`= '$id_posta'";
                                        $sprawdzanie = mysqli_query($baza, $sprawdz);

                                        if (mysqli_num_rows($sprawdzanie) >= 2) {
                                            echo '<div class="licznik_polubien" data-postid-licznikpolubien="' . trim($post['id']) . '"><span>' . mysqli_num_rows($sprawdzanie) . ' </span><span class="polubienie"> polubienia</span></div>';
                                        } else if (mysqli_num_rows($sprawdzanie) === 1) {
                                            echo '<div class="licznik_polubien" data-postid-licznikpolubien="' . trim($post['id']) . '"><span>1</span><span class="polubienie"> polubienie</span></div>';
                                        } else if (mysqli_num_rows($sprawdzanie) === 0) {
                                            echo '<div class="licznik_polubien" data-postid-licznikpolubien="' . trim($post['id']) . '"><span></span><span class="polubienie"> Brak polubień</span></div>';
                                        }


                                        $liczbakomentarzy = mysqli_query($baza, "SELECT * FROM `komentarze` where `idposta` = '$id_posta'");
                                        if (mysqli_num_rows($liczbakomentarzy) === 0) {
                                            ?>
                                            <div class="licznik_komentarzy" onclick="pokazkomentarze(this)" data-postid="<?php echo $post['id'] ?>"><span data-postid-licznikomentarzyp="<?php echo trim($post['id']) ?>"></span><span data-postid-licznikomentarzy="<?php echo trim($post['id']) ?>"> Brak komentarzy</span></div>
                                        <?php } else if (mysqli_num_rows($liczbakomentarzy) === 1) { ?>
                                            <div class="licznik_komentarzy" onclick="pokazkomentarze(this)" data-postid="<?php echo $post['id'] ?>"><span data-postid-licznikomentarzyp="<?php echo trim($post['id']) ?>">1</span><span data-postid-licznikomentarzy="<?php echo trim($post['id']) ?>"> komentarz</span></div>
                                        <?php } else { ?>
                                            <div class="licznik_komentarzy" onclick="pokazkomentarze(this)" data-postid="<?php echo $post['id'] ?>"><span data-postid-licznikomentarzyp="<?php echo trim($post['id']) ?>"><?php echo mysqli_num_rows($liczbakomentarzy); ?></span><span data-postid-licznikomentarzy="<?php echo trim($post['id']) ?>"> komentarze</span></div>
                                        <?php }
                                         mysqli_free_result($liczbakomentarzy);
                                        ?>
                                        <div class="licznik_udustepnien"><span>4</span> udostępnienia</div>
                
                                    </div>
                                    <div class="post_akcja srodkowanie">
                
                                        <?php
                                        $sprawdz = "SELECT `id_uzytkownika`,`id_posta` FROM `polubienia` WHERE `id_uzytkownika` = '$sesja' AND id_posta = '$id_posta'";
                                        $sprawdzanie = mysqli_query($baza, $sprawdz);

                                        if (mysqli_num_rows($sprawdzanie) === 0) {
                                            ?>
                                            <button data-postid="<?php echo $post['id'] ?>" onclick="polubposta(this)">👍🏻polub</button>
                                        <?php } else { ?>
                                            <button class="polubione" data-postid="<?php echo $post['id'] ?>" onclick="polubposta(this)">👍🏻polubiłem</button>
                                        <?php } ?>
                                        <button onclick="pokazkomentarze(this)" data-postid="<?php echo $post['id'] ?>">💬Komentarz</button><button data-postid="<?php echo $post['id'] ?>">👝Udostępnij</button>
                                    </div>
                                    <div class="post_komentarze">
                
                                        <?php
                                        $profilowe = mysqli_query($baza, "SELECT `profilowe`,`folder` from `uzytkownicy` where `id` = '$sesja' LIMIT 9");
                                        $prof = mysqli_fetch_row($profilowe);

                                        echo "<div class='dodaj_komentarz_profilowe'><img src='/../foty/".$prof[1]."/profilowe/".$prof[0]."' alt='profilowe' /></div>";

                                        ?>
                
                                        <input type="text" placeholder="Skomentuj ten wpis" data-postid-kom="<?php echo $post['id'] ?>" />
                                        <label>
                                            <div data-postid-kom="<?php echo $post['id'] ?>" class="dodaj_komentarz" onclick="dodajkomentarza(this)"><img src="../zdjecia/wyslij.png" alt="dodaj_komentarz"></div>
                                        </label>
                                        <div data-postid-pokakom="<?php echo $post['id'] ?>" class="komentarze_post wysrodkuj" style="display: none;">
                
                                        </div>
                                    </div>
                                </div>
                            </article>
                
                <?php
                               mysqli_free_result($sprawdzanie);
                            }
                        }
                    } else {
                        echo "<div class='brak'>Brak postów na tym profilu</div>";
                    }
                    if($wynik_post && isset($wynik_post)) mysqli_free_result($wynik_post);
                    if(isset($wynik_profil) && $wynik_post) mysqli_free_result($wynik_profil);
                    mysqli_close($baza);



                } else {
                    //  include('htm/lewaburta.php');
                    echo '<div id="glowna">
                <div class="glowna-posty">';
                    include "bledy/nieznaleziono.php";
                    
                    echo '</div></div>';
                    //  include('htm/prawaburta.php');
                }

            } catch (Exception $blod) {
                echo "Błąd";
                header('Location:/');
            }


            ?>
        </div>

        </center>
        <div class="dodajPosta" style="display:none;">
            <div class="dodawanie_postow">
                <?php
                //     include('php/dodowaniepostu.php');
                ?>
            </div>
        </div>
    </div>
    </div>
    </div>





    <div class="wyswietlanieczatow" style="display:block;">
    </div>



    </div>





    <script src="../js/profil.js"></script>

    <script>
        const id_profilu = '<?php echo $id; ?>';

        const dodajdoznaj = document.getElementById('dodajznaj');
        function dodajznajomego() {
            dodaj_tresc('dodajznajomego', '#dodajznaj', id_profilu);
            if (dodajdoznaj.innerHTML == " Dodaj do znajomych ") {
                dodajdoznaj.style.background = "silver";
                dodajdoznaj.style.color = "blue";
                dodajdoznaj.innerHTML = "Zaproszenie wysłane";
            } else if (document.getElementById('dodajznaj').innerHTML == "Zaproszenie wysłane") {
                dodajdoznaj.style.background = "yellow";
                dodajdoznaj.innerHTML = "Anulowano zaproszenie";
            } else if (document.getElementById('dodajznaj').innerHTML = "Anulowano zaproszenie") {
                dodajdoznaj.style.background = "silver";
                dodajdoznaj.innerHTML = "Zaproszenie wysłane";
            } else {
                dodajdoznaj.style.background = "red";
            }
        }




    </script>


</body>

</html>

<?php
}
catch (Exception $blod) {
    if (!file_exists('bledy.txt')) {
      fopen('bledy/bledy.txt','a');
    }
    $plik = fopen('bledy/bledy.txt','a');
    fwrite($plik, 'Błąd ' . $blod);
    fclose($plik);
    exit();
  } catch (PDOException $blod) {
    if (!file_exists('bledy.txt')) {
      fopen('bledy/bledy.txt','a');
    }
    $plik = fopen('bledy/bledy.txt','a');
    fwrite($plik, 'Błąd ' . $blod);
    fclose($plik);
    exit();
  }

  ?>