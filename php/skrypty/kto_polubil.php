<div>
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
<div>
            <a href="/profil/<?php echo $id_komentarz_uzytkownik ?>">
                <div class="like_autor"><img width="68px" height="68px" src="/../foty/<?php echo $uzytkownik_komentarz['folder'] ?>/profilowe/<?php echo $uzytkownik_komentarz['profilowe'] ?>" alt="profilowe" />
                    <span><?php echo $uzytkownik_komentarz['imie'] . ' ' . $uzytkownik_komentarz['nazwisko'] ?></span>
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