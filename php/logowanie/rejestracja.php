<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../zdjecia/logo.png">
    <title>ZARAJESTRUJ SIĘ DO SERWISU SPOŁECZNOŚCIOWEGO WĘDKARSTWO Z KAPITANEM</title>
    <meta name="description" content="Logowanie do portalu społecznościowego wędkarstwo z kapitanem">
    <meta http-equiv="expires" content="48000"/>	
    <link href='http://fonts.googleapis.com/css?family=Akaya+Kanadaka&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <meta name="Wędkarstwo z kapitanem" content="assigned index"/>
    <meta name="creator" content="Dominik Kapitan Łempicki">
    <meta name="copyright" content="Wędkarstwo z kapitanem" />
    <meta name="application-name" content="Portal wędkarstwo z kapitanem">
    <meta name="keywords" content="wędkartwo z kapitanem,portal,komunikator,wedkuj z kapitanem,łów z kapitanem,ryby,psy,zwierzęta,owczarek niemiecki,rozmiawaj,rozmowy,dziel się z innymi,łowienie,wędkarstwo spinngowe,wędkarstwo spławikowe,wędkarstwo gruntowe,spinning,spławik,grunt,jak łowić,metody,gatunki">
    <meta name="robots" content="index,follow"/>
</head>

<body>
    <div style="width:100%;position:relative;">
        <div class="wysrodkuj">
            <h1>Formularz rejestracji do serwisu</h1>
            <h4 style="color:red;">Wypełnij swoje dane</h4>
        </div>
        <div class="formularz wysrodkuj">
            <form action="" method="post">
                <div class="blad" id="nazwa"></div>
                <div>
                    <input style="width: 38%;" type="text" name="imie" id="imie" placeholder="imie">
                    <input style="width:38%;" type="text" id="nazwisko" id="nazwisko" placeholder="nazwisko">
                </div>
                <div style="clear:both;position: absolute;z-index: 4;left:10%;top:60px;"> Data urudzenia </div>
                <input type="date" name="data_urodzenia" id="data_urudzenia" value="2006-05-02">

                <input type="number" name="telefon" id="telefon" placeholder="numer telefonu (same liczby)" />

                <input id="email" name="email" type="email" placeholder="Wpisz email">

                <input type="password" name="haslo" id="haslo" placeholder="Wpisz hasło" autocomplete="off">

                <input type="password" name="haslo_powtorz" id="haslo_powtorz" placeholder="Powtórz hasło">

                <input id="rejestruj" class="przycisk" type="submit" value="Zarajestruj się">

            </form>

            <div class="link"><a href="/logowanie">Masz już konto? Zaloguj się tutaj</a></div>
        </div>

        <div class="sciana">
            <div id="alert">
                <div style="font-size:40px;position:relative;width:100%;"><span id="akcja"></span> <button>X</button></div>
                <hr>
                <div id="alert_tresc">Trwa rejestracja</div>
            </div>
        </div>
    </div>
    <script>
        
        const imie = document.getElementById('imie');
        const nazwisko = document.getElementById('nazwisko');
        const dataurodzenia = document.getElementById('data_urudzenia');
        const email = document.getElementById('email');
        const haslo = document.getElementById('haslo');
        const haslo_powtorz = document.getElementById('haslo_powtorz');
        const numer_telefonu = document.getElementById('telefon');

        const wszystkie = document.querySelectorAll('input');

        const sciana = document.querySelector('.sciana');
        const komunikat = document.getElementById('alert_tresc');
        const komunikat_zamknij = document.querySelector('#alert button');
        const akcja = document.getElementById('akcja');

        let bledy = new Array();

        window.onload = () => {
        document.getElementById('rejestruj').addEventListener('click', (e) => {
            e.preventDefault();
            bledy.splice(0);




            for (let i = 0; i < wszystkie.length - 1; i++) {
                wszystkie[i].classList.remove('blod');
                komunikat.innerHTML = "";
            }

            if (!imie.value || !nazwisko.value) {
                if (!imie.value) {
                    imie.classList = "blod";
                    bledy.push('Brak imienia')
                }
                if (!nazwisko.value) {
                    nazwisko.classList = "blod";
                    bledy.push('Brak nazwiska')
                }
            }
            if (!dataurodzenia.value) {
                dataurodzenia.classList = "blod";
                bledy.push('Nie wpisana data urudzenia')
            }
            if (!email.value) {
                email.classList = "blod";
                bledy.push('Brak emailu')
            }
            if (!haslo.value) {
                haslo.classList = "blod";
                bledy.push('Brak hasła');
            }
            if (!haslo_powtorz.value) {
                haslo_powtorz.classList = "blod";
                bledy.push('Nie potwierdzono hasła')
            }
            if (!numer_telefonu.value) {
             numer_telefonu.classList = "blod";
             bledy.push('Brak numeru telefonu');   
            } else if (numer_telefonu.value.length >= 24) {
            numer_telefonu.classList = "blod";
             bledy.push('Nie prawidłowy numer telefonu');
            }



            if (!bledy.length) {
                if (haslo.value == haslo_powtorz.value) {
                    if (haslo.value.length >= 4) {

                        wyslij_uzytkownika();


                    } else {
                        bledy.push('Hasło musi mieć minimum 4 znaki');
                        haslo.classList.add('blod');
                        pokazblod();
                    }
                } else {
                    haslo_powtorz.classList = "blod";
                    bledy.push('Hasła nie są zgodne');
                    pokazblod();
                }
            } else {
                //  alert('Niepowodzenie');
                pokazblod();

            }


        });
    }

    
        function pokazblod() {
            akcja.innerText = "Niepowodzenie:";
            sciana.style.display = "flex";
            komunikat_zamknij.addEventListener('click', () => {
                sciana.style.display = "none";
            });

            for (let i = 0; i < bledy.length; i++) {
                let licznik = i + 1;
                komunikat.innerHTML += '<div><span  style="position:absolute;left:0;">' + licznik + '</span>' + bledy[i] + '</div>'
            }
        }

        function wyslij_uzytkownika() {
            let poloczenie = new XMLHttpRequest();
            poloczenie.open('POST', '/zarajestruj.php', true);
            poloczenie.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            poloczenie.onload = () => {
                let odpowiedz = poloczenie.responseText;
                console.log(odpowiedz);
                sciana.style.display = "flex";
                komunikat_zamknij.addEventListener('click', () => {
                    sciana.style.display = "none";
                });


                if (odpowiedz == 'dodano') {
                    akcja.innerText = "Sukcess!!!";
                    komunikat.innerHTML = "Zarejstrowano";
                    location.replace('/');
                }
                if (odpowiedz.includes('email')) {
                    akcja.innerText = "Niepowodzenie"
                    komunikat.innerHTML = "Podany email jest już zarejstrowany";
                    email.classList = 'blod';
                }
                if (odpowiedz.includes('niedozwoloneznaki')) {
                    akcja.innerText = "Niepowodzenie"
                    komunikat.innerHTML = "Występują niedozwolone znaki z zakresu:  - / < > ? : * | , \ ` & $ { } ( ) ! # %";
                }

            }

            poloczenie.send(`ppp=rejestracja&imie=${imie.value}&nazwisko=${nazwisko.value}&data_urodzenia=${dataurodzenia.value}&email=${email.value}&haslo=${haslo.value}&haslo_powtorz=${haslo_powtorz.value}&telefon=${numer_telefonu.value}`);
        }
    </script>
