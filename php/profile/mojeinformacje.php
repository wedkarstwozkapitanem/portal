<?php

include "php/polocz.php";

if (!$_SESSION['uzytkwonik_pixi_id']) {
    session_start();
} else {
    $sesja = (int) mysqli_real_escape_string($baza,htmlspecialchars($_SESSION['uzytkwonik_pixi_id']));
}
if (!$sesja) {
    exit();
}


$wynik_profil = mysqli_fetch_assoc(mysqli_query($baza, "SELECT `id`,`imie`,`nazwisko`,`profilowe`,`folder` FROM `uzytkownicy` where `id` = '$sesja'"));
$wynik_profil_transport = json_encode($wynik_profil);
echo $wynik_profil_transport;
