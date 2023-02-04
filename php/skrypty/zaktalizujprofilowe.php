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
        $fota_zap = mysqli_query($baza, "SELECT foty FROM `posty` where `id` = '$id_posta' AND `iduzytkownika` = '$sesja' LIMIT 1");
        if (mysqli_num_rows($fota_zap) == 1) {
            $fota = mysqli_fetch_array($fota_zap)[0];

            $folder = mysqli_fetch_row(mysqli_query($baza, "SELECT folder FROM `uzytkownicy` WHERE `id` = '$sesja' LIMIT 1"))[0];
            if (!file_exists("foty/$folder/profilowe")) {
                mkdir("foty/$folder/profilowe", 0777);
            }


            if (copy("foty/$folder/posty/$fota", "foty/$folder/profilowe/$fota")) {
                echo "sukces";
            }


            mysqli_query($baza, "UPDATE `uzytkownicy` SET `uzytkownicy`.`profilowe` = '$fota' WHERE `id` = '$sesja' LIMIT 1");
        } else {
            echo "Nie prawidłowe żądanie";
        }
    }
}
