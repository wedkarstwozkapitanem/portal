<?php

    header("Content-Security-Policy: 'default-src' 'self';");
    header("Content-Security-Policy: 'script-src' 'self';");
    header("Content-Security-Policy: 'object-src' 'self';");
    header("Content-Security-Policy: 'script-src' 'https://fonts.googleapis.com/css2?family=Courier+Prime&display=swap';");
    header("Content-Security-Policy: 'font-src' 'https://fonts.googleapis.com/css2?family=Courier+Prime&display=swap';");


session_save_path("../bazadanych/sesje");
session_name('sesja_pixi');
session_set_cookie_params(
    [
        'path' => '/',
        'lifetime' => 3600 * 24 * 28,
        //      'domain' => 'domain.example',
        'secure' => true,
        'httponly' => true,
        'samesite' => 'Strict',
    ]
);

try {
    session_start();
    if (isset($_SESSION['uzytkwonik_pixi_id'])) session_regenerate_id($_SESSION['uzytkwonik_pixi_id']);
    //zmiana sesji dla bezbieczeństwa
    //kontrola bezpieczeństwa
    if ($_SERVER['HTTP_HOST'] == 'kaptain.ct8.pl') {
        if (!isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'on') {
            header("Location: https://kaptain.ct8.pl/logowanie");
        }
    }


    if (isset($_SESSION['ip'])) {
        if ($_SESSION['ip'] !== htmlspecialchars($_SERVER['REMOTE_ADDR'])) {
            if (!file_exists('bledy.txt')) {
                fopen('bledy/bledy.txt', 'a');
            }
            $plik = fopen('bledy/bledy.txt', 'a');
            fwrite($plik, 'Atak hakerski przechwycenie adresu sesji ' . $_SERVER['REMOTE_ADDR']) . ' || \n';
            fclose($plik);
            //     echo "Atak hakerski karateka już na Ciebie czeka";
            header('Location:/');
            throw new Exception("Atak hakerski");
        }
    }

    if ($_SERVER["REQUEST_METHOD"] !== "GET" && $_SERVER["REQUEST_METHOD"] !== "POST") {
        if (!file_exists('bledy.txt')) {
            fopen('bledy/bledy.txt', 'a');
        }
        $plik = fopen('bledy/bledy.txt', 'a');
        fwrite($plik, 'Nie prawidłowa metoda żądania POST ' . $_SERVER['REMOTE_ADDR']) . '|| \n';
        fclose($plik);
        echo "Nie prawidłowe żądanie";
        throw new Exception("Nie prawidłowe żądanie");
    }
    if ($_SERVER['SCRIPT_NAME'] !== '/index.php') {
        if (!file_exists('bledy.txt')) {
            fopen('bledy/bledy.txt', 'a');
        }
        $plik = fopen('bledy/bledy.txt', 'a');
        fwrite($plik, 'Skrypt nie ten || ' . $_SERVER['REMOTE_ADDR']);
        fclose($plik);
        echo "Nie prawidłowe żądanie";
        throw new Exception("Nie ten skrypt");
    }
    /*    if(!$_SERVER['HTTP_COOKIE']) {
        if (!file_exists('bledy.txt')) {
            fopen('bledy/bledy.txt','a');
          }
          $plik = fopen('bledy/bledy.txt','a');
          fwrite($plik, 'Cookie nie działa || '.$_SERVER['REMOTE_ADDR']);
          fclose($plik);
          echo "Cookie nie działa";
        exit();
    }
*/



    if (!include('../bazadanych/polocz.php')) throw new Exception("Brak bazy");
    global $baza;


    (string) $gdzie = htmlspecialchars($_SERVER['REQUEST_URI']);
    (string) $ktora = htmlspecialchars($gdzie);


    if (!empty($_SESSION['uzytkwonik_pixi_id']) || isset($_SESSION['uzytkwonik_pixi_id'])) {
        (string) $sesja =  mysqli_real_escape_string($baza, htmlspecialchars($_SESSION['uzytkwonik_pixi_id']));
        if (substr($ktora, 1) == 'logowanie' || substr($ktora, 1) == 'rejestracja' || substr($ktora, 1) == 'logowanie/wchodze' || trim(substr($ktora, 1)) == trim('centrumdowodzenia.php')) {
            header('Location:/');
            exit();
        }
    } else {
        if (substr($ktora, 1) != 'logowanie' && substr($ktora, 1) != 'rejestracja' && substr($ktora, 1) != 'logowanie/wchodze' && trim(substr($ktora, 1)) != trim('centrumdowodzenia.php')) {
            //       $link = $ktora;
            header('Location:/logowanie');
            exit();
        }
    }




    function sprawdzeniestrony($sciezka, $adres)
    {
        global $ktora;
        if ($ktora == "$sciezka" || strpos($ktora, $sciezka)) {
            if (file_exists($adres)) {
                (string)$parametry = substr($ktora, 8);
                (array)$podzial = explode('/', $parametry);
                (int)$id = "";
                (int)$id_2 = "";
                if (!empty($podzial[0])) {
                    $id = (int) htmlspecialchars($podzial[0]);
                }
                if (!empty($podzial[2])) {
                    $id_2 = (int) htmlspecialchars($podzial[2]);
                }
                include $adres;
                exit();
            } else {
                header("HTTP/1.1 404 Not Found");
                include "bledy/nieznaleziono.php";
                exit();
            }
        } else {
            header("HTTP/1.1 404 Not Found");
            include "bledy/nieznaleziono.php";
            exit();
            //      include "bledy/404.htm";
        }
    }






    //if ($_SERVER["REQUEST_METHOD"] === "GET" || $_SERVER["REQUEST_METHOD"] === "POST") {




    strlen($ktora);
    if ($ktora == "/")
        sprawdzeniestrony('/', "php/glowna/glowna.php");
    else if (strpos($ktora, "profil")) {
        (string) $parametry = substr($ktora, 8);
        (array) $podzial = explode('/', $parametry);

        if (count($podzial) == 1 || count($podzial) == 3) {
            if (!empty($podzial[1]) == "post") {
                if ($podzial[2]) {
                    sprawdzeniestrony('profil', 'php/glowna/post.php');
                } else {
                    header('Location:/profil/' . $podzial[0]);
                }
            } else {
                sprawdzeniestrony('profil', 'php/profile/profil.php');
            }
        } else if ($podzial[1] == "zdjecia") {
            sprawdzeniestrony('profil', 'php/profile/zdjecia.php');
        } else if ($podzial[1] == "informacje") {
            sprawdzeniestrony('profil', 'php/profile/informacje.php');
        } else if ($podzial[1] == "znajomi") {
            sprawdzeniestrony('profil', 'php/profile/znajomi.php');
        } else {
            include "bledy/nieznaleziono.php";
            exit();
        }
    } else if (strpos($ktora, 'logowanie')) {
        if ($ktora == '/logowanie') {
            sprawdzeniestrony('logowanie', "php/logowanie/min/logowanie.min.php");
        } else if ($ktora == '/logowanie/wchodze') {
            sprawdzeniestrony('wchodze', 'php/logowanie/min/sprawdz_uzytkownika.min.php');
        } else if ($ktora == '/wylogowanie')
            sprawdzeniestrony('wylogowanie', 'php/logowanie/min/wylogowanie.min.php');
    } else if (strpos($ktora, 'post'))
        sprawdzeniestrony('post', "php/post.php");
    else if (strpos($ktora, 'rejestracja')) {
        if (strpos($ktora, 'dodaj_uzytkownika')) {
            sprawdzeniestrony('logowanie/dodaj_uzytkownika', 'php');
            exit();
        } else {
            sprawdzeniestrony('rejestracja', 'php/logowanie/rejestracja.php');
            exit();
        };
    } else if ($ktora == '/dodawanie_tresci')
        sprawdzeniestrony('dodawanie_tresci', 'php/glowna/dodaj_posta.php');
    else if ($ktora == '/zarajestruj.php')
        sprawdzeniestrony('zarajestruj.php', 'zarajestruj.php');
    else {
        include "bledy/nieznaleziono.php";
        header("HTTP/1.1 404 Not Found");
        exit();
    }
} catch (Exception $blod) {
    if (!file_exists('bledy.txt')) {
        fopen('bledy/bledy.txt', 'a');
    }
    $plik = fopen('bledy/bledy.txt', 'a');
    fwrite($plik, 'Błąd ' . $blod);
    fclose($plik);
    echo "Błąd";
    exit();
} catch (PDOException $blod) {
    if (!file_exists('bledy.txt')) {
        fopen('bledy/bledy.txt', 'a');
    }
    $plik = fopen('bledy/bledy.txt', 'a');
    fwrite($plik, 'Błąd ' . $blod);
    fclose($plik);
    echo "Błąd";
    exit();
} catch (\Exception $blod) {
    if (!file_exists('bledy.txt')) {
        fopen('bledy/bledy.txt', 'a');
    }
    $plik = fopen('bledy/bledy.txt', 'a');
    fwrite($plik, 'Błąd ' . $blod);
    fclose($plik);
    echo "Błąd";
    exit();
}




