const gdzie = document.querySelector('body');  // do zmiany






function wczytywanie_postow() {
    let poloczenie = new XMLHttpRequest();
    poloczenie.open('POST', 'zadania.php', true);
    poloczenie.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    poloczenie.onreadystatechange = () => {
        if (poloczenie.readyState === 4 && poloczenie.status === 200) {
          let danenowypost = JSON.parse(poloczenie.response)[0];
          console.log(danenowypost);

          
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
                          </div>
                          <div class="post_tresc">
                              ${danenowypost.tresc};
                              <div class="post_zdjecia"></div>
                          `;
          /*
          dol_posta = document.createElement('div');
          dol_posta.className = "licznik_posta";
          dol = nowy_postp.appendChild(dol_posta);
          
          
          
          if (liczniklike >= 2) dol.innerHTML +=  `<div  onclick="pokaz_kto_polubil(this)" class="licznik_polubien" data-postidlicznikpolubien="${post['id']}"><span>${sprawdzanie}</span><span class="polubienie"> polubienia</span></div>`;
          else if (liczniklike === 1) dol.innerHTML += `<div  onclick="pokaz_kto_polubil(this)" class="licznik_polubien" data-postidlicznikpolubien="${post['id']}"><span>1</span><span class="polubienie"> polubienie</span></div>`;
          else if (liczniklike === 0) dol.innerHTML += `<div  onclick="pokaz_kto_polubil(this)" class="licznik_polubien" data-postidlicznikpolubien="${post['id']}"><span></span><span class="polubienie"> Brak polubień</span></div>`;
          
          
          if (!licznikom)  dol.innerHTML +=  `<div class="licznik_komentarzy" onclick="pokazkomentarze(this)" data-postid="${post['id']}"><span data-postid-licznikomentarzyp="${post['id']}"></span><span data-postid-licznikomentarzy="${post['id']}"> Brak komentarzy</span></div>`;
          else if (licznikom === 1) dol.innerHTML += `<div class="licznik_komentarzy" onclick="pokazkomentarze(this)" data-postid="${post['id']}"><span data-postid-licznikomentarzyp="${post['id']}">1</span><span data-postid-licznikomentarzy="${post['id']}"> komentarz</span></div>`;
          else dol.innerHTML += `<div class="licznik_komentarzy" onclick="pokazkomentarze(this)" data-postid="${post['id']}"><span data-postid-licznikomentarzyp="${post['id']}">${licznikom}</span><span data-postid-licznikomentarzy="${post['id']}"> komentarze</span></div>`;
          
          
          dol.innerHTML += `<div class="licznik_udustepnien"><span>${udustepnienia}</span> udostępnienia</div>`;
          
          
          let akcje = document.createElement('div');
          
          akcje.className = 'post_akcja srodkowanie';
          let akcje_posta = nowy_postp.appendChild(akcje);
          
          if(!czypulubilem) akcje_posta.innerHTML += `<button data-postid="${post['id']}" onclick="polubposta(this)">👍🏻polub</button>`;
          else akcje_posta.innerHTML += `<button class="polubione" data-postid="${post['id']}" onclick="polubposta(this)">👍🏻polubiłem</button>`;
          
          akcje_posta.innerHTML += `<button onclick="pokazkomentarze(this)" data-postid="${post['id']}">💬Komentarz</button><button data-postid="${post['id']}">👝Udostępnij</button>`;
          
          let post_komentarze = document.createElement('div');
          post_komentarze.className = "post_komentarze";
          let post_kom_dodaj = nowy_postp.appendChild(post_komentarze);


*/




        } 
    }
    poloczenie.send(`ppp=posty`);
}



function pokaz_kto_polubil(t) {
    let idposta = t.dataset.postidlicznikpolubien;
    dokladneinformacje.style.display = 'flex';
    polocz('kto_polubil', idposta,"#dokladneinformacje");
 }
 