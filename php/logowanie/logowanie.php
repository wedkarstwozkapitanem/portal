<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../zdjecia/logo.png">
    <title>ZALOGUJ SIĘ DO SERWISU SPOŁECZNOŚCIOWEGO</title>
    <meta name="description" content="Logowanie do portalu społecznościowego"> 	
    <link href='http://fonts.googleapis.com/css?family=Akaya+Kanadaka&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
</head>

<body>
    <main>
        <div class="zaloguj">
            <div class="logowanie_panel wysrodkuj tytul"><h1>ZALOGUJ SIĘ DO KOKPITU </h1></div>
            <div class="logowanie_panel wysrodkuj">
                <div class="poprawnosc"><?php try {
                    if (!isset($_SESSION['poprawnosc']) == false) {
                        echo 'Nie poprawne dane logowanie';
                    }}catch (Exception $blod) {if (!file_exists('bledy.txt')) {fopen('bledy/bledy.txt','a');}$plik = fopen('bledy/bledy.txt','a');fwrite($plik, 'Błąd ' . $blod);fclose($plik);exit();}  ?></div>
                <form action="/logowanie/wchodze" method="post" id="zaloguj">
                <div class="poprawnosc" id="poprawnosc_email"></div>
                <input type="email" name="email" id="email" placeholder="Email" />
                <div class="poprawnosc" id="poprawnosc_haslo"></div>
                <input type="password" name="haslo" id="haslo" placeholder="Hasło" autocomplete="off">
                <input class="przycisk" id="przycisk" type="submit" value="Zaloguj się">
                </form>
            </div>
            <a href="/niepamietamhasla">Zapominałem hasła</a><br>
            <a href="/rejestracja">Nie masz konta? <button class="n"> Zarajestruj się tutaj </button></a>
        </div>
    </main>

    <script>
let bledy = [];

let email = document.getElementById('email');
let haslo = document.getElementById('haslo');


window.onload = () => {

    
document.getElementById('przycisk').addEventListener('click',(e)=> {
e.preventDefault();
bledy.splice(0)

document.getElementById('poprawnosc_email').innerHTML = "";
document.getElementById('poprawnosc_haslo').innerHTML = "";

email.style.boxShadow = 'none';
haslo.style.boxShadow = 'none';
if (!email.value) {
    email.style.boxShadow = "0 0 8px red";
    document.getElementById('poprawnosc_email').innerHTML = "Wpisz e-mail!!!";
    bledy.push('Nie wpisano emailu!!!');
}
if (!haslo.value) {
   bledy.push('Nie wpisano hasła!!!');
   document.getElementById('poprawnosc_haslo').innerHTML = "Wpisz hasło!!!";
   haslo.style.boxShadow = "0 0 8px red";
}

let poprawnosc = document.querySelector('.poprawnosc');
poprawnosc.innerHTML = "";
if (!bledy.length) { //skasowac
document.getElementById('zaloguj').submit();
}



});

}
    </script>
</body>

</html>

<style>
    * {
    position: relative;
    margin: 0;
    text-decoration: none;
    list-style-type: none;
}

body {
    background: black;
    min-height: 100vh;
    color: rgb(0, 0, 0);
    font-family: 'Akaya Kanadaka', sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    font-size: 20px;
}

.tytul h1 {
    text-shadow: 0 0 2px #00ff74;
}
.zaloguj {
    animation:panel 3s ease;
}

.wysrodkuj {
    margin-left: auto;
    margin-right: auto;
}

.logowanie_panel {
    width: 88%;
    background: rgba(64, 64, 65, 0.182);
    border-radius: 28px;
    box-shadow: 0 0 8px blue;
    text-align: center;
    padding: 8px;
    margin-top:28px;
}


.logowanie_panel input {
    width: 88%;
    margin: 16px;
    height: 48px;
    background: #ffffff12;
    border: 0;
    box-shadow: 0 0 4px silver;
    border-radius: 9px;
    color: white;
    font-size: 28px;
    text-align: center;
}

.przycisk {
    background: green !important;
    cursor: pointer;
}
.logowanie_panel input:focus {
    box-shadow: 0 0 8px yellow;
    border:0;
}
.przycisk:hover {
    box-shadow: 0 0 8px orange;
}

.zaloguj a {
    color:rgb(12, 12, 12);
    text-shadow: 0 0 2px rgb(183, 255, 0);
    font-size: 28px;
    top:20px;
    font-family: 'Akaya Kanadaka', sans-serif;
}
.poprawnosc {
color: rgb(12, 12, 12);  
text-shadow: 0 0 2px red;
font-size: 28px;
margin:10px;
}
.poprawnosc li {
margin: 8px;
}
@media screen and (max-device-width:1000px) {
    .logowanie_panel {
        width: 80%;
    }
}

.n {
    background: blue;
    color:orange;
    height: 40px;
    font-size: 20px;
    border-radius: 28px;
    border: 0;
    box-shadow: 0 0 4px yellow;
    cursor: pointer;
}

@keyframes panel {
    0% {
        opacity:0;
    }
    100% {
        opacity: 1;
    }
}
</style>