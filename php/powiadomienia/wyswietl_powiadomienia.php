<?php
global $baza;
global $sesja;


try {
    if ($powiadomienia = mysqli_query($baza, "SELECT * FROM `powiadomienia` WHERE `id_odbiorcy` = '$sesja' ORDER BY `id` DESC")) {

        if (mysqli_num_rows($powiadomienia) > 0) {
            while ($powiadomienie = mysqli_fetch_assoc($powiadomienia)) {
                $id_nadawcy =  $powiadomienie['id_uzytkownika'];
                switch ($powiadomienie['typ']) {
                    case 1:
                        $informacjeonadawcy = mysqli_fetch_assoc(mysqli_query($baza, "SELECT * FROM `uzytkownicy` where `id`='$id_nadawcy'"));
                        if ($id_nadawcy !== $sesja) {
                            echo '
<a href="/profil/' . $id_nadawcy . '/post/' . $powiadomienie['id_tresci'] . '">
<div class="powiadomienie">
<div class="powiadomienie_uzytkownik"><img width="100%" height="100%" src="/foty/' . $informacjeonadawcy['folder'] . '/profilowe/' . $informacjeonadawcy['profilowe'] . '" alt="profilowe"/></div>
<div>' . $informacjeonadawcy['imie'] . ' ' . $informacjeonadawcy['nazwisko'] . '</div> <div>Dodał posta</div>
</div>
<div class="powiadomienie_data"><time>' . $powiadomienie['datadodania'] . '</time></div>
</a>
          ';
                        } else {
                            echo '
                <a href="/profil/' . $id_nadawcy . '/post/' . $powiadomienie['id_tresci'] . '">
                <div  class="powiadomienie">
                <div class="powiadomienie_uzytkownik"><img width="100%" height="100%" src="/foty/' . $informacjeonadawcy['folder'] . '/profilowe/' . $informacjeonadawcy['profilowe'] . '" alt="profilowe"/></div>
                Twój post został opublikowany
                </div>
                <div class="powiadomienie_data"><time>' . $powiadomienie['datadodania'] . '</time></div>
                </a>
                          ';
                        }
                        break;
                    case 2:
                        $informacjeonadawcy = mysqli_fetch_assoc(mysqli_query($baza, "SELECT * FROM `uzytkownicy` where `id`='$id_nadawcy'"));
                        echo '
  <a href="/profil/' . $powiadomienie['id_odbiorcy'] . '/post/' . $powiadomienie['id_tresci'] . '">
  <div class="powiadomienie">
  <div class="powiadomienie_uzytkownik"><img width="100%" height="100%" src="/foty/' . $informacjeonadawcy['folder'] . '/profilowe/' . $informacjeonadawcy['profilowe'] . '" alt="profilowe"/></div>
  <div>' . $informacjeonadawcy['imie'] . ' ' . $informacjeonadawcy['nazwisko'] . '</div> <div>Dodał komentarz</div>
  </div>
  <div class="powiadomienie_data"><time>' . $powiadomienie['datadodania'] . '</time></div>
  </a>
            ';
                        break;
                    case 3:
                        $informacjeonadawcy = mysqli_fetch_assoc(mysqli_query($baza, "SELECT * FROM `uzytkownicy` where `id`='$id_nadawcy'"));
                        echo '
            <a href="/profil/' . $powiadomienie['id_odbiorcy'] . '/post/' . $powiadomienie['id_tresci'] . '">
            <div class="powiadomienie">
            <div class="powiadomienie_uzytkownik"><img width="100%" height="100%" src="/foty/' . $informacjeonadawcy['folder'] . '/profilowe/' . $informacjeonadawcy['profilowe'] . '" alt="profilowe"/></div>
            <div>' . $informacjeonadawcy['imie'] . ' ' . $informacjeonadawcy['nazwisko'] . '</div> <div>Polubił twój post</div>
            </div>
            <div class="powiadomienie_data"><time>' . $powiadomienie['datadodania'] . '</time></div>
            </a>
                      ';
                        break;
                    case 4:
                        $informacjeonadawcy = mysqli_fetch_assoc(mysqli_query($baza, "SELECT * FROM `uzytkownicy` where `id`='$id_nadawcy'"));
                        echo '
            <a href="/profil/' . $powiadomienie['id_uzytkownika'] . '">
            <div class="powiadomienie">
            <div class="powiadomienie_uzytkownik"><img width="100%" height="100%" src="/foty/' . $informacjeonadawcy['folder'] . '/profilowe/' . $informacjeonadawcy['profilowe'] . '" alt="profilowe"/></div>
            <div style="text-align:center;">' . $informacjeonadawcy['imie'] . ' ' . $informacjeonadawcy['nazwisko'] . ' wysłał Ci zaproszenie do grona znajomych</div>
            </div>
            <div class="powiadomienie_data"><time>' . $powiadomienie['datadodania'] . '</time></div>
            </a>
                      ';
                        break;
                    case 5:
                        $informacjeonadawcy = mysqli_fetch_assoc(mysqli_query($baza, "SELECT * FROM `uzytkownicy` where `id`='$id_nadawcy'"));
                        echo '
            <a href="/profil/' . $powiadomienie['id_uzytkownika'] . '">
            <div class="powiadomienie">
            <div class="powiadomienie_uzytkownik"><img width="100%" height="100%" src="/foty/' . $informacjeonadawcy['folder'] . '/profilowe/' . $informacjeonadawcy['profilowe'] . '" alt="profilowe"/></div>
            <div style="text-align:center;">' . $informacjeonadawcy['imie'] . ' ' . $informacjeonadawcy['nazwisko'] . ' przyjął/a twoje zaproszenie do znajomych</div>
            </div>
            <div class="powiadomienie_data"><time>' . $powiadomienie['datadodania'] . '</time></div>
            </a>
                      ';

                        break;
                }
            }
        } else {
            echo "Brak powiadomień";
        }
    } else {
        throw new Exception("Błąd połączenia z powiadomieniami");
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
