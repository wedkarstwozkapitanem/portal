<head>
    <link rel="shortcut icon" href="https://pbs.twimg.com/media/E0oZqutXIAoUhuN?format=png&name=small">
</head>
<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
</a>
<html>
<center><span style="font-size:600%;color: blue;background-color:pink;border:outset;border-width:28px;border-color:green;">Czatuj🎣🐕‍🦺</span><br><br><br>
</html>
<a href="#wyslij"><span style="font-size:48px;color:green;">Wyślij wiadomość</span></a>
<form action="szukaj.php" method="post"><br>
Szukaj: <input style="height:28px;width:40%;" placeholder="szukaj na czacie" type="text" name="nazw" /><input type="submit" name="button" value="szukaj" />
</form> 
<?php
    include("aja.php");
?>
<?php
if ($_POST['button'] == "wyślij") {
/* sprawdzam czy dane zostały wysłane z formularza */
  $plik = "db.txt";
  if (is_writeable($plik)) {
  /* sprawdzam czy plik jest do zapisu */
    if (!$handle = fopen($plik, "a")) echo "Błąd...";
    if (fwrite($handle, $_POST['imie']." || <fieldset <strong><b> ".$_POST['nazwa']." || </strong></b>" .$_POST['tresc']."<i></fieldset>
") === FALSE) echo "Błąd...";
      else echo "Wiadomość wysłana!...<br>";
    fclose($handle);



  } else echo "Nie udało się..";
}

#$plik = "db.txt";
#$dane = file($plik); /* pobieram dane z pliku i zapisuje do tablicy (linia = rekord) */
#for($i=0;$i<count($dane);$i++) { /* przeszukuję tablicę */
#  list($uzytkownik[$i], $nazwa[$i], $tresc[$i]) = explode(" || ", $dane[$i]);
#   /* dziele linię na tablicę i zapisuje dane do odpowiednich zmienncyh */
#}
#for($i=0;$i<count($uzytkownik);$i++) /* przeszukuję tablicę */
#
#   echo $uzytkownik[$i]." ".$nazwa[$i]." <b> wysłał/a </b><br> ".$tresc[$i]."<br />";
#   /* wyświetlam dane */
?>
</center>
<a name="wyslij">
<div class="for"
<form>
<form action="czat.php#wyslij" method="post">
<input type="hidden" STYLE="color:aqua;width:48%; height:48px;background-color:yellow;font-size: 48px" type="text" name="nazwa" placeholder="Nazwa użytkownika" class="naz" value="<span style='color:green'><?php echo htmlspecialchars($_SESSION["username"]); ?></span>"  readonly/></br>
<span style="color: pink;font-size:xxx-large">Użytkownik:</span>    <input STYLE="color:aqua;width:48%; height:48px;background-color:orange;font-size: 48px" type="text" placeholder="Nazwa użytkownika" class="naz" value="<?php echo htmlspecialchars($_SESSION["username"]); ?>"  readonly/></br>
<!--<span style="color: green;font-size:xxx-large">treść wiadomości:</span>--> <input STYLE="color:lime;width:88%; height:188px;background-color:teal;font-size: 48px" type="text" placeholder="Napisz wiadomość" name="tresc" value="" /></input>
<input STYLE="color:lime;background:blue;width:10%;height:188px;font-size: 48px;" type="submit" name="button" value="wyślij" />
</form>
</a>
<style>
.for {
background: green;
height: 368px;
width: 100%;
cursor: url(https://blogger.googleusercontent.com/img/a/AVvXsEh0AWjHyTlWP8WfTGkQSoxxoDMxImtzoWCcPzG6HsEfCyKVfxi9wIvgbj6WtzmwsLQdweFlwzgr2jyOFmDxQ5120Vr_kSfWYcvsu7V7nkd_e25h00ABnerFRPwnpjJyHr0t903DJsT84He711hH-7slZvC17jc7oHQnCUrLXex80MzWyIwtddOI7vqq=w72-h72-p-k-no-nu), pointer
}
.btn {
background: red;
height: 28px;
width:28%;
}
.naz {
cursor: url(https://blogger.googleusercontent.com/img/a/AVvXsEh0AWjHyTlWP8WfTGkQSoxxoDMxImtzoWCcPzG6HsEfCyKVfxi9wIvgbj6WtzmwsLQdweFlwzgr2jyOFmDxQ5120Vr_kSfWYcvsu7V7nkd_e25h00ABnerFRPwnpjJyHr0t903DJsT84He711hH-7slZvC17jc7oHQnCUrLXex80MzWyIwtddOI7vqq=w72-h72-p-k-no-nu), pointer
}
  ::placeholder {
      color: aqua;
      font-size:auto;
  }
</style>  
<script>
function op(obj) {
x=document.getElementById(obj);
if(x.style.display == "none") x.style.display = "block";
else x.style.display = "none"
}
</script>
<br><br><a class="ustaw" href="/" onClick="op('obj'); return false;"><span style="font-size:48px;">Ustawienia</span></a>
<div id="obj" style="display:none">
<a href="logout.php">
  <button class="btn">
  Wyloguj
  </button>  
  </div></div> 
<style>
.btn { 
position: relative;right: -28%;bottom: 68px;
 }
.ustaw {
position:relative;right:;bottom:28px;
}
</style>