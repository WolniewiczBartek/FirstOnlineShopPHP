<?php
session_start();
 ?>
<!DOCTYPE html>
<html lang="pl" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Sklep </title>
    <link rel="stylesheet" href="styl.css">
  </head>
  <body>
    <header>
      <a href="index.php"><img src="logo.png" id="logo" alt="logo"></a>
      <h1>Sklep internetowy</h1>
      <div id="nazwa">
      </div>
    </header>
    <?php
    if(isset($_GET['action'])){
      if($_GET['action']=="Zalogowano pomyślnie!"){
        $_SESSION['username'] = $_GET['username'];
        echo "<script>document.getElementById('nazwa').innerHTML = '<a class=button href=\"zamowienia_wew.php?rola=admin\"><div>Zamówienia</div></a><a class=button href=\"uzytkownicy.php\"><div>Użytkownicy</div></a><a class=button href=\"produkty.php?rola=admin\"><div>Produkty</div></a><a class=button href=\"index.php?action=out\"><div>Wyloguj się</div></a>'</script>";
      }
    }
    elseif(isset($_SESSION['username'])){
      echo "<script>document.getElementById('nazwa').innerHTML = '<a class=button href=\"zamowienia_wew.php?rola=admin\"><div>Zamówienia</div></a><a class=button href=\"uzytkownicy.php\"><div>Użytkownicy</div></a><a class=button href=\"produkty.php?rola=admin\"><div>Produkty</div></a><a class=button href=\"index.php?action=out\"><div>Wyloguj się</div></a>'</script>";
    }
    echo "<div id=\"content\">";
    $conn = new mysqli('localhost', 'root', '', 'passwd_hash');
    $sql = "select id, nazwa, zdjecie, cena, ilosc_magazyn from produkty where widoczny=1";
    $res = $conn->query($sql);
    while($produkt = $res->fetch_assoc()){
      echo <<< OPOLE
      <div class=produkt>
        <div class=zwijaj>
        <a href=./crud/produkt.php?id=$produkt[id]&rola=admin><img class=midimg src=./images/$produkt[zdjecie] alt=$produkt[nazwa]></a>
          <div>
          <a href=./crud/produkt.php?id=$produkt[id]&rola=admin><h3>$produkt[nazwa]</h3></a>
            <h4>$produkt[cena] zł</h4>
            <h5 class=ilosc_mag>Dostępność: <span class=sztuki>$produkt[ilosc_magazyn]</span> szt.</h5>
          </div>
        </div>
        <div>
          <a class=button><div>Do koszyka</div></a>
          <a class=button href=./crud/produkt.php?id=$produkt[id]&rola=admin><div>Zobacz</div></a>
        </div>
      </div>
OPOLE;
    }
     ?>
     </div>
     <footer>Bartosz Wolniewicz &copy; 2022</footer>
     <script type="text/javascript" src="skrypt.js"></script>
  </body>
</html>
