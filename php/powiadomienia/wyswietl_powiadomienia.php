<?php
global $baza;
global $sesja;

$powiadomienia = mysqli_query($baza,"SELECT * FROM `powiadomienia` WHERE `id_odbiorcy` = '$sesja' ORDER BY `id` DESC");


if(mysqli_num_rows($powiadomienia) > 0) {

while($powiadomienie = mysqli_fetch_assoc($powiadomienia)) {

    $id_nadawcy =  $powiadomienie['id_uzytkownika'];
    switch($powiadomienie['typ']) {
        case 1:
            $informacjeonadawcy = mysqli_fetch_assoc(mysqli_query($baza,"SELECT * FROM `uzytkownicy` where `id`='$id_nadawcy'"));
            if($id_nadawcy !== $sesja) {
          echo '
<a href="/profil/'.$id_nadawcy.'/post/'.$powiadomienie['id_tresci'].'">
<div style="text-align:left;width:98%;min-height:48px;background:white;border-radius:8px;border:1px solid black;font-size:20px;color:black;" class="powiadomienie">
<div style="width:44px;height:44px;float:left;margin:1px;"><img style="border-radius:28px;border:1px solid black;" width="100%" height="100%" src="/foty/'.$informacjeonadawcy['folder'].'/profilowe/'.$informacjeonadawcy['profilowe'].'" alt="profilowe"/></div>
<div>'.$informacjeonadawcy['imie']. ' ' .$informacjeonadawcy['nazwisko'].'</div> <div>Dodał posta</div>
</div>
<div style="text-align:left;color:blue;font-size:12px;margin-left:10%;"><time>'.$powiadomienie['datadodania'].'</time></div>
</a>
          ';
            } else {
                echo '
                <a href="/profil/'.$id_nadawcy.'/post/'.$powiadomienie['id_tresci'].'">
                <div style="width:98%;min-height:48px;background:white;border-radius:8px;border:1px solid black;font-size:20px;color:black;" class="powiadomienie">
                <div style="width:44px;height:44px;float:left;margin:1px;"><img style="border-radius:28px;border:1px solid black;" width="100%" height="100%" src="/foty/'.$informacjeonadawcy['folder'].'/profilowe/'.$informacjeonadawcy['profilowe'].'" alt="profilowe"/></div>
                Twój post został opublikowany
                </div>
                <div style="text-align:left;color:blue;font-size:12px;margin-left:10%;"><time>'.$powiadomienie['datadodania'].'</time></div>
                </a>
                          '; 
            }
            break;
        case 2:
            $informacjeonadawcy = mysqli_fetch_assoc(mysqli_query($baza,"SELECT * FROM `uzytkownicy` where `id`='$id_nadawcy'"));
            echo '
  <a href="/profil/'.$powiadomienie['id_odbiorcy'].'/post/'.$powiadomienie['id_tresci'].'">
  <div style="text-align:left;width:98%;min-height:48px;background:white;border-radius:8px;border:1px solid black;font-size:20px;color:black;" class="powiadomienie">
  <div style="width:44px;height:44px;float:left;margin:1px;margin-right:8px;"><img style="border-radius:28px;border:1px solid black;" width="100%" height="100%" src="/foty/'.$informacjeonadawcy['folder'].'/profilowe/'.$informacjeonadawcy['profilowe'].'" alt="profilowe"/></div>
  <div>'.$informacjeonadawcy['imie']. ' ' .$informacjeonadawcy['nazwisko'].'</div> <div>Dodał komentarz</div>
  </div>
  <div style="text-align:left;color:blue;font-size:12px;margin-left:10%;"><time>'.$powiadomienie['datadodania'].'</time></div>
  </a>
            ';
            
            break;
    }




}


} else {
    echo "Brak powiadomień";
}