<?php
try {
    include("php/polocz.php");
    $sesja = (int) $_SESSION['uzytkwonik_pixi_id'];
    $zapytanie_post = "SELECT * FROM posty order by id desc";
    $wynik_post = mysqli_query($baza, $zapytanie_post);

    if (mysqli_num_rows($wynik_post) > 0) {
        while ($post = mysqli_fetch_assoc($wynik_post)) {


            $idu = (int) mysqli_real_escape_string($baza,htmlentities($post['iduzytkownika']));
            $zapytanie_profil = "SELECT id,imie,nazwisko,profilowe FROM uzytkownicy where id = '$idu'";
            $wynik_profil = mysqli_query($baza, $zapytanie_profil);

            while ($uzytkownik = mysqli_fetch_row($wynik_profil)) {
                ?>
            <article>
                <div class="post">
                    <div class="post_informacje"><a href='/profil/<?php echo $post['iduzytkownika'] ?>' style="z-index:12;">
                            <div><img src="../../zdjecia/<?php echo $uzytkownik[3] ?>" alt="profilowe" /></div>
                        </a>
                        <a href="/profil/<?php echo $post['iduzytkownika'] ?>">
                            <div class="post_imie"><?php echo $uzytkownik[1] . ' ' . $uzytkownik[2] ?></div>
                        </a>
                        <div class="post_data"><a href="/profil/<?php echo $uzytkownik[0]; ?>/post/<?php echo $post['idp'] ?>"><time><?php echo $post['datadodania'] ?></time></a></div>
                    </div>
                    <div class="post_tresc">
                        <?php echo $post['tresc'] ?>
                        <div class="post_zdjecia"></div>
                    </div>
                    <div class="licznik_posta">

                        <?php
                        $id_posta = mysqli_real_escape_string($baza,htmlentities($post['idp']));
                        $sprawdz = "SELECT id_uzytkownika,id_posta FROM polubienia WHERE id_posta = '$id_posta'";
                        $sprawdzanie = mysqli_query($baza, $sprawdz);

                        if (mysqli_num_rows($sprawdzanie) >= 2) {
                            echo '<div  onclick="pokaz_kto_polubil(this)" class="licznik_polubien" data-postid-licznikpolubien="' . trim($post['idp']) . '"><span>' . mysqli_num_rows($sprawdzanie) . ' </span><span class="polubienie"> polubienia</span></div>';
                        } else if (mysqli_num_rows($sprawdzanie) === 1) {
                            echo '<div  onclick="pokaz_kto_polubil(this)" class="licznik_polubien" data-postid-licznikpolubien="' . trim($post['idp']) . '"><span>1</span><span class="polubienie"> polubienie</span></div>';
                        } else if (mysqli_num_rows($sprawdzanie) === 0) {
                            echo '<div  onclick="pokaz_kto_polubil(this)" class="licznik_polubien" data-postid-licznikpolubien="' . trim($post['idp']) . '"><span></span><span class="polubienie"> Brak polubień</span></div>';
                        }


                        $liczbakomentarzy = mysqli_query($baza, "SELECT * FROM komentarze where idposta = '$id_posta'");
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
                        $sprawdz = "SELECT id_uzytkownika,id_posta FROM polubienia WHERE id_uzytkownika = '$sesja' AND id_posta = '$id_posta'";
                        $sprawdzanie = mysqli_query($baza, $sprawdz);

                        if (mysqli_num_rows($sprawdzanie) === 0) {
                            ?>
                            <button data-postid="<?php echo $post['idp'] ?>" onclick="polubposta(this)">👍🏻polub</button>
                        <?php } else { ?>
                            <button class="polubione" data-postid="<?php echo $post['idp'] ?>" onclick="polubposta(this)">👍🏻polubiłem</button>
                        <?php } ?>
                        <button onclick="pokazkomentarze(this)" data-postid="<?php echo $post['idp'] ?>">💬Komentarz</button><button data-postid="<?php echo $post['idp'] ?>">👝Udostępnij</button>
                    </div>
                    <div class="post_komentarze">

                        <?php
                        $profilowe = mysqli_query($baza, "SELECT profilowe from uzytkownicy where id = $sesja");
                        $prof = mysqli_fetch_row($profilowe);

                        echo "<div class='dodaj_komentarz_profilowe'><img src='../../zdjecia/" . $prof[0] . "' alt='profilowe' /></div>";

                        ?>

                        <input type="text" placeholder="Skomentuj ten wpis" data-postid-kom="<?php echo $post['idp'] ?>" />
                        <label>
                            <div data-postid-kom="<?php echo $post['idp'] ?>" class="dodaj_komentarz" onclick="dodajkomentarza(this)"><img src="../zdjecia/wyslij.png" alt="dodaj_komentarz"></div>
                        </label>
                        <div data-postid-pokakom="<?php echo $post['idp'] ?>" class="komentarze_post wysrodkuj" style="display: none;">

                        </div>
                    </div>
                </div>
            </article>

<?php
                                mysqli_free_result($sprawdzanie);
            }
        }
    } else {
        echo "Brak postów na dzisiaj";
    }
    mysqli_free_result($wynik_post);
    mysqli_free_result($wynik_profil);
    mysqli_close($baza);
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