//}




/*
    function sprawdzeniestrony($sciezka, $adres, $parametr)
    {
        global $ktora;
        if ($ktora == "$sciezka" || strpos($ktora, $sciezka)) {
            if ($parametr) { //parametra na true
                $parametry = substr($ktora, 6);
                $podzial = explode('/', $parametry);
                if (!empty($podzial[0])) {
                    echo $podzial[0];
                    exit();
                } else {
                    header("Location:/");
                }
            } else {
                if (file_exists($adres)) {
                    include $adres;
                    exit();
                } else {
                    header("HTTP/1.1 404 Not Found");
                    echo 'Błąd';
                    exit();
                }
            }
        } else {
            header("HTTP/1.1 404 Not Found");
            echo 'Niestety nie znaleziono danego zasobu';
            exit();
            //      include "bledy/404.htm";
        }
    }
*/






















/*
if ($ktora == "/") {
    sprawdzeniestrony('/', "php/glowna.php", false);
} else if (strpos($ktora, 'moj_profil')) {
    sprawdzeniestrony('/', "php/profil_edytuj.php", false);
} else if (strpos($ktora, 'post')) { //kategoria
    sprawdzeniestrony('post', "", true);
    /*  $parametry = substr($ktora, 6);
    $podzial = explode('/', $parametry);
    if (!empty($podzial[0])) {
        echo $podzial[0];
    } else {
        header('Location:/');
    }*//*
} else {
    include "bledy/404.htm";
}
*/
