<?php
require_once("php/polocz.php");
global $baza;

(int) $sesja = $_SESSION['uzytkwonik_pixi_id']; //mysqli_escape_string($baza,htmlspecialchars($_SESSION['uzytkwonik_pixi_id']));
    if(!$sesja) {
    header("HTTP/1.1 404 Not Found");
    exit();
    }

global $baza;

$idp = $_POST['tresc'];

$czyznaj = "SELECT * FROM (SELECT * FROM `znajomi` where `iduzytkownika` = '$sesja' OR `iduzytkownik` = '$sesja') as p where `iduzytkownika` = '$idp' OR `iduzytkownik` = '$idp' LIMIT 1";
$czyznajom = mysqli_query($baza, $czyznaj);



(string)$sql = "";
if (mysqli_num_rows($czyznajom) === 0) {
    $sql = "INSERT INTO `znajomi` (iduzytkownika,iduzytkownik,czyprzyjeto) VALUES ('$sesja', '$idp',0)";
} else {
    $czyznajomy = mysqli_fetch_assoc($czyznajom);
    $czyprzyjeto = $czyznajomy['czyprzyjeto'];
    $id = $czyznajomy['id'];

    if ($czyprzyjeto == 0) {
        if ($czyznajomy['iduzytkownik'] == $sesja) {
            $sql = "UPDATE `znajomi` SET `czyprzyjeto` = '1' where `id`='$id'";
        } else {
            $sql = "DELETE FROM `znajomi` WHERE id ='$id'";
        }
    } else {
        $sql = "DELETE FROM `znajomi` WHERE id ='$id'";
    }
    
}
mysqli_query($baza, $sql);


/*
if(mysqli_num_rows($czyznajom) === 0) {
    mysqli_query($baza ,"INSERT INTO `znajomi` (iduzytkownika,iduzytkownik,czyprzyjeto) VALUES ('$sesja', '$idp',0)");
} else {
    $czyznajomy = mysqli_fetch_assoc($czyznajom);
    $czyprzyjeto = $czyznajomy['czyprzyjeto'];
    $id = $czyznajomy['id'];

    if ($czyprzyjeto == 0) {
        if ($czyznajomy['iduzytkownik'] == $sesja) {
            mysqli_query($baza, "UPDATE `znajomi` SET `czyprzyjeto` = '1' where `id`='$id'");
        } else {
      //      mysqli_query($baza, "DELETE FROM `znajomi` WHERE id ='$id'");
        }
    } else {
        mysqli_query($baza, "DELETE FROM `znajomi` WHERE id ='$id'");
    }
    
}
*/





