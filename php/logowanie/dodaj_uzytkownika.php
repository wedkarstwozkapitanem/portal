<?php
try {
    session_save_path("bazadanych/sesje");
    session_name('sesja_pixi');
    session_start();
    include("php/polocz.php");
    global $baza;
    session_start();


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty(htmlspecialchars($_POST['imie'])) && !empty(htmlspecialchars($_POST['nazwisko'])) && !empty(htmlspecialchars($_POST['data_urodzenia'])) && !empty(htmlspecialchars($_POST['email'])) && !empty(htmlspecialchars($_POST['haslo'])) && !empty(htmlspecialchars($_POST['haslo_powtorz'])) && !empty(htmlspecialchars($_POST['telefon']))) {
            
            (string)$imie = mysqli_real_escape_string($baza, htmlspecialchars($_POST['imie']));
            (string)$nazwisko = mysqli_real_escape_string($baza,  htmlspecialchars($_POST['nazwisko']));
            (string)$data_urodzenia = mysqli_real_escape_string($baza, htmlspecialchars($_POST['data_urodzenia']));
            (string)$email = mysqli_real_escape_string($baza, htmlspecialchars($_POST['email']));
            (string)$haslo = mysqli_real_escape_string($baza, htmlspecialchars($_POST['haslo']));
            (string)$haslo_powtorzone = mysqli_real_escape_string($baza, htmlspecialchars($_POST['haslo_powtorz']));
            (string)$ip = mysqli_real_escape_string($baza, $_SERVER['REMOTE_ADDR']);
            (int)$numer_telefonu = mysqli_real_escape_string($baza, htmlspecialchars($_POST['telefon']));
       
            $niedozwoloneznaki = array( "/","<", ">","?",":","*","|","`","[","]","{","}","!","$","#","%","\ ");
            foreach ($niedozwoloneznaki as $x) {
                if (strpos($imie, "$x") || strpos($nazwisko,"$x") || strpos($data_urodzenia,"$x") || strpos($email,"$x") || strpos($haslo,"$x") || strpos($haslo_powtorzone,"$x") || strpos($ip,"$x")) {
                    echo "niedozwoloneznaki";
                    echo $x;
                    throw new Exception("Nie dozwolone znaki");
                }
            }

            if($zapytanie = mysqli_query($baza, "SELECT * FROM `hasla` WHERE `email` = '$email'")) { //sprawdzenie czy nie istnieje taki sam email
            if ((int)mysqli_num_rows($zapytanie) === (int)0) {
                if ((string)$haslo === (string)$haslo_powtorzone) {
                    if ((int)strlen($haslo) >= (int)4) {
                        try {

                            if($dodawanie_hasel = mysqli_query($baza, "INSERT INTO `hasla` (email,haslo,ip) VALUES ('$email','$haslo','$ip')")) {
                            (int) $id_profilu = mysqli_insert_id($baza);
                            $dodawanie_uzytkownika = mysqli_query($baza, "INSERT INTO `uzytkownicy` (id,imie,nazwisko,wiek,numertelefonu) VALUES ('$id_profilu','$imie','$nazwisko','$data_urodzenia','$numer_telefonu')");
                            $i = mysqli_real_escape_string($baza,htmlspecialchars(strtolower($imie)));
                            $n =  mysqli_real_escape_string($baza,htmlspecialchars(strtolower($nazwisko)));
                            $folder_profilu =  mysqli_real_escape_string($baza,htmlspecialchars("{$i}_{$n}_{$id_profilu}"));
                            if(mkdir("foty/$folder_profilu", 0777)) {
                                mkdir("foty/$folder_profilu/posty", 0777);
                                mkdir("foty/$folder_profilu/wiadomosci", 0777);
                                mysqli_query($baza, "UPDATE `uzytkownicy` SET `folder` = '$folder_profilu' WHERE `id` = '$id_profilu'");
                                $_SESSION['uzytkwonik_pixi_id'] = mysqli_real_escape_string($baza,htmlspecialchars("$id_profilu"));
                                echo 'dodano';
                         //       mail($email,"Dziękujemy za rejestracje","Dziękujemy za rejestracje na naszym portalu");
                                $_SESSION['ip'] = htmlspecialchars($_SERVER['REMOTE_ADDR']);
                            } else {
                            if(!mysqli_query($baza,"DELETE FROM `uzytkownicy` WHERE `id` = '$id_profilu")) {
                                throw new Exception("Wystąpił błąd przy tworzeniu folderu");
                            }
                            }
                        } else {
                            throw new Exception("Nie udało się dodać użytkowniak");
                        }
                            

                            
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
            throw new Exception("Nie udało się połączyć z bazą");
        }
    } else {
        throw new Exception("Nie prawdiłowe dane");
    }
} else {
    throw new Exception("Nie prawidłowe żądanie");
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