<?php


require_once "php/polocz.php";

if (!$_SESSION['uzytkwonik_pixi_id']) {
    session_start();
} else {
    $sesja = (int) mysqli_real_escape_string($baza, htmlspecialchars($_SESSION['uzytkwonik_pixi_id']));
}

if (!$sesja) {
    exit();
}


if (isset($_POST['tresc']) && !empty($_POST['tresc'])) {
    if ((string) $id_posta = (string) mysqli_real_escape_string($baza, htmlspecialchars($_POST['tresc']))) {

        (int)$czymoj = mysqli_num_rows(mysqli_query($baza, "SELECT * FROM `posty` WHERE `id` = '$id_posta' AND `iduzytkownika` = '$sesja'"));

        if((int)$czymoj === (int)1) {
            if (mysqli_query($baza, "UPDATE `posty` SET `usunieto` = 1  WHERE `id`='$id_posta' AND `iduzytkownika` = '$sesja'"))
                echo "Post usunieto";
        }
    }
}