<?php

try {
    include("bazadanych/polocz.php");
    session_start();


    if (!empty($_SESSION['uzytkwonik_pixi_id'])) {
        (string)$sesja = mysqli_real_escape_string($baza,htmlentities($_SESSION['uzytkwonik_pixi_id']));
    } else {
        echo 'Nie zalogowano';
        header("HTTP/1.1 404 Not Found");
        exit();
    }




    if (!empty($_POST['ppp'])) {
        (string)$akcja = trim(htmlentities($_POST['ppp']));
    } else {
        echo 'Nie prawidłowe żądanie';
        header("HTTP/1.1 404 Not Found");
        exit();
    }



    function sprawdzplik($s)
    {

        $skrypt = trim(htmlentities($s));
        if (file_exists($skrypt)) {
            include "$skrypt";
        } else {
            echo $skrypt . " Nie prawidłowa akcja";
            header("HTTP/1.1 404 Not Found");
            exit();
        }
    }





    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        if (!empty($_POST['tresc'])) {
            $tresc = htmlentities($_POST['tresc']);
        }


        switch ($akcja) {
            case 'posty':
                sprawdzplik("php/glowna/posty.php");
                break;
            case 'polubienie':
                sprawdzplik("php/skrypty/polub.php");
                break;
            case 'wyszukiwarka':
                sprawdzplik("php/skrypty/wyszukiwarka.php");
                break;
            case 'dodajkomentarz':
                sprawdzplik("php/skrypty/dodaj_komentarz.php");
                break;
            case 'wyswietlkomentarze':
                sprawdzplik("php/skrypty/wyswietlkomentarze.php");
                break;
            case 'wyswietlkomentarzep':
                sprawdzplik("php/skrypty/wyswietlkomentarzep.php");
                break;
            case 'kto_polubil':
                sprawdzplik("php/skrypty/kto_polubil.php");
                break;
            case 'mojeinformacje':
                sprawdzplik("php/profile/mojeinformacje.php");
                break;
            case 'zaktalizujprofilowe':
                sprawdzplik("php/skrypty/zaktalizujprofilowe.php");
                break;
            case 'usunposta':
                sprawdzplik("php/skrypty/usunposta.php");
                break;
            case 'edytowanie_profilu':
                sprawdzplik("php/skrypty/edytowanie_profilu.php");
                break;
            default:
                echo "Nie prawidłowe żądanie";
                header("HTTP/1.1 404 Not Found");
                exit();
        }


        /*
        if ($akcja == 'posty')
        sprawdzplik("php/glowna/posty.php");
        else if ($akcja == 'polubienie')
        sprawdzplik("php/skrypty/polub.php");
        else if ($akcja == "wyszukiwarka")
        sprawdzplik("php/skrypty/wyszukiwarka.php");
        else if ($akcja == 'dodajkomentarz')
        sprawdzplik("php/skrypty/dodaj_komentarz.php");
        else if ($akcja == 'wyswietlkomentarze')
        sprawdzplik("php/skrypty/wyswietlkomentarze.php");
        
        } else {
        echo "Nie prawidłowe żądanie";
        header("HTTP/1.1 404 Not Found");
        exit();
        }
        */
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
