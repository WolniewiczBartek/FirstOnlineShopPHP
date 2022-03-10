<?php
session_start();
$p = isset($_GET['p']) ? $_GET['p'] : 1;
function pokaz_koszyk(){
  $cena_all = 0.00;
  if(!empty($_SESSION['koszyk'])){
    echo <<< OPOLE
    <div class=produkt>
      <a class=cart_button href=./koszyk.php?action=delall><div>Opróżnij</div></a>
      <a class=cart_button href=./zamow.php><div>Zamów</div></a>
    </div>
OPOLE;
    foreach($_SESSION['koszyk'] as $id => $sztuki){
      $conn = new mysqli('localhost', 'root', '', 'passwd_hash');
      $sql = "select nazwa, zdjecie, cena, ilosc_magazyn from produkty where id=$id";
      $res = $conn->query($sql);
      while($produkt = $res->fetch_assoc()){
        $cena = ($sztuki*$produkt['cena']);
        $cena_all += $cena;
        $cena = number_format($cena,2);
        echo <<< OPOLE
        <div class=produkt>
          <div class=zwijaj>
          <a href=../crud/produkt.php?id=$id><img class=midimg src=../images/$produkt[zdjecie] alt=$produkt[nazwa]></a>
            <div>
            <a href=../crud/produkt.php?id=$id><h3>$produkt[nazwa]</h3></a>
              <h4>$cena zł</h4>
              <h5>$sztuki szt.</h5>
            </div>
          </div>
          <div>
            <a class=button href=./koszyk.php?action=del&id=$id><div>Usuń</div></a>
            <a class=button href=./koszyk.php?action=plus&id=$id&max=$produkt[ilosc_magazyn]><div>+1</div></a>
            <a class=button href=./koszyk.php?action=minus&id=$id><div>-1</div></a>
          </div>
        </div>
OPOLE;
      }
  }
    $cena_all = number_format($cena_all, 2);
    echo <<< OPOLE
    <div class=produkt>
      <h2 style=margin-left:20px;>Podsumowanie:</h2>
      <h2 style=margin-right:20px;>$cena_all zł</h2>
    </div>
OPOLE;
    $conn->close();
  }
  else{
    echo "<div>Koszyk jest pusty!</div>";
  }
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
    if(isset($_SESSION['username'])){
        if($_SESSION['username']!=""){
          echo "<script>document.getElementById('nazwa').innerHTML = '<a class=button href=../index.php?p=$p><div>Wróć</div></a><a class=button href=\"../index.php?action=out\"><div>Wyloguj się</div></a>'</script>";
        }
      }
      else{
        echo "<script>document.getElementById('nazwa').innerHTML = '<a class=button href=../index.php?p=$p><div>Wróć</div></a><a class=button href=../index.php?action=reg><div>Rejestracja</div></a><a class=button href=../index.php?action=log><div>Zaloguj się</div></a>'</script>";
      }
    if(isset($_GET['action'])){
      if($_GET['action']=="del"){
        unset($_SESSION['koszyk'][$_GET['id']]);
      }
      elseif($_GET['action']=="delall"){
        unset($_SESSION['koszyk']);
      }
      elseif($_GET['action']=="plus"){
        if($_SESSION['koszyk'][$_GET['id']]<$_GET['max']){
          $_SESSION['koszyk'][$_GET['id']]++;
          header('location: koszyk.php');
        }
      }
      elseif($_GET['action']=="minus"){
        if($_SESSION['koszyk'][$_GET['id']]>1){
          $_SESSION['koszyk'][$_GET['id']]--;
          header('location: koszyk.php');
        }
        elseif($_SESSION['koszyk'][$_GET['id']]==1){
          header("location: koszyk.php?action=del&id=$_GET[id]");
        }
      }
    }
    pokaz_koszyk();
?>  
    </div>
    <footer>Bartosz Wolniewicz &copy; 2022</footer>
  </body>
</html>

