<?php
try {
    include("php/polocz.php");
    $id_posta = (string)mysqli_real_escape_string($baza,htmlspecialchars($_POST['tresc']));
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
                    <?php if($uzytkownik_komentarz['profilowe'] !=="" && $uzytkownik_komentarz['profilowe'] !== "uzytkownik.gif" ) {?>
                        <div class="komentarz_uzytkownik"><img loading="lazy" src="/../foty/<?php echo $uzytkownik_komentarz['folder'] ?>/posty/<?php echo $uzytkownik_komentarz['profilowe'] ?>" alt="profilowe">
                        <?php } else { ?>
                            <div class="komentarz_uzytkownik"><img loading="lazy" src="/../foty/uzytkownik.gif" alt="profilowe">
                            <?php } ?>
                        <div class="komentarz_nazwa"><div><?php echo $uzytkownik_komentarz['imie'] . ' ' . $uzytkownik_komentarz['nazwisko']; ?></div> </div>
                        </div>
                    </a>
                <?php
                }
                mysqli_free_result($uzytkownik_komentarza);
                ?>
                <div class="komentarz_tresc"><?php echo $komentarz['tresc']; ?></div>
            </div>
            <div class="akcje_komentarz"><div class="polub"> Polub </div><div class="odpowiedz">Odpowiedz</div><div class="data_dodania_komentarza"> <time><?php echo $komentarz['dodanedata'] ?></time></div></div>
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
