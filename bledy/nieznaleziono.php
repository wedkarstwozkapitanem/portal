<!DOCTYPE html>
<html lang="pl">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/../../css/glowne.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="../../zdjecia/logo.png">
    <title>Pixi-twoje miejsce do rozmów</title>
    <meta name="description" content="Pixi.Twoje miejsce do rozmów,rozrywki i czatu z kapitanem">
</head>

<body>
<?php
include "php/glowna/trescstrony/menu.php";
?>
<div>
<h1 style="color:black;text-shadow:0 0 4px red;letter-spacing:4px;">Nie znaleziono danej treści</h1><br>
<h1 style="color:black;font-size:28px;text-shadow:0 0 4px green;letter-spacing:4px;text-align:center">Przekierujemy Ciebie na główną za <span id="czasdo">10</span> sekund</h1>
</div>
</body>
</html>
<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
<script>
     let czas = 9;

     function czasoblicz() {
    document.getElementById('czasdo').innerHTML = czas;
    czas-=1;
    }

    function przekieruj() {
        location.href = "/";
    }

    setTimeout(przekieruj,10200);
    
    setInterval(czasoblicz,1000);
   
</script>