</body>

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
        color: white;
        font-family: fantasy;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        font-size: 20px;
    }


    .wysrodkuj {
        margin-left: auto;
        margin-right: auto;
    }

    .formularz {
        width: 40%;
        min-height: 288px;
        background: rgb(138, 135, 135);
        box-shadow: 0 0 8px blue;
        border-radius: 8px;
        font-size: 28px;
        color: blue;
        padding: 12px;
    }

    .formularz input {
        width: 80%;
        height: 48px;
        background: silver;
        border-radius: 8px;
        border: 0;
        box-shadow: 0 4px 4px black;
        font-size: 28px;
        margin: 10px 16px 10px 0;
    }

    .formularz input:focus {
        border: 0;
        box-shadow: 0 0 2px green;
        outline: 0;
    }


    .przycisk {
        background: orange !important;
        margin: 20px;
        color: red;
        cursor: pointer;
        font-weight: 888;
    }

    .przycisk:hover {
        color: orange;
        background: red !important;
    }

    .blod {
        box-shadow: 0 0 8px red !important;
    }

    .link a {
        color: rgb(241 241 241);
        font-family: cursive;
        text-shadow: 0 0 3px red;
    }

    @media screen and (max-device-width:1000px) {
        .formularz {
            width: 88%;
        }

        #alert {
            width: 88% !important;
        }
    }


    .sciana {
        position: fixed;
        width: 100%;
        height: 100%;
        background-color: #000000ed;
        ;
        top: 0;
        left: 0;
        z-index: 8;
        justify-content: center;
        align-items: center;
        display: none;
    }

    #alert {
        width: 40%;
        background: white;
        min-height: 288px;
        animation: pokazalert 4s ease;
        color: black;
    }

    #alert button {
        position: absolute;
        right: 0;
        color: silver;
        height: 48px;
        width: 48px;
        font-size: 38px;
        cursor: pointer;
        background: none;
        border: 0;
    }

    #alert button:hover {
        color: red !important;
    }

    #alert_tresc {
        color: red;
        font-size: 48px;
    }

    #alert_tresc div {
        border: 1px groove brown;
    }

    @keyframes pokazalert {
        0% {
            top: -100%;
        }

        100% {
            top: 0;
        }
    }
</style>