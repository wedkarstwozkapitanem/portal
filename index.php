<?php

try {
    session_start();

    include('bazadanych/polocz.php');


    (string) $gdzie = htmlentities($_SERVER['REQUEST_URI']);
    (string) $ktora = htmlentities($gdzie);


    if (!empty($_SESSION['uzytkwonik_pixi_id']) || isset($_SESSION['uzytkwonik_pixi_id'])) {
        session_regenerate_id($_SESSION['uzytkwonik_pixi_id']); //zmiana sesji dla bezbieczeństwa
        (string) $sesja =  mysqli_real_escape_string($baza,htmlentities($_SESSION['uzytkwonik_pixi_id']));
        if (substr($ktora, 1) == 'logowanie' || substr($ktora, 1) == 'rejestracja' || substr($ktora, 1) == 'logowanie/wchodze' || trim(substr($ktora, 1)) == trim('zadania.php')) {
            header('Location:/');
            exit();
        }
    } else {
        if (substr($ktora, 1) != 'logowanie' && substr($ktora, 1) != 'rejestracja' && substr($ktora, 1) != 'logowanie/wchodze' && trim(substr($ktora, 1)) != trim('zadania.php')) {
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
                    $id = (int) htmlentities($podzial[0]);
                }
                if (!empty($podzial[2])) {
                    $id_2 = (int) htmlentities($podzial[2]);
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
                    header('Location:/profil/'.$podzial[0]);
                }
            } else {
                sprawdzeniestrony('profil', 'php/profile/profil.php');
            }
        } else {
            include "bledy/nieznaleziono.php";
            exit();
        }

    } else if (strpos($ktora, 'logowanie')) {
        if ($ktora == '/logowanie') {
            sprawdzeniestrony('logowanie', "php/logowanie/logowanie.php");
        } else if ($ktora == '/logowanie/wchodze') {
            sprawdzeniestrony('wchodze', 'php/logowanie/sprawdz_uzytkownika.php');
        } else if ($ktora == '/wylogowanie')
            sprawdzeniestrony('wylogowanie', 'php/logowanie/wylogowanie.php');
    } else if (strpos($ktora, 'post'))
        sprawdzeniestrony('post', "php/post.php");
    else if (strpos($ktora, 'rejestracja')) {
        if (strpos($ktora, 'dodaj_uzytkownika')) {
            sprawdzeniestrony('logowanie/dodaj_uzytkownika', 'php');
            exit();
        } else {
            sprawdzeniestrony('rejestracja', 'php/logowanie/rejestracja.php');
            exit();
        }
        ;
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
} catch (\Exception $blod) {
    if (!file_exists('bledy.txt')) {
        fopen('bledy/bledy.txt','a');
      }
      $plik = fopen('bledy/bledy.txt','a');
      fwrite($plik, 'Błąd ' . $blod);
      fclose($plik);
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
