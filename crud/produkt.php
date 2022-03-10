<?php
session_start();
function pokaz_produkt_nobuy($id){
  $conn = new mysqli('localhost', 'root', '', 'passwd_hash');
    $sql = "select nazwa, zdjecie, cena, ilosc_magazyn from produkty where id=$id";
    $res = $conn->query($sql);
    while($produkt = $res->fetch_assoc()){
      echo <<< OPOLE
      <div class=produktsingle>
          <div class=zwijaj>
              <img class=bigimg src=../images/$produkt[zdjecie] alt=$produkt[nazwa]>
              <div>
                  <h3>$produkt[nazwa]</h3>
                  <h4>$produkt[cena] zł</h4>
                  <h5 class=ilosc_mag>Dostępność: <span class=sztuki>$produkt[ilosc_magazyn]</span> szt.</h5>
              </div>
          </div>
          <div>
              <a class=button><div>Do koszyka</div></a>
          </div>
    </div>
    <div class=opis>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum eget cursus nulla. Fusce urna felis, porta ac hendrerit at, commodo vitae eros. Nam non odio sed enim porttitor pretium id auctor purus. Morbi nec lorem elit. Nam vel ornare metus, eget congue dolor. Phasellus ac nulla sed arcu iaculis tincidunt. Nunc bibendum pharetra dapibus. Nulla sit amet lorem cursus, venenatis sem sit amet, fermentum magna. Nam vel magna vel eros consequat imperdiet vitae in lectus.</div>
OPOLE;
    }
  $conn->close();
}
function pokaz_produkt($id){
    $conn = new mysqli('localhost', 'root', '', 'passwd_hash');
      $sql = "select nazwa, zdjecie, cena, ilosc_magazyn from produkty where id=$id";
      $res = $conn->query($sql);
      while($produkt = $res->fetch_assoc()){
        echo <<< OPOLE
        <div class=produktsingle>
            <div class=zwijaj>
                <img class=bigimg src=../images/$produkt[zdjecie] alt=$produkt[nazwa]>
                <div>
                    <h3>$produkt[nazwa]</h3>
                    <h4>$produkt[cena] zł</h4>
                    <h5 class=ilosc_mag>Dostępność: <span class=sztuki>$produkt[ilosc_magazyn]</span> szt.</h5>
                </div>
            </div>
            <div>
                <a class=button href=produkt.php?action=koszyk&id=$id><div>Do koszyka</div></a>
            </div>
      </div>
      <div class=opis>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum eget cursus nulla. Fusce urna felis, porta ac hendrerit at, commodo vitae eros. Nam non odio sed enim porttitor pretium id auctor purus. Morbi nec lorem elit. Nam vel ornare metus, eget congue dolor. Phasellus ac nulla sed arcu iaculis tincidunt. Nunc bibendum pharetra dapibus. Nulla sit amet lorem cursus, venenatis sem sit amet, fermentum magna. Nam vel magna vel eros consequat imperdiet vitae in lectus.</div>
OPOLE;
      }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="pl" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Sklep </title>
    <link rel="stylesheet" href="../styl.css">
  </head>
  <body>
    <header>
      <a href="../index.php"><img src="../logo.png" id="logo" alt="logo"></a>
      <h1>Sklep internetowy</h1>      
      <div id="nazwa">
        <a class="button" href="../index.php?action=reg"><div>Rejestracja</div></a>
        <a class="button" href="../index.php?action=log"><div>Zaloguj się</div></a>
      </div>
    </header>
    <div id="content" class="sameheight">
<?php
if(isset($_GET['action'])){
  if($_GET['action']=="koszyk"){
    if(isset($_SESSION['koszyk'][$_GET['id']])){
      $_SESSION['koszyk'][$_GET['id']]++;
    }
    else{
      $_SESSION['koszyk'][$_GET['id']]=1;
    }
  }
}
if(isset($_GET['rola'])){
  if($_GET['rola']=="admin"){
    echo "<script>document.getElementById('nazwa').innerHTML = '<a class=button href=\"../zamowienia_wew.php?rola=admin\"><div>Zamówienia</div></a><a class=button href=\"../uzytkownicy.php\"><div>Użytkownicy</div></a><a class=button href=\"../produkty.php?rola=admin\"><div>Produkty</div></a></a><a class=button href=../administrator.php><div>Wróć</div></a><a class=button href=\"../index.php?action=out\"><div>Wyloguj się</div></a>'</script>";
  }
  elseif($_GET['rola']=="manager"){
    echo "<script>document.getElementById('nazwa').innerHTML = '<a class=button href=\"../zamowienia_wew.php?rola=manager\"><div>Zamówienia</div></a><a class=button href=\"../produkty.php?rola=manager\"><div>Produkty</div></a></a><a class=button href=../manager.php><div>Wróć</div></a><a class=button href=\"../index.php?action=out\"><div>Wyloguj się</div></a>'</script>";
  }
  pokaz_produkt_nobuy($_GET['id']);
}
else{
  if(isset($_SESSION['username'])){
    if($_SESSION['username']!=""){
      echo "<script>document.getElementById('nazwa').innerHTML = '<a class=button href=../koszyk/koszyk.php><div>Koszyk</div></a><a class=button href=../index.php><div>Wróć</div></a><a class=button href=\"../index.php?action=out\"><div>Wyloguj się</div></a>'</script>";
    }
  }
  else{
      echo "<script>document.getElementById('nazwa').innerHTML = '<a class=button href=../index.php><div>Wróć</div></a><a class=button href=\"../index.php?action=reg\"><div>Rejestracja</div></a><a class=button href=\"../index.php?action=log\"><div>Zaloguj się</div></a>'</script>";
  }
  pokaz_produkt($_GET['id']);
} 
?>  
    </div>
    <footer>Bartosz Wolniewicz &copy; 2022</footer>
    <script type="text/javascript" src="../skrypt.js"></script>
  </body>
</html>
