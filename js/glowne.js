const szukaj = document.getElementById('szukaj');
const lupa = document.querySelector('.lupa');
const wynik_wyszukiwania = document.getElementById('wynik_wyszukiwania');
const formularz_wyszukiwania_na_blogu = document.getElementById('szukaj_na_forum');
const dokladneinformacje = document.getElementById('dokladneinformacje');
const gdzie = document.getElementById('przeglodaj');


window.onload = () => {

    wczytywanie_postow();

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
    poloczenie.open('POST', 'zadania.php', true);
    poloczenie.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    poloczenie.onreadystatechange = () => {
        if (poloczenie.readyState === 4 && poloczenie.status === 200) {
            if (odbierz) {
                document.querySelector(`${odbierz}`).innerHTML = poloczenie.response;
            } else console.log(poloczenie.response);
        } else {
            console.log('ładowanie');
        }
    }
    poloczenie.send(`ppp=${akcja}&tresc=${wyslij}`);
}



function dodaj_tresc(zadanie, id, tresc) {
    let poloczenie = new XMLHttpRequest();
    poloczenie.open('POST', 'zadania.php', true);
    poloczenie.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    poloczenie.onreadystatechange = () => {
        console.log(poloczenie.response);
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
    licznik = document.querySelector(`[data-postidlicznikpolubien='${idposta}'] span`).innerHTML;
    if (p.classList != 'polubione') {
        p.classList.add('polubione');
        p.innerHTML = "👍🏻polubiłem";
        licznik++;
        document.querySelector(`[data-postidlicznikpolubien='${idposta}'] span`).innerHTML = licznik;


        //poprawnosc pisowni
        let sprawdzenie_polub = document.querySelector(`[data-postidlicznikpolubien='${idposta}'] .polubienie`);
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
        document.querySelector(`[data-postidlicznikpolubien='${idposta}'] span`).innerHTML = licznik;

        //poprawnosc pisowni
        let sprawdzenie_polub = document.querySelector(`[data-postidlicznikpolubien='${idposta}'] .polubienie`);
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





function pokaz_kto_polubil(t) {
   let idposta = t.dataset.postidLicznikpolubien;
   dokladneinformacje.style.display = 'flex';
   polocz('kto_polubil', idposta,"#dokladneinformacje");
}

















   function wczytywanie_postow() {
        let poloczenie = new XMLHttpRequest();
        poloczenie.open('POST', 'zadania.php', true);
        poloczenie.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        poloczenie.onreadystatechange = () => {
            if (poloczenie.readyState === 4 && poloczenie.status === 200) {
            
              let danenowyposta = JSON.parse(poloczenie.response);
              let danenowypost;
              console.log(danenowyposta);
              

              for(let i=0;i<danenowyposta.length;i++) {

              danenowypost = danenowyposta[i];
              let artykul = document.createElement('article');
              let dodawanie_nowego_artykulu = gdzie.appendChild(artykul);
              let nowy_post_dodaj = document.createElement('div');
              nowy_post_dodaj.className = "post";
              let nowy_postp=dodawanie_nowego_artykulu.appendChild(nowy_post_dodaj);
              nowy_postp.innerHTML = `
                              <div class="post_informacje"><a href='/profil/${danenowypost.iduzytkownika}' style="z-index:12;">
                                      <div><img src="../../zdjecia/${danenowypost.profilowe}" alt="profilowe" /></div>
                                  </a>
                                  <a href="/profil/${danenowypost.iduzytkownika}">
                                      <div class="post_imie">${danenowypost.imie}  ${danenowypost.nazwisko} </div>
                                  </a>
                                  <div class="post_data"><a href="/profil/${danenowypost.iduzytkownika}/post/${danenowypost.id}"><time>${danenowypost.datadodania}</time></a></div>
                                  <div class="opcjeposta wysrodkuj" onclick="menuposta(this)" data-postid="${danenowypost.id}"><span style="top:-10px;">...</span></div>
                              </div>
                              <div class="post_tresc">
                                  ${danenowypost.tresc}
                              <div class="post_zdjecia"></div>
                              `;
              
              dol_posta = document.createElement('div');
              dol_posta.className = "licznik_posta";
              dol = nowy_postp.appendChild(dol_posta);
              
              
              
              if (danenowypost.licznikpolubien >= 2) dol.innerHTML +=  `<div  onclick="pokaz_kto_polubil(this)" class="licznik_polubien" data-postidlicznikpolubien="${danenowypost.id}"><span>${danenowypost.licznikpolubien}</span><span class="polubienie"> polubienia</span></div>`;
              else if (danenowypost.licznikpolubien) dol.innerHTML += `<div  onclick="pokaz_kto_polubil(this)" class="licznik_polubien" data-postidlicznikpolubien="${danenowypost.id}"><span>1</span><span class="polubienie"> polubienie</span></div>`;
              else if (!danenowypost.licznikpolubien) dol.innerHTML += `<div  onclick="pokaz_kto_polubil(this)" class="licznik_polubien" data-postidlicznikpolubien="${danenowypost.id}"><span></span><span class="polubienie"> Brak polubień</span></div>`;
              
              
              if (!danenowypost.licznikomentarzy)  dol.innerHTML +=  `<div class="licznik_komentarzy" onclick="pokazkomentarze(this)" data-postid="${danenowypost.id}"><span data-postid-licznikomentarzyp="${danenowypost.id}"></span><span data-postid-licznikomentarzy="${danenowypost.id}"> Brak komentarzy</span></div>`;
              else if (danenowypost.licznikomentarzy === 1) dol.innerHTML += `<div class="licznik_komentarzy" onclick="pokazkomentarze(this)" data-postid="${danenowypost.id}"><span data-postid-licznikomentarzyp="${danenowypost.id}">1</span><span data-postid-licznikomentarzy="${danenowypost.id}"> komentarz</span></div>`;
              else dol.innerHTML += `<div class="licznik_komentarzy" onclick="pokazkomentarze(this)" data-postid="${danenowypost.id}"><span data-postid-licznikomentarzyp="${danenowypost.id}">${danenowypost.licznikomentarzy}</span><span data-postid-licznikomentarzy="${danenowypost.id}"> komentarze</span></div>`;
              
            
              dol.innerHTML += `<div class="licznik_udustepnien"><span>${null}</span> udostępnienia</div>`;
              
              
              let akcje = document.createElement('div');
              akcje.className = 'post_akcja srodkowanie';
              let akcje_posta = nowy_postp.appendChild(akcje);
              
              
              


      /*      let przyciskpolub = document.createElement('button');
            przyciskpolub.dataset.postid = danenowypost.id;
            if(!danenowypost.polubiono) przyciskpolub.innerText =  '👍🏻polub';
            else przyciskpolub.innerText = '👍🏻polubiłem';
            let przycisk_polub_klik = akcje_posta.appendChild(przyciskpolub);
            przycisk_polub_klik.onclick = polubposta;
*/
              if(!danenowypost.polubiono) akcje_posta.innerHTML += `<button data-postid="${danenowypost.id}" onclick="polubposta(this)">👍🏻polub</button>`;
              else akcje_posta.innerHTML += `<button class="polubione" data-postid="${danenowypost.id}" onclick="polubposta(this)">👍🏻polubiłem</button>`;
              
              akcje_posta.innerHTML += `<button onclick="pokazkomentarze(this)" data-postid="${danenowypost.id}">💬Komentarz</button><button data-postid="${danenowypost.id}">👝Udostępnij</button>`;
              
              let post_komentarze = document.createElement('div');
              post_komentarze.className = "post_komentarze";
              let post_kom_dodaj = nowy_postp.appendChild(post_komentarze);


              post_kom_dodaj.innerHTML += `<div class="dodaj_komentarz_profilowe"><img src='../../zdjecia/${danenowypost.profilowe}' alt='profilowe' /></div>`;
            post_kom_dodaj.innerHTML += `
              <input type="text" placeholder="Skomentuj ten wpis" data-postid-kom="${danenowypost.id}" />
              <label>
                  <div data-postid-kom="${danenowypost.id}" class="dodaj_komentarz" onclick="dodajkomentarza(this)"><img src="../zdjecia/wyslij.png" alt="dodaj_komentarz"></div>
              </label>
              <div data-postid-pokakom="${danenowypost.id}" class="komentarze_post wysrodkuj" style="display: none;">
`;

              }


            } 
        }
        poloczenie.send(`ppp=posty`);
    }




    function menuposta(p) {
alert(p.dataset.postid);
    }