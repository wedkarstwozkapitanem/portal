<?php
try {
    include("php/polocz.php");
    global $baza;
    $sesja =  mysqli_real_escape_string($baza,htmlspecialchars($_SESSION['uzytkwonik_pixi_id']));
    ?>

<div class="dodaj_posta">
    <div class="dodawanie_profil">
        <?php
        $zapytanie_profil = "SELECT `id`,`imie`,`nazwisko`,`profilowe`,`folder` FROM `uzytkownicy` where `id` = '$sesja'";
        $wynik_profil = mysqli_query($baza, $zapytanie_profil);

        while ($uzytkownik = mysqli_fetch_row($wynik_profil)) {
            ?>
        <?php if($uzytkownik[3]!=="" && $uzytkownik[3]!=="uzytkownik.gif") { ?>
        <img loading="lazy" id="moje_profilowe_fota" src="/../../../foty/<?php echo $uzytkownik[4]?>/profilowe/<?php echo $uzytkownik[3] ?>" alt="profilowe" />
        <?php } else {?>
            <img loading="lazy" id="moje_profilowe_fota" src="/../../../foty/uzytkownik.gif" alt="profilowe" />
            <?php } ?>
        <div class="post_imie" style="top:10px;"><?php echo $uzytkownik[1] . ' ' . $uzytkownik[2] ?></div>
        <?php } ?>
    </div>
    <form action="dodawanie_tresci" method="POST" enctype="multipart/form-data">
        <input type="text" placeholder="Napisz co słychać?" name="tresc_artykulu" id="tresc_artykulu">
        <div class="publikacja">
            <div style="float:left;">
                <label>
                    <div id="zdjecie"> 📷 </div>
                    <input type="file" name="fota_artykulu[]" id="fota_artykulu" multiple hidden>
                </label>
            </div>
            <div id="podglodfot"></div>
            <button>Opoblikuj</button>
        </div>
    </form>
</div>
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