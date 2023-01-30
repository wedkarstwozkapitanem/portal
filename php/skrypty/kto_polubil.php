<div class="dymek_polubiony">Ten post został polubiony przez:
    <button class="zamknij" onclick="document.getElementById('dokladneinformacje').style.display = 'none'">X</button><hr>
<?php
include("php/polocz.php");
$id_posta = (string) mysqli_real_escape_string($baza, htmlentities($_POST['tresc']));
$komentarze = mysqli_query($baza, "SELECT * FROM `polubienia` where `id_posta` = '$id_posta'");

if (mysqli_num_rows($komentarze) > 0) {
    while ($komentarz = mysqli_fetch_assoc($komentarze)) {
        $id_komentarz_uzytkownik = $komentarz['id_uzytkownika'];
        $uzytkownik_komentarza = mysqli_query($baza, "SELECT `id`,`imie`,`nazwisko`,`profilowe`,`folder` FROM `uzytkownicy` where `id` = '$id_komentarz_uzytkownik'");
        while ($uzytkownik_komentarz = mysqli_fetch_assoc($uzytkownik_komentarza)) {
?>
<div class="kto_polubil_uzytkownik">
            <a href="/profil/<?php echo $id_komentarz_uzytkownik ?>">
                <div class="like_autor">


<?php if ($uzytkownik_komentarz['profilowe'] !== "" && $uzytkownik_komentarz['profilowe'] !== "uzytkownik.gif") { ?> 
                    <img loading="lazy" src="/../foty/<?php echo $uzytkownik_komentarz['folder'] ?>/profilowe/<?php echo $uzytkownik_komentarz['profilowe'] ?>" alt="profilowe" />
<?php } else { ?>
    <img loading="lazy" src="/../foty/uzytkownik.gif" alt="profilowe" />
    <?php } ?>

                    <div><?php echo $uzytkownik_komentarz['imie'] . ' ' . $uzytkownik_komentarz['nazwisko'] ?></div>
                </div>
            </a>
</div>

<?php
        }
    }
} else {
    echo '<div> Nikt jeszcze tego nie polubił</div>';
}

?>
</div>