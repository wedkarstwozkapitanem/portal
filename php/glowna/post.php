<?php
try {
    include "php/polocz.php";
    global $baza;

    if (!$_SESSION['uzytkwonik_pixi_id']) {
        session_start();
        throw new Exception("Nie można utworzyć sesji");
    } else {
        if (!$sesja = (int) mysqli_real_escape_string($baza, htmlspecialchars($_SESSION['uzytkwonik_pixi_id']))) {
            throw new Exception("Sesji brak");
        }
    }

    if (!$sesja) {
        header('Location:/logowanie');
        exit();
    }

    if (!$id) {
        include "bledy/nieznaleziono.php";
        throw new Exception("Brak id");
    }








    //posty
    if (!(int)$idposta = (int) mysqli_real_escape_string($baza, htmlspecialchars($id_2))) exit();

    (int)$id = (int) $id;
    $zapytanie_post = "SELECT * FROM `posty` where `iduzytkownika` = '$id' AND `idp` = '$idposta' AND `usunieto` = 0";
    if (!$wynik_post = mysqli_query($baza, $zapytanie_post)) throw new Exception("Nie udało się wczytać posta");


    if (mysqli_num_rows($wynik_post) > 0) {
        while ($post = mysqli_fetch_assoc($wynik_post)) {
            if (((int)$post['publiczny'] === 1 && (int)$post['iduzytkownika'] !== (int)$sesja) || (((int)$post['publiczny'] === 0 || (int)$post['publiczny'] === 1) && (int)$post['iduzytkownika'] === (int)$sesja)) {
                if ((int)$post['udustepniono'] === (int)0) {

?>
                    <!DOCTYPE html>
                    <html lang="pl">

                    <head>
                        <meta charset="UTF-8">
                        <meta http-equiv="X-UA-Compatible" content="IE=edge">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Profil użytkownika</title>
                        <link href="/css/glowne.css" rel="stylesheet" type="text/css">
                        <link rel="shortcut icon" href="foty/logo.png">
                        <meta name="description" content="Pixi.Twoje miejsce do rozmów,rozrywki i czatu z kapitanem">
                    </head>

                    <body>
                        <?php
                        if (!include "php/glowna/trescstrony/menu.php") {
                            echo "Błąd";
                        };
                        ?>


                        <div id="cala-strona" class="wysrodkowanie">



                            <div id="glowna_tresc_p" class="marginpost">

                                <?php

                                $idu = (int) mysqli_real_escape_string($baza, htmlspecialchars($post['iduzytkownika']));
                                $zapytanie_profil = "SELECT `id`,`imie`,`nazwisko`,`profilowe`,`folder` FROM `uzytkownicy` where `id` = '$idu'";
                                $wynik_profil = mysqli_query($baza, $zapytanie_profil);

                                while ($uzytkownik = mysqli_fetch_row($wynik_profil)) {
                                ?>
                                    <article>
                                        <div class="post" data-postid="<?php echo $post['idp'] ?>">
                                            <div class="post_informacje"><a href='/profil/<?php echo $post['iduzytkownika'] ?>' style="z-index:12;">
                                                    <div>
                                                        <?php if ($uzytkownik[3] !== "" && $uzytkownik[3] !== "uzytkownik.gif") {
                                                            echo "<img loading='lazy' src='/../foty/" . $uzytkownik[4] . "/profilowe/" . $uzytkownik[3] . "' alt='profilowe' />";
                                                        } else {
                                                            echo "<img loading='lazy' src='/../foty/uzytkownik.gif' alt='profilowe' />";
                                                        }

                                                        ?>
                                                    </div>
                                                </a>
                                                <a href="/profil/<?php echo $post['iduzytkownika'] ?>">
                                                    <div class="post_imie"><?php echo $uzytkownik[1] . ' ' . $uzytkownik[2] ?></div>
                                                </a>
                                                <div class="post_data"><a href="/profil/<?php echo $uzytkownik[0]; ?>/post/<?php echo $post['idp'] ?>"><time><?php echo $post['datadodania'] ?></time></a><button style="border-radius:8px;margin: 2px 0 0 8px;background:silver;">Dodał/a posta</button>
                                                    <?php if ((int)$post['publiczny'] === 1) { ?>
                                                        <button style="border-radius:8px;background:silver;">Publiczny</button>
                                                    <?php } else { ?>
                                                        <button style="border-radius:8px;background:silver;">Prywatny</button>
                                                    <?php } ?>
                                                </div>
                                                <div class="opcjeposta opcjeposta_usuwanie wysrodkowanie" onclick="menuposta(this)" data-postid="<?php echo $post['idp'] ?>"><span style="top:-10px;">...</span></div>

                                                <div class="menu_posta_opcje" style="display:none;" data-opcje_posta="<?php echo $post['idp'] ?>">
                                                    <?php if ($post['iduzytkownika'] == $sesja) { ?>
                                                        <?php if ($post['foty'] != "" && isset($post['foty'])) { ?>
                                                            <button onclick="zaktalizuj_profilowe(<?php echo $post['idp'] ?>)">Zaktalizuj profilowe tym zdjęciem</button>
                                                        <?php } ?>
                                                        <button onclick="usunposta(<?php echo $post['idp'] ?>)">Usuń</button>
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
                                                                    echo "<img loading='lazy' src='/foty/" . $uzytkownik[4] . "/posty/" . $fotka . "' alt='zdjecie posta' />";
                                                                }
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="licznik_posta">

                                                <?php
                                                $id_posta = htmlspecialchars($post['idp']);
                                                mysqli_escape_string($baza, $id_posta);
                                                $sprawdz = "SELECT `id_uzytkownika`,`id_posta` FROM `polubienia` WHERE `id_posta` = '$id_posta'";
                                                $sprawdzanie = mysqli_query($baza, $sprawdz);

                                                if (mysqli_num_rows($sprawdzanie) >= 2) {
                                                    echo '<div onclick="pokaz_kto_polubil(this)"  class="licznik_polubien" data-postidlicznikpolubien="' . trim($post['idp']) . '"><span>' . mysqli_num_rows($sprawdzanie) . ' </span><span class="polubienie"> polubienia</span></div>';
                                                } else if (mysqli_num_rows($sprawdzanie) === 1) {
                                                    echo '<div onclick="pokaz_kto_polubil(this)"  class="licznik_polubien" data-postidlicznikpolubien="' . trim($post['idp']) . '"><span>1</span><span class="polubienie"> polubienie</span></div>';
                                                } else if (mysqli_num_rows($sprawdzanie) === 0) {
                                                    echo '<div onclick="pokaz_kto_polubil(this)"  class="licznik_polubien" data-postidlicznikpolubien="' . trim($post['idp']) . '"><span></span><span class="polubienie"> Brak polubień</span></div>';
                                                }


                                                $liczbakomentarzy = mysqli_query($baza, "SELECT * FROM `komentarze` where `idposta` = '$id_posta'");
                                                if (mysqli_num_rows($liczbakomentarzy) === 0) {
                                                ?>
                                                    <div class="licznik_komentarzy" onclick="pokazkomentarze(this)" data-postid="<?php echo $post['idp'] ?>"><span data-postid-licznikomentarzyp="<?php echo trim($post['idp']) ?>"></span><span data-postid-licznikomentarzy="<?php echo trim($post['idp']) ?>"> Brak komentarzy</span></div>
                                                <?php } else if (mysqli_num_rows($liczbakomentarzy) === 1) { ?>
                                                    <div class="licznik_komentarzy" onclick="pokazkomentarze(this)" data-postid="<?php echo $post['idp'] ?>"><span data-postid-licznikomentarzyp="<?php echo trim($post['idp']) ?>">1</span><span data-postid-licznikomentarzy="<?php echo trim($post['idp']) ?>"> komentarz</span></div>
                                                <?php } else { ?>
                                                    <div class="licznik_komentarzy" onclick="pokazkomentarze(this)" data-postid="<?php echo $post['idp'] ?>"><span data-postid-licznikomentarzyp="<?php echo trim($post['idp']) ?>"><?php echo mysqli_num_rows($liczbakomentarzy); ?></span><span data-postid-licznikomentarzy="<?php echo trim($post['idp']) ?>"> komentarze</span></div>
                                                <?php }
                                                mysqli_free_result($liczbakomentarzy);
                                                ?>
                                                <div class="licznik_udustepnien"><span>4</span> udostępnienia</div>

                                            </div>
                                            <div class="post_akcja srodkowanie">

                                                <?php
                                                $sprawdz = "SELECT `id_uzytkownika`,`id_posta` FROM `polubienia` WHERE `id_uzytkownika` = '$sesja' AND `id_posta` = '$id_posta'";
                                                $sprawdzanie = mysqli_query($baza, $sprawdz);

                                                if (mysqli_num_rows($sprawdzanie) === 0) {
                                                ?>
                                                    <button data-postid="<?php echo $post['idp'] ?>" onclick="polubposta(this)">👍🏻polub</button>
                                                <?php } else { ?>
                                                    <button class="polubione" data-postid="<?php echo $post['idp'] ?>" onclick="polubposta(this)">👍🏻polubiłem</button>
                                                <?php } ?>
                                                <button onclick="pokazkomentarze(this)" data-postid="<?php echo $post['idp'] ?>">💬Komentarz</button><button onclick="udustepnij(this)" data-postid="<?php echo $post['idp'] ?>">👝Udostępnij</button>
                                            </div>
                                            <div class="post_komentarze">
                                                <div style="margin-left:auto;margin-right:auto;">
                                                    <?php
                                                    $profilowe = mysqli_query($baza, "SELECT `profilowe`,`folder` from `uzytkownicy` where `id` = '$sesja'");
                                                    $prof = mysqli_fetch_row($profilowe);

                                                    if ($prof[0] !== "" && $prof[0] !== "uzytkownik.gif") {
                                                        echo "<div class='dodaj_komentarz_profilowe'><img loading='lazy' src='/../foty/" . $prof[1] . "/profilowe/" . $prof[0] . "' alt='profilowe' /></div>";
                                                    } else {
                                                        echo "<div class='dodaj_komentarz_profilowe'><img loading='lazy' src='/foty/uzytkownik.gif' alt='profilowe' /></div>";
                                                    }
                                                    ?>
                                                    <form onsubmit="return false">
                                                        <input type="text" placeholder="Skomentuj ten wpis" data-postid-kom="<?php echo $post['idp'] ?>" />
                                                        <div style="float: right;">
                                                            <label>
                                                                <div data-postid-kom="<?php echo $post['idp'] ?>" class="dodaj_komentarz" onclick="dodajkomentarza(this)"><img id="mojeprofilowe" loading='lazy' src="/zdjecia/wyslij.png" alt="dodaj_komentarz"></div>
                                                                <input data-postid-kom="<?php echo $post['idp'] ?>" onclick="dodajkomentarza(this)" style="display:none" type="submit" hidden />
                                                            </label>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div data-postid-pokakom="<?php echo $post['idp'] ?>" class="komentarze_post">


                                                    <?php
                                                    try {

                                                        $id_posta = (int)mysqli_real_escape_string($baza, htmlspecialchars($post['idp']));
                                                        $zapytanie_komentarze = "SELECT * FROM `komentarze` where `idposta` = '$id_posta' order by `id` DESC";
                                                        $kometarze = mysqli_query($baza, $zapytanie_komentarze);



                                                        (int)$id_posta = (int)$post['idp'];
                                                        if (isset($id_posta)) {
                                                            $zapytanie_komentarze = "SELECT * FROM `komentarze` where `idposta` = '$id_posta' order by `id` DESC";
                                                            $kometarze = mysqli_query($baza, $zapytanie_komentarze);
                                                            if (mysqli_num_rows($kometarze) > 0) {
                                                                while ($komentarz = mysqli_fetch_assoc($kometarze)) {
                                                                    $id_komentarz_uzytkownik = $komentarz['iduzytkownika'];
                                                    ?>
                                                                    <article style="margin-top:4px !important">
                                                                        <div class="komentarz_posta">
                                                                            <?php $uzytkownik_komentarza = mysqli_query($baza, "SELECT `id`,`imie`,`nazwisko`,`profilowe`,`folder` FROM `uzytkownicy` where `id` = '$id_komentarz_uzytkownik'");
                                                                            while ($uzytkownik_komentarz = mysqli_fetch_assoc($uzytkownik_komentarza)) {
                                                                            ?>
                                                                                <a href="/profil/<?php echo $uzytkownik_komentarz['id']; ?>">
                                                                                    <?php if ($uzytkownik_komentarz['profilowe'] !== "" && $uzytkownik_komentarz['profilowe'] !== "uzytkownik.gif") { ?>
                                                                                        <div class="komentarz_uzytkownik"><img loading="lazy" src="/../foty/<?php echo $uzytkownik_komentarz['folder'] ?>/posty/<?php echo $uzytkownik_komentarz['profilowe'] ?>" alt="profilowe">
                                                                                        <?php } else { ?>
                                                                                            <div class="komentarz_uzytkownik"><img loading="lazy" src="/../foty/uzytkownik.gif" alt="profilowe">
                                                                                            <?php } ?>
                                                                                            <div class="komentarz_nazwa">
                                                                                                <div><?php echo $uzytkownik_komentarz['imie'] . ' ' . $uzytkownik_komentarz['nazwisko']; ?></div>
                                                                                            </div>
                                                                                            </div>
                                                                                </a>
                                                                            <?php
                                                                            }
                                                                            mysqli_free_result($uzytkownik_komentarza);
                                                                            ?>
                                                                            <div class="komentarz_tresc"><?php echo $komentarz['tresc']; ?></div>
                                                                        </div>
                                                                        <div class="akcje_komentarz">
                                                                            <div class="polub"> Polub </div>
                                                                            <div class="odpowiedz">Odpowiedz</div>
                                                                            <div class="data_dodania_komentarza"> <time><?php echo $komentarz['dodanedata'] ?></time></div>
                                                                        </div>
                                                                    </article>


                                                    <?php



                                                                }
                                                            } else {
                                                                echo '<div class="komentarz_tresc" style="text-align:center;color:red;font-size:40px">Brak komentarzy</div>';
                                                            }
                                                        } else {
                                                            echo "Błędny id";
                                                        }






                                                        mysqli_free_result($kometarze);
                                                    } catch (Exception $blod) {
                                                        if (!file_exists('bledy.txt')) {
                                                            fopen('bledy/bledy.txt', 'a');
                                                        }
                                                        $plik = fopen('bledy/bledy.txt', 'a');
                                                        fwrite($plik, 'Błąd ' . $blod);
                                                        fclose($plik);
                                                        exit();
                                                    } catch (PDOException $blod) {
                                                        if (!file_exists('bledy.txt')) {
                                                            fopen('bledy/bledy.txt', 'a');
                                                        }
                                                        $plik = fopen('bledy/bledy.txt', 'a');
                                                        fwrite($plik, 'Błąd ' . $blod);
                                                        fclose($plik);
                                                        exit();
                                                    }
                                                    ?>



                                                </div>
                                            </div>
                                        </div>
                                    </article>

                <?php
                                    mysqli_free_result($sprawdzanie);
                                }
                            } else {
                                /**udustepnienia**/


                                echo "<a href='' > Kliknij tutaj aby zobaczyć post </a>";
                            }
                        } else {
                            include "bledy/nieznaleziono.php";
                        }
                    }
                } else {
                    if (!include "bledy/nieznaleziono.php") {
                        throw new Exception("Błąd");
                    }
                }





                ?>
                            </div>
                        </div>
                    <?php
                    if ($wynik_post) mysqli_free_result($wynik_post);
                    if (isset($wynik_profil)) mysqli_free_result($wynik_profil);
                    if ($baza)    mysqli_close($baza);
                } catch (Exception $blod) {
                    if (!file_exists('bledy.txt')) {
                        fopen('bledy/bledy.txt', 'a');
                    }
                    $plik = fopen('bledy/bledy.txt', 'a');
                    fwrite($plik, 'Błąd ' . $blod);
                    fclose($plik);
                    exit();
                } catch (PDOException $blod) {
                    if (!file_exists('bledy.txt')) {
                        fopen('bledy/bledy.txt', 'a');
                    }
                    $plik = fopen('bledy/bledy.txt', 'a');
                    fwrite($plik, 'Błąd ' . $blod);
                    fclose($plik);
                    exit();
                }
                    ?>
                    <a href="/">
                        <div style="color:blue;position:fixed;bottom:0px;">WSTECZ</div>
                    </a>
                    <div style="display:none" id="dokladneinformacje"></div>
                    <script src="/js/post.js" type="text/javascript"> </script>

                    </html>