const szukaj = document.getElementById('szukaj');
const lupa = document.querySelector('.lupa');
const wynik_wyszukiwania = document.getElementById('wynik_wyszukiwania');
const formularz_wyszukiwania_na_blogu = document.getElementById('szukaj_na_forum');




window.onload = () => {

if(szukaj){
    szukaj.addEventListener('input', wyszukiwarka);

    szukaj.addEventListener('focus', () => {
        lupa.classList.add('lupa_aktywna');
        lupa.addEventListener('click', zatwierdz_wyszukiwanie);
    });

    szukaj.addEventListener('blur', () => {
        lupa.classList.remove('lupa_aktywna');
        lupa.removeEventListener('click', zatwierdz_wyszukiwanie);
    });

    lupa.addEventListener('click', (e) => {
        e.preventDefault();
    })
}
}

function zatwierdz_wyszukiwanie() {
    formularz_wyszukiwania_na_blogu.submit();
}

function polocz(akcja, wyslij, odbierz) {
    let poloczenie = new XMLHttpRequest();
    poloczenie.open('POST', '/zadania.php', true);
    poloczenie.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    poloczenie.onreadystatechange = () => {
        if (poloczenie.readyState === 4 && poloczenie.status === 200) {
            if (odbierz) {
                document.querySelector(`${odbierz}`).innerHTML = poloczenie.response;
            }  else console.log(poloczenie.response);
        } else {
            console.log('ładowanie');
        }
    }
    poloczenie.send(`ppp=${akcja}&tresc=${wyslij}`);
}



function dodaj_tresc(zadanie, id, tresc) {
    let poloczenie = new XMLHttpRequest();
    poloczenie.open('POST', '/zadania.php', true);
    poloczenie.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    poloczenie.onreadystatechange = () => {
    //    console.log(poloczenie.response);
    }
    poloczenie.send(`ppp=${zadanie}&tresc=${tresc}&id=${id}`);
}




function wyszukiwarka() {
    if (szukaj.value) {
        wynik_wyszukiwania.style.display = "block";
        polocz('wyszukiwarka', szukaj.value, '#wynik_wyszukiwania');
    } else if (!szukaj.value) {
        wynik_wyszukiwania.style.display = "none";
    }
}




function polubposta(p) {
    let idposta = p.dataset.postid;
    polocz('polubienie', idposta);
    licznik = document.querySelector(`[data-postid-licznikpolubien='${idposta}'] span`).innerHTML;
    if (p.classList != 'polubione') {
        p.classList.add('polubione');
        p.innerHTML = "👍🏻polubiłem";
        licznik++;
        document.querySelector(`[data-postid-licznikpolubien='${idposta}'] span`).innerHTML = licznik;


        //poprawnosc pisowni
        let sprawdzenie_polub = document.querySelector(`[data-postid-licznikpolubien='${idposta}'] .polubienie`);
        if (sprawdzenie_polub.innerHTML == " Brak polubień") {
            sprawdzenie_polub.innerHTML = " polubienie";
        } else if (sprawdzenie_polub.innerHTML == " polubienie") {
            sprawdzenie_polub.innerHTML = " polubienia";
        }
    } else {
        p.classList.remove('polubione');
        p.innerHTML = "👍🏻polub";
        licznik--;
        if (!licznik) {
            licznik = "";
        }
        document.querySelector(`[data-postid-licznikpolubien='${idposta}'] span`).innerHTML = licznik;

        //poprawnosc pisowni
        let sprawdzenie_polub = document.querySelector(`[data-postid-licznikpolubien='${idposta}'] .polubienie`);
        if (sprawdzenie_polub.innerHTML == " polubienie") {
            sprawdzenie_polub.innerHTML = " Brak polubień";
        } else if (sprawdzenie_polub.innerHTML == " polubienia") {
            sprawdzenie_polub.innerHTML = " polubienie";
        }
    }
}





function dodajkomentarza(p) {
    let idposta = p.dataset.postidKom;
    let tresc_komentarza = document.querySelector(`[data-postid-kom='${idposta}']`).value;
    if (idposta) {
        if (tresc_komentarza) {
            dodaj_tresc('dodajkomentarz', idposta, tresc_komentarza);
            document.querySelector(`[data-postid-kom='${idposta}']`).value = "";
            pokazkomentarze(idposta);
           let licznikoment = document.querySelector(`[data-postid-licznikomentarzy="${idposta}"]`);
           let licznikomp = document.querySelector(`[data-postid-licznikomentarzyp="${idposta}"]`);
           if (licznikomp.innerHTML === "") {
            licznikomp.innerHTML = "1";
            licznikoment.innerHTML = " komentarz";
           } else {
            licznikomp.innerHTML = parseFloat(licznikomp.innerHTML) + parseFloat(1);
            licznikoment.innerHTML = " komentarze";
           }
        } else {
            alert("Napisz treść komentarza");
        }
    } else {
        alert("Błąd");
    }
}





function pokazkomentarze(p) {
    let idposta;

    
if (typeof(p) === 'object') {
     idposta = p.dataset.postid;
} else {
    idposta = p;
}
    console.log(idposta);


    document.querySelector(`[data-postid-pokakom='${idposta}']`).style.display = 'block';

    polocz('wyswietlkomentarze',idposta,`[data-postid-pokakom='${idposta}']`);

}




function menuposta(p) {
    idposta = p.dataset.postid;
    let menupost =  document.querySelector(`[data-opcje_posta='${idposta}']`);
    menupost.style.display == 'none' ? menupost.style.display = 'block' : menupost.style.display = 'none';
        }
    


        function zaktalizuj_profilowe(p) {
            let idposta = p;
            polocz('zaktalizujprofilowe',idposta);
        }


        function usunposta(p) {
            let idposta = p;
            document.querySelector(`[data-postid='${idposta}']`).innerHTML = "<div style='color:red;font-size:48px;text-align:center;'>Post został usunięty</div>";
            document.querySelector(`[data-postid='${idposta}']`).classList.add("wysrodkuj");
            polocz('usunposta',idposta);
        }


        

function pokaz_kto_polubil(t) {
    let idposta = t.dataset.postidlicznikpolubien;
    dokladneinformacje.style.display = 'flex';
    polocz('kto_polubil', idposta,"#dokladneinformacje");
 }
 