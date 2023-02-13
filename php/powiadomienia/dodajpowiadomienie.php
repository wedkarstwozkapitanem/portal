<?php


global $baza;

try {
    if (!$_SESSION['uzytkwonik_pixi_id']) {
        session_start();
    } else {
        if(!$sesja = (int) mysqli_real_escape_string($baza, htmlspecialchars($_SESSION['uzytkwonik_pixi_id']))) throw new Exception("Nie można utworzyć sesji");
    }

    if (!$sesja) {
        header('Location:/logowanie');
        exit();
    }

    if ($id_znajomego !== $sesja) {
        $zapytanie = "INSERT INTO `powiadomienia` (`id_tresci`,`id_odbiorcy`,`id_uzytkownika`,`typ`) VALUES ('$id_tresci','$id_znajomego','$sesja','$typ')";
        if(!mysqli_query($baza, $zapytanie)) throw new Exception("Błąd połączenia z bazą powiadomień");
    } else {
        if ($typ == 1) {
            $zapytanie = "INSERT INTO `powiadomienia` (`id_tresci`,`id_odbiorcy`,`id_uzytkownika`,`typ`) VALUES ('$id_tresci','$id_znajomego','$sesja','$typ')";
            if(!mysqli_query($baza, $zapytanie)) throw new Exception("Błąd połączenia z bazą powiadomień 2");
        }
    }
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
