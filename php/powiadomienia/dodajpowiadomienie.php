<?php


global $baza;

if (!$_SESSION['uzytkwonik_pixi_id']) {
    session_start();
} else {
    $sesja = (int) mysqli_real_escape_string($baza, htmlspecialchars($_SESSION['uzytkwonik_pixi_id']));
}

if (!$sesja) {
    header('Location:/logowanie');
    exit();
}

if($id_znajomego !== $sesja) {
$zapytanie = "INSERT INTO `powiadomienia` (`id_tresci`,`id_odbiorcy`,`id_uzytkownika`,`typ`) VALUES ('$id_tresci','$id_znajomego','$sesja','$typ')";
mysqli_query($baza, $zapytanie);
} else {
if($typ == 1) {
    $zapytanie = "INSERT INTO `powiadomienia` (`id_tresci`,`id_odbiorcy`,`id_uzytkownika`,`typ`) VALUES ('$id_tresci','$id_znajomego','$sesja','$typ')";
    mysqli_query($baza, $zapytanie);
}

}









?>


