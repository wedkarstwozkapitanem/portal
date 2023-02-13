<?php

try {
if(!include "php/polocz.php") {
    throw new Exception("Nie udało się uzyskać dostępu do bazy mysq");
}
global $baza;

if (!$_SESSION['uzytkwonik_pixi_id']) {
    session_start();
} else {
    if(!$sesja = (int) mysqli_real_escape_string($baza,htmlspecialchars($_SESSION['uzytkwonik_pixi_id']))) throw new Exception("Nie można utworzyć sesji");
}
if (!$sesja) {
    exit();
}


if($wynik_profil = mysqli_fetch_assoc(mysqli_query($baza, "SELECT `id`,`imie`,`nazwisko`,`profilowe`,`folder` FROM `uzytkownicy` where `id` = '$sesja'"))) {
$wynik_profil_transport = json_encode($wynik_profil);
echo $wynik_profil_transport;
} else throw new Exception("Nie udało się wyświetlić danych profilu");
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
