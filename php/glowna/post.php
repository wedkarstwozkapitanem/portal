<?php
try {
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

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil użytkownika</title>
    <link href="/css/posty.css" rel="stylesheet" type="text/css">
    <link href="/css/menu.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="foty/logo.png">
    <meta name="description" content="Pixi.Twoje miejsce do rozmów,rozrywki i czatu z kapitanem">
</head>

<body>
<?php
        if (!include "php/glowna/trescstrony/menu.php") {
            echo "Błąd";
        }
        ;
        ?>


    <div id="cala-strona">



    <div id="glowna_tresc_p">
<?php




//posty
(int)$idposta = (int) mysqli_real_escape_string($baza,htmlentities($id_2));
//(int) $id;
$zapytanie_post = "SELECT * FROM `posty` where `iduzytkownika` = '$id' AND `id` = '$idposta'";
$wynik_post = mysqli_query($baza, $zapytanie_post);

if (mysqli_num_rows($wynik_post) > 0) {
    while ($post = mysqli_fetch_assoc($wynik_post)) {


        $idu = (int) mysqli_real_escape_string($baza,htmlentities($post['iduzytkownika']));
        $zapytanie_profil = "SELECT `id`,`imie`,`nazwisko`,`profilowe`,`folder` FROM `uzytkownicy` where id = $idu";
        $wynik_profil = mysqli_query($baza, $zapytanie_profil);

        while ($uzytkownik = mysqli_fetch_row($wynik_profil)) {
            ?>
        <article>
            <div class="post">
                <div class="post_informacje"><a href='/profil/<?php echo $post['iduzytkownika'] ?>' style="z-index:12;">
                        <div><img src="/../zdjecia/<?php echo $uzytkownik[3] ?>" alt="profilowe" /></div>
                    </a>
                    <a href="/profil/<?php echo $post['iduzytkownika'] ?>">
                        <div class="post_imie"><?php echo $uzytkownik[1] . ' ' . $uzytkownik[2] ?></div>
                    </a>
                    <div class="post_data"><a href="/profil/<?php echo $uzytkownik[0]; ?>/post/<?php echo $post['id'] ?>"><time><?php echo $post['datadodania'] ?></time></a></div>
                </div>
                <div class="post_tresc">
                    <?php echo $post['tresc'] ?>
                    <div class="post_zdjecia">
                    <?php
                                        if ((array) $lista_fot = explode(",", $post['foty'])) {
                                            if (isset($lista_fot) && !empty($lista_fot)) {
                                                foreach ($lista_fot as $fotka) {
                                                    echo "<img src='/foty/" . $uzytkownik[4] . "/posty/" . $fotka . "' alt='zdjecie posta' />";
                                                }
                                            }
                                        }
                    ?>
                    </div>
                </div>
                <div class="licznik_posta">

                    <?php
                    $id_posta = htmlentities($post['id']);
                    mysqli_escape_string($baza, $id_posta);
                    $sprawdz = "SELECT `id_uzytkownika`,`id_posta` FROM `polubienia` WHERE `id_posta` = '$id_posta'";
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
                    $sprawdz = "SELECT `id_uzytkownika`,`id_posta` FROM `polubienia` WHERE `id_uzytkownika` = '$sesja' AND `id_posta` = '$id_posta'";
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
                    $profilowe = mysqli_query($baza, "SELECT `profilowe` from `uzytkownicy` where `id` = '$sesja'");
                    $prof = mysqli_fetch_row($profilowe);

                    echo "<div class='dodaj_komentarz_profilowe'><img src='/../zdjecia/" . $prof[0] . "' alt='profilowe' /></div>";

                    ?>

                    <input type="text" placeholder="Skomentuj ten wpis" data-postid-kom="<?php echo $post['id'] ?>" />
                    <label>
                        <div data-postid-kom="<?php echo $post['id'] ?>" class="dodaj_komentarz" onclick="dodajkomentarza(this)"><img src="/zdjecia/wyslij.png" alt="dodaj_komentarz"></div>
                    </label>
                    <div data-postid-pokakom="<?php echo $post['id'] ?>" class="komentarze_post wysrodkuj" >
                  

                    <?php
try {

    $id_posta = (int)mysqli_real_escape_string($baza,htmlentities($post['id']));
    $zapytanie_komentarze = "SELECT * FROM `komentarze` where `idposta` = '$id_posta' order by `id` DESC";
    $kometarze = mysqli_query($baza, $zapytanie_komentarze);



    if (mysqli_num_rows($kometarze) > 0) {
        while ($komentarz = mysqli_fetch_assoc($kometarze)) {
            $id_komentarz_uzytkownik =  (int)$komentarz['iduzytkownika'];
            ?>


        <article style="margin-top:10px !important">
            <div class="komentarz_posta">
                <?php $uzytkownik_komentarza = mysqli_query($baza, "SELECT `id`,`imie`,`nazwisko`,`profilowe` FROM `uzytkownicy` where `id` = '$id_komentarz_uzytkownik'");
                while ($uzytkownik_komentarz = mysqli_fetch_assoc($uzytkownik_komentarza)) {
                    ?>
                    <a href="/profil/<?php echo $uzytkownik_komentarz['id']; ?>">
                        <div class="komentarz_uzytkownik"><img src="/../zdjecia/<?php echo $uzytkownik_komentarz['profilowe'] ?>" alt="profilowe">
                            <div class="komentarz_nazwa"><?php echo $uzytkownik_komentarz['imie'] . ' ' . $uzytkownik_komentarz['nazwisko']; ?> dodał komentarz <time><?php echo $komentarz['dodanedata'] ?></time> </div>
                        </div>
                    </a>
                <?php
                }
                mysqli_free_result($uzytkownik_komentarza);
                ?>
                <div class="komentarz_tresc"><?php echo $komentarz['tresc']; ?></div>
            </div>
        </article>


<?php
        }
    } else {
        echo '<div class="komentarz_tresc" style="text-align:center;color:red;font-size:40px">Brak komentarzy</div>';
    }

    mysqli_free_result($kometarze);
} catch (Exception $blod) {
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


                    
                    </div>
                </div>
            </div>
        </article>

<?php
                            mysqli_free_result($sprawdzanie);
        }
    }
} else {
            include "bledy/nieznaleziono.php";
}





?>
    </div>
</div>
<?php
        if ($wynik_post) mysqli_free_result($wynik_post);
        if(isset($wynik_profil)) mysqli_free_result($wynik_profil);
        if ($baza)    mysqli_close($baza);
    












    
} catch (Exception $blod) {
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


<script src="/js/post.js" type="text/javascript"> </script>
</html>