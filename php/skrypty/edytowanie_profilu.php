<?php

include("php/polocz.php");

    $sesja = mysqli_escape_string($baza,htmlspecialchars($_SESSION['uzytkwonik_pixi_id']));

if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
    if (isset($_POST['miejscowosc']) && isset($_POST['praca']) && isset($_POST['hobby']) && isset($_POST['linki'])) {

        (string) $miejscowosc = mysqli_real_escape_string($baza, htmlspecialchars($_POST['miejscowosc']));
        (string) $praca = mysqli_real_escape_string($baza, htmlspecialchars($_POST['praca']));
        (string) $hobby = mysqli_real_escape_string($baza, htmlspecialchars($_POST['hobby']));
        (string) $linki = mysqli_real_escape_string($baza, htmlspecialchars($_POST['linki']));

       if(mysqli_query($baza, "UPDATE `uzytkownicy` SET `miejscowosc` = '$miejscowosc', `praca`='$praca' , `hobby`='$hobby' , `linki` = '$linki' where id = '$sesja'")) {
            echo "pixel";
       }


    } else {
        echo "Nie prawidłowe dane";
    }
} else {
    echo "Nie prawidłowe żądanie";
}

header("Location:/profil/" . $sesja);

            ?>