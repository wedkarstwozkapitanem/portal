<?php

    header("Content-Security-Policy: 'default-src' 'self';");



    session_save_path("../bazadanych/sesje");
    session_name('sesja_pixi');
    session_set_cookie_params(
        [
            'path' => '/',
            'lifetime' => 3600*24*28,
    //      'domain' => 'domain.example',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict',
        ]
        );
        require_once("bazadanych/polocz.php");
        global $baza;
        session_start();
try {
// kontrola bezpieczeńśtwa

    if (isset($_SESSION['ip'])) {
        if ($_SESSION['ip'] !== htmlspecialchars($_SERVER['REMOTE_ADDR'])) {
            session_destroy();
            if (!file_exists('bledy.txt')) {
                fopen('bledy/bledy.txt', 'a');
            }
            $plik = fopen('bledy/bledy.txt', 'a');
       //     fwrite($plik, 'Atak hakerski przechwycenie adresu sesji ' . $_SERVER['REMOTE_ADDR']) . ' || \n';
            fclose($plik);
            echo "Nie prawidłowe żądanie";
            exit();
        }
    }


if (/*$_SERVER["REQUEST_METHOD"] !== "GET" &&*/ $_SERVER["REQUEST_METHOD"] !== "POST") {
    if (!file_exists('bledy.txt')) {
        fopen('bledy/bledy.txt','a');
      }
      $plik = fopen('bledy/bledy.txt','a');
      fwrite($plik, 'Nie prawidłowa metoda żądania GET '.$_SERVER['REMOTE_ADDR']).' || \n';
      fclose($plik);
      echo "Nie prawidłowe żądanie";
    exit();
}
if($_SERVER['SCRIPT_NAME'] !== '/centrumdowodzenia.php'){
    if (!file_exists('bledy.txt')) {
        fopen('bledy/bledy.txt','a');
      }
      $plik = fopen('bledy/bledy.txt','a');
      fwrite($plik, 'Skrypt nie ten || '.$_SERVER['REMOTE_ADDR']);
      fclose($plik);
      echo "Nie prawidłowe żądanie";
    exit();
}
if(!$_SERVER['HTTP_COOKIE']) {
    if (!file_exists('bledy.txt')) {
        fopen('bledy/bledy.txt','a');
      }
      $plik = fopen('bledy/bledy.txt','a');
      fwrite($plik, 'Cookie nie działa || '.$_SERVER['REMOTE_ADDR']);
      fclose($plik);
      echo "Cookie nie działa";
    exit();
}






    if (isset($_SESSION['uzytkwonik_pixi_id'])) {
        (string)$sesja = mysqli_real_escape_string($baza,htmlspecialchars($_SESSION['uzytkwonik_pixi_id']));
    } else {
        echo 'Nie zalogowano';
        header("HTTP/1.1 404 Not Found");
        exit();
    }




    if (!empty($_POST['ppp'])) {
        (string)$akcja = trim(htmlspecialchars($_POST['ppp']));
    } else {
        echo 'Nie prawidłowe żądanie';
        header("HTTP/1.1 404 Not Found");
        exit();
    }

    global $baza;

    function sprawdzplik($s)
    {

        $skrypt = trim(htmlspecialchars($s));
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
            $tresc = htmlspecialchars($_POST['tresc']);
        }


        switch ($akcja) {
            case 'posty':
                sprawdzplik("php/glowna/posty.php");
                break;
            case 'wyswietl_powiadomienia':
                sprawdzplik("php/powiadomienia/wyswietl_powiadomienia.php");
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
            case 'dodajznajomego':
                sprawdzplik("php/skrypty/dodajznajomego.php");
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
            case 'udustepnij':
                sprawdzplik("php/skrypty/udustepnij.php");
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
