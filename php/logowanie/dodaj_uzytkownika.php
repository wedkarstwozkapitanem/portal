<?php
try {
    include("php/polocz.php");
    session_start();


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty(htmlentities($_POST['imie'])) && !empty(htmlentities($_POST['nazwisko'])) && !empty(htmlentities($_POST['data_urodzenia'])) && !empty(htmlentities($_POST['email'])) && !empty(htmlentities($_POST['haslo'])) && !empty(htmlentities($_POST['haslo_powtorz']))) {
            
            (string)$imie = mysqli_real_escape_string($baza, htmlentities($_POST['imie']));
            (string)$nazwisko = mysqli_real_escape_string($baza,  htmlentities($_POST['nazwisko']));
            (string)$data_urodzenia = mysqli_real_escape_string($baza, htmlentities($_POST['data_urodzenia']));
            (string)$email = mysqli_real_escape_string($baza, htmlentities($_POST['email']));
            (string)$haslo = mysqli_real_escape_string($baza, htmlentities($_POST['haslo']));
            (string)$haslo_powtorzone = mysqli_real_escape_string($baza, htmlentities($_POST['haslo_powtorz']));
            (string)$ip = mysqli_real_escape_string($baza, $_SERVER['REMOTE_ADDR']);

            $zapytanie = mysqli_query($baza, "SELECT * FROM `hasla` WHERE `email` = '$email'"); //sprawdzenie czy nie istnieje taki sam email
            if (mysqli_num_rows($zapytanie) <= 0) {

                if ($haslo === $haslo_powtorzone) {
                    if (count_chars($haslo) >= 4) {
                        try {

                            $dodawanie_hasel = mysqli_query($baza, "INSERT INTO `hasla` (email,haslo,ip) VALUES ('$email','$haslo','$ip')");
                            (int) $id = mysqli_insert_id($baza);
                            $dodawanie_uzytkownika = mysqli_query($baza, "INSERT INTO `uzytkownicy` (id,imie,nazwisko,wiek,profilowe) VALUES ('$id','$imie','$nazwisko','$data_urodzenia','uzytkownik.jpg')");
                            $i = mysqli_real_escape_string($baza,htmlentities(strtolower($imie)));
                            $n =  mysqli_real_escape_string($baza,htmlentities(strtolower($nazwisko)));
                            $folder_profilu =  mysqli_real_escape_string($baza,htmlentities("{$i}_{$n}_{$id}"));
                            mkdir("foty/$folder_profilu", 0777);
                            mkdir("foty/$folder_profilu/posty", 0777);
                            mkdir("foty/$folder_profilu/wiadomosci", 0777);
                            mysqli_query($baza, "UPDATE `uzytkownicy` SET `folder` = '$folder_profilu' WHERE `id` = '$id'");

                                $_SESSION['uzytkwonik_pixi_id'] = mysqli_real_escape_string($baza,htmlentities("$id"));
                                echo 'dodano';
                            
                            //    header('Location:index.php');


                        }  catch (PDOException $blod) {
                            if (!file_exists('bledy.txt')) {
                              fopen('bledy/bledy.txt','a');
                            }
                            $plik = fopen('bledy/bledy.txt','a');
                            fwrite($plik, 'Błąd ' . $blod);
                            fclose($plik);
                            print("Błąd");
                            exit();
                          } 
                        catch (Exception $b) {
                            $plik = fopen('bledy/bledy.txt','a');
                            fwrite($plik, 'Błąd ' . $b);
                            fclose($plik);
                            print("Błąd");
                            exit();
                        }


                    } else {
                        echo 'Za krótkie hasło';
                    }
                } else {
                    echo 'Hasła nie zgodne';
                }
            } else {
                echo ' email';
                mysqli_num_rows($zapytanie);
            }
            mysqli_free_result($zapytanie); //zwolnij pamięc


            //mysqli_fetch_all($zapytanie);//pobierz do tablicy


            mysqli_close($baza); //zamknij połoczenie
        } else {
            echo 'Nie prawdiłowe dane!';
        }
    }
} catch (Exception $blod) {
    if (!file_exists('bledy.txt')) {
      fopen('bledy/bledy.txt','a');
    }
    $plik = fopen('bledy/bledy.txt','a');
    fwrite($plik, 'Błąd ' . $blod);
    fclose($plik);
    print("Błąd");
    exit();
  } catch (PDOException $blod) {
    if (!file_exists('bledy.txt')) {
      fopen('bledy/bledy.txt','a');
    }
    $plik = fopen('bledy/bledy.txt','a');
    fwrite($plik, 'Błąd ' . $blod);
    fclose($plik);
    print("Błąd");
    exit();
  }