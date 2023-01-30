<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../zdjecia/logo.png">
    <title>ZARAJESTRUJ SIĘ DO SERWISU</title>
    <meta name="description" content="Rejestracja">
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

                <input id="email" name="email" type="email" placeholder="Wpisz email">

                <input type="password" name="haslo" id="haslo" placeholder="Wpisz hasło">

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
        let imie = document.getElementById('imie');
        let nazwisko = document.getElementById('nazwisko');
        let dataurodzenia = document.getElementById('data_urudzenia');
        let email = document.getElementById('email');
        let haslo = document.getElementById('haslo');
        let haslo_powtorz = document.getElementById('haslo_powtorz');

        let wszystkie = document.querySelectorAll('input');

        let sciana = document.querySelector('.sciana');
        let komunikat = document.getElementById('alert_tresc');
        let komunikat_zamknij = document.querySelector('#alert button');
        let akcja = document.getElementById('akcja');

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

            poloczenie.send(`ppp=rejestracja&imie=${imie.value}&nazwisko=${nazwisko.value}&data_urodzenia=${dataurodzenia.value}&email=${email.value}&haslo=${haslo.value}&haslo_powtorz=${haslo_powtorz.value}`);
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