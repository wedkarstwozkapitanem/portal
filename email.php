<?php

$naglowek = "Content-Type:".
          ' text/html;charset="UTF-8"'.
          "\nContent-Transfer-Encoding: 8bit";

$email = "dominiklempicki@gmail.com";
$tytul = "Dziękujemy za rejestracje";
$wiadomosc = "<div style='color:green;font-size:48px;text-align:center;'>
<div style='text-align:center;font-size:68px;'>Dziękujemy za rejestracje na tym portalu randkowym
<div style='color:blue;font-size:28px;'>Wkrótce wyślemy tobie dziewczyny z twojej okolicy 👨‍👩‍👦</div>
<a href='http://kaptain.ct8.pl/'>
<button style='height:88px;width:80%;background:blue;color:orange;font-size:48px;text-shadow:0 0 1px green;cursor:pointer;border-radius:28px;'>
Kliknij, aby znależć swoją 2 połówke
</button></a>
Pozdrawiamy</div> 
<br> 
</div>";

if(mail($email,$tytul,$wiadomosc,$naglowek)) {
    echo "pixel";
} else {
    echo "Błąd";
}
?>