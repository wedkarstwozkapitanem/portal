<?php
try {
  include("php/polocz.php");

  (string)$uzyt = mysqli_real_escape_string($baza,htmlspecialchars($_POST['tresc']));

  $zapytanie = "SELECT `id`,`imie`,`nazwisko`,`profilowe`,`folder` FROM `uzytkownicy` WHERE `imie` LIKE '%$uzyt%' or `nazwisko` LIKE '%$uzyt%' order by `imie` ASC";

  $wyslij = mysqli_query($baza, $zapytanie);
  if (mysqli_num_rows($wyslij) > 0) {
    while ($uzytkownik = mysqli_fetch_row($wyslij)) {
      ?>
 <a href="/profil/<?php echo $uzytkownik[0]; ?>">
<div class="wyszukiwara_uzyt wysrodkuj">
  <?php if($uzytkownik[3] !== "" && $uzytkownik[3] !== "uzytkownik.gif") { ?>
<img src="/../../foty/<?php echo $uzytkownik[4]; ?>/profilowe/<?php echo $uzytkownik[3]; ?>" alt="profilowe"/>
<?php } else { ?>
  <img src="/../../foty/uzytkownik.gif" alt="profilowe"/>
  <?php } ?>
<div class="wyszukiwarka_nazwa"><?php echo $uzytkownik[1] . ' ' . $uzytkownik[2] ?></div>
</div>
 </a>
<?php
    }
  } else {
    echo 'Nie znaleziono';
  }
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