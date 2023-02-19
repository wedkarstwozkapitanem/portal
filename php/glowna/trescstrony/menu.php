
<nav id="menu">
   <a href="/" style="color:orange;"><div class="tytul"><img src="/zdjecia/logo.png" alt="logo"/></div></a>

    <div id="wyszukiwarka" class="wysrodkuj">
        <form action="" method="POST" id="szukaj_na_forum">
        <div class="wyszukaj wysrodkuj">
        <input type="search" placeholder="Przeszukaj ten portal" id="szukaj" name="szukaj" autocomplete="off">
        <div class="lupa">🔍</div>
        </div>
        </form>
        <div id="wynik_wyszukiwania"></div>
    </div>
    <div class="opcje">
        <ul>
            <li id="powiad">💌
<?php
try {
global $baza;
global $sesja;
echo '<div id="licznikpowiadomien">'.mysqli_num_rows(mysqli_query($baza,"SELECT * FROM `powiadomienia` WHERE `id_odbiorcy` = '$sesja' AND `powiadomienia`.`wyswietlono` = 0")).'</div>';
} catch (Exception $p) {
    echo 0;
}

?>


            </li>
           <a href="/wylogowanie"> <li>🚪</li></a>
        </ul>

    </div>
</div>
</nav>
<aside class="powiadomienia" style="display:none;">
    <h4>Dziennik pokładowy:</h4>
    <hr>
    <div id="powiadomienia">
    
</aside>



<script>
/*    const body = document.querySelector('body');

    let menu = document.createElement('div');
    menu.id = 'menu';
    let meni = body.appendChild(menu);

    let tytul = document.createElement('div');
    tytul.className = 'tytul';
    tytul.addEventListener('click', () => {
        window.location.href = '/';
    });
    tytul.innerHTML = '<img src="/zdjecia/logo.png" alt="logo"/>';
    meni.appendChild(tytul);
    */
</script>