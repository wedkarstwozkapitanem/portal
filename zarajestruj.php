<?php

try {
    session_set_cookie_params(
        [
            'path' => '/',
            'samesite' => 'Lax',
        ]
    );
    include "bazadanych/polocz.php";
    if (!empty($_SESSION['uzytkwonik_pixi_id'])) {
        $sesja = htmlentities($_SESSION['uzytkwonik_pixi_id']);
        header('Location:/');
    }

    if (!empty($_POST['ppp'])) {
        $akcja = trim(htmlentities($_POST['ppp']));
    } else {
        echo 'Nie prawidłowe żądanie';
        header("HTTP/1.1 404 Not Found");
        exit();
    }




    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        global $skrypt;
        if (file_exists("php/logowanie/dodaj_uzytkownika.php")) {
            include "php/logowanie/dodaj_uzytkownika.php";
        } else {
            echo "Nie prawidłowa akcja";
            header("HTTP/1.1 404 Not Found");
            exit();
        }
    } else {
        echo "Nie prawidłowe żądanie";
        header("HTTP/1.1 404 Not Found");
        exit();
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