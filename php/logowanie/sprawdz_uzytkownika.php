
<?php
try {
    /*
    session_set_cookie_params(
        [
            'path' => '/',
            'samesite' => 'Lax',
        ]
    );
*/
    session_save_path("bazadanych/sesje");
    session_name('sesja_pixi');
    session_start();
    session_set_cookie_params(
        [
            'expires' => 86400,
            'path' => '/',
    //      'domain' => 'domain.example',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict',
        ]
        );


    
    if(!include("php/polocz.php")) throw new Exception("Nie udało sie uzyskać bazy");
    global $baza;


    (bool)$poprawnosc = true;


/*    echo htmlspecialchars($_POST['email']);
    echo htmlspecialchars($_POST['haslo']);
*/

    if (!empty(htmlspecialchars($_POST['email'])) && !empty(htmlspecialchars($_POST['haslo']))) {
        (string)$email =  mysqli_real_escape_string($baza,htmlspecialchars($_POST['email']));
        (string)$haslo =  mysqli_real_escape_string($baza,htmlspecialchars($_POST['haslo']));

        if($zapytanie = mysqli_query($baza, "SELECT * FROM hasla WHERE email = '$email' AND haslo = '$haslo'")) { //sprawdzenie czy nie istnieje taki sam email


        if (mysqli_num_rows($zapytanie) > 0) {
            while ($uzytkownik = mysqli_fetch_assoc($zapytanie)) {
                if ($uzytkownik['email'] == $email && $uzytkownik['haslo'] == $haslo) {
                    $_SESSION['uzytkwonik_pixi_id'] = mysqli_real_escape_string($baza,htmlspecialchars($uzytkownik['id']));
                    $_SESSION['ip'] = htmlspecialchars($_SERVER['REMOTE_ADDR']);
                    $_SESSION['poprawnosc'] = true;
                    header('Location:/');
                }
                exit();
            }
        } else {
            $poprawnosc = false;
            echo 'Nie prawidłowe dane';
        }
    } else  throw new Exception("Nie udało się połączyć z bazą w celu sptawdzenia użytkowanika");
    

    } else {
        $poprawnosc = false;
        echo 'Brak danych';
    }

    $_SESSION['poprawnosc'] = $poprawnosc;

    if(!mysqli_free_result($zapytanie)) throw new Exception("Brak danych");
    mysqli_close($baza);

    header('Location:/');
    exit();
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
