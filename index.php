<?php
session_start();
if(!isset($_SESSION['koszyk'])){
  $_SESSION['koszyk'] = array();
}
if(isset($_SESSION['username'])&&!isset($_GET['action'])){
  $conn = new mysqli('localhost', 'root', '', 'passwd_hash');
  $sql = "select rola from uzytkownicy where email='$_SESSION[username]'";
  $res = $conn->query($sql)->fetch_assoc();
  if($res['rola']=="admin"){
    header('location: administrator.php');
    exit();
  }
  elseif($res['rola']=="manager"){
    header('location: manager.php');
    exit();
  }
  elseif($res['rola']=="customer"){
    
  }
  else{
    header('location: index.php?action=out');
    exit();
  }
  $conn->close();
}
function pokaz_produkty(){
  echo "<div id=\"content\">";
        $conn = new mysqli('localhost', 'root', '', 'passwd_hash');
        $sql = "select count(*) ile from produkty where widoczny=1";
        $productcount = $conn->query($sql)->fetch_assoc()['ile'];
        $prod_per_page = 2;
        $p=null;
        $pagecount=ceil($productcount/$prod_per_page);
        if(isset($_GET['p'])){
          $p=$_GET['p'];
          $pom=($p-1)*$prod_per_page;
          $sql = "select id, nazwa, zdjecie, cena, ilosc_magazyn from produkty where widoczny=1 order by 1 limit $prod_per_page offset $pom";
          $res = $conn->query($sql);
          while($produkt = $res->fetch_assoc()){
            echo <<< OPOLE
            <div class=produkt>
              <div class=zwijaj>
                <a href=./crud/produkt.php?id=$produkt[id]><img class=midimg src=./images/$produkt[zdjecie] alt=$produkt[nazwa]></a>
                <div>
                <a href=./crud/produkt.php?id=$produkt[id]><h3>$produkt[nazwa]</h3></a>
                  <h4>$produkt[cena] zł</h4>
                  <h5>Dostępność: <span class=sztuki>$produkt[ilosc_magazyn]</span> szt.</h5>
                </div>
              </div>
              <div>
                <a class=button href=./index.php?action=koszyk&id=$produkt[id]&p=$p><div>Do koszyka</div></a>
                <a class=button href=./crud/produkt.php?id=$produkt[id]&p=$p><div>Zobacz</div></a>
              </div>
            </div>
OPOLE;
          }
        }
        else{
          $p=1;
          $sql = "select id, nazwa, zdjecie, cena, ilosc_magazyn from produkty where widoczny=1 order by 1 limit $prod_per_page offset 0";
          $res = $conn->query($sql);
          while($produkt = $res->fetch_assoc()){
            echo <<< OPOLE
            <div class=produkt>
              <div class=zwijaj>
                <a href=./crud/produkt.php?id=$produkt[id]><img class=midimg src=./images/$produkt[zdjecie] alt=$produkt[nazwa]></a>
                <div>
                <a href=./crud/produkt.php?id=$produkt[id]><h3>$produkt[nazwa]</h3></a>
                  <h4>$produkt[cena] zł</h4>
                  <h5>Dostępność: <span class=sztuki>$produkt[ilosc_magazyn]</span> szt.</h5>
                </div>
              </div>
              <div>
                <a class=button href=./index.php?action=koszyk&id=$produkt[id]&p=$p><div>Do koszyka</div></a>
                <a class=button href=./crud/produkt.php?id=$produkt[id]&p=$p><div>Zobacz</div></a>
              </div>
            </div>
OPOLE;
          }
          $conn->close();
        }
        if($p==1&&$pagecount>1){
          echo "<div id=lower_butt><div class=szer></div><div>$p</div><a href=./index.php?p=2 class=button><div>Następna</div></a></div>";
        }
        elseif($p==1&&$pagecount==1){
          
        }
        elseif($p<$pagecount){
          $pp=$p-1;
          $nn=$p+1;
          echo "<div id=lower_butt><a href=./index.php?p=$pp class=button><div>Poprzednia</div></a><div>$p</div><a href=./index.php?p=$nn class=button><div>Następna</div></a></div>";

        }else{
          $pp=$p-1;
          echo "<div id=lower_butt><a href=./index.php?p=$pp class=button><div>Poprzednia</div></a><div>$p</div><div class=szer></div></div>";
        }
}
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
        <a class="button" href="./koszyk/koszyk.php"><div>Koszyk</div></a>
        <a class="button" href="index.php?action=reg"><div>Rejestracja</div></a>
        <a class="button" href="index.php?action=log"><div>Zaloguj się</div></a>
      </div>
    </header>
    <?php
    if(isset($_GET['action'])){
      if($_GET['action']=="reg"){
        echo <<< OPOLE
        <div id="register">
          <h2>Rejestracja</h2>
          <form action="register.php" method="post">
            <input type=text name=mail placeholder=Email><br>
            <input type=password name=haslo1 placeholder=Hasło><br>
            <input type=password name=haslo2 placeholder="Powtórz hasło"><br>
            <input type=text name=imie placeholder=Imię><br>
            <input type=text name=nazw placeholder=Nazwisko><br>
            <input type=date name=urod><br>
OPOLE;
        if(isset($_GET['info'])){
          echo "<br><span id=error>$_GET[info]</span><br>";
        }
        echo <<< OPOLE
            <input type="submit" value="Zarejestruj się!">
          </form>
OPOLE;
        echo "</div>";
      }
      elseif($_GET['action']=="log"){
        if(isset($_GET['login'])){
          echo <<< OPOLE1
          <div id=login>
            <h2>Login</h2>
            <form action=login.php method=post>
              <input type=text name=mail value=$_GET[login]><br>
              <input type=password name=haslo placeholder=Hasło><br>
OPOLE1;
          if(isset($_GET['info'])){
            echo "<br><span id=error>$_GET[info]</span><br>";
          }
          echo <<< OPOLE1
            <input type=submit value="Zaloguj się!">
          </form>
OPOLE1;
          echo "</div>";
        }
        else{
          echo <<< OPOLE2
          <div id=login>
          <h2>Login</h2>
          <form action=login.php method=post>
            <input type=text name=mail placeholder=Login><br>
            <input type=password name=haslo placeholder=Hasło><br>
OPOLE2;
          if(isset($_GET['info'])){
            echo "<br><span id=error>$_GET[info]</span><br>";
          }
          echo <<< OPOLE2
            <input type=submit value="Zaloguj się!">
          </form>
OPOLE2;
          echo "</div>";
        }
      }
      elseif($_GET['action']=="Zalogowano pomyślnie!"){
        $_SESSION['username'] = $_GET['username'];
        pokaz_produkty();
      }
      elseif($_GET['action']=="out"){
        unset($_SESSION['username']);
        unset($_SESSION['koszyk']);
        echo "<script>document.getElementById('nazwa').innerHTML = '<a class=button href=./koszyk/koszyk.php><div>Koszyk</div></a><a class=button href=\"index.php?action=reg\"><div>Rejestracja</div></a><a class=button href=\"index.php?action=log\"><div>Zaloguj się</div></a>'</script>";
        pokaz_produkty();
      }
      if($_GET['action']=="koszyk"){
        if(isset($_SESSION['koszyk'][$_GET['id']])){
          $_SESSION['koszyk'][$_GET['id']]++;
        }
        else{
          $_SESSION['koszyk'][$_GET['id']]=1;
        }
        header("location: ./index.php?p=$_GET[p]");
      }
    }
    else{
      pokaz_produkty();
    }
    if(isset($_SESSION['username'])){
      if($_SESSION['username']!=""){
        echo "<script>document.getElementById('nazwa').innerHTML = '<a class=button href=\"./crud/userinfo.php?login=$_SESSION[username]\"><div>$_SESSION[username]</div></a><a class=button href=koszyk/koszyk.php><div>Koszyk</div></a><a class=button href=\"index.php?action=out\"><div>Wyloguj się</div></a>'</script>";
      }
    }
     ?>
     </div>
     <footer>Bartosz Wolniewicz &copy; 2022</footer>
     <script type="text/javascript" src="skrypt.js"></script>
  </body>
</html>
