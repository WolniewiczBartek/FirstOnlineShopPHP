<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pl" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Gąbkomarzenie</title>
    <link rel="icon" type="image/x-icon" href="../images/favicon.ico">
    <link rel="stylesheet" href="../styl.css">
  </head>
  <body>
    <header>
      <a href="../index.php"><img src="../images/logo.png" id="logo" alt="logo"></a>
      <h1>Gąbkomarzenie</h1>
      <div id="nazwa">
<?php
echo <<< OPOLE
        <a class=button href=./userinfo.php><div>Moje konto</div></a>
        <a class=button href=../index.php><div>Wróć</div></a>
        <a class=button href="../index.php?action=out"><div>Wyloguj się</div></a>
OPOLE;
?>
      </div>
    </header>
    <div id="content" class="sameheight">
<?php
$conn = new mysqli('localhost', 'root', '', 'passwd_hash');
if(isset($_GET['action'])){
  if($_GET['action']=="ok"){
    foreach($_POST as $val){
      if(empty($val)){
        header("location: zamow.php?info=Wypełnij wszystkie dane");
        exit();
      }
    }
    $sql = "INSERT into adresy values ('$_POST[id]', '$_POST[kraj]', '$_POST[miasto]', '$_POST[kod_pocztowy]', '$_POST[ulica]', '$_POST[numer_domu]', '$_POST[telefon]')";
    $conn->query($sql);
    header("location: zamow.php?action=zamow&id=$_POST[id]");
    exit();
  }
  elseif($_GET['action']=="zamow"){
    $cena_all = 0.00;
    $lastid=null;
    foreach($_SESSION['koszyk'] as $id => $sztuki){
      $sql = "select cena from produkty where id=$id";
      $produkt = $conn->query($sql)->fetch_assoc();
      $cena_all += ($sztuki*$produkt['cena']);
    }
    $sql = "INSERT into zamowienia (id, uzytkownik_id, data_zamowienia, cena) values(null, $_GET[id], null, $cena_all)";
    $conn->query($sql);
    $lastid = $conn->insert_id;
    $numer_wew = strval("#".date('Y/m/d/').$lastid);
    $sql = "UPDATE zamowienia set numer_wew='$numer_wew' where id=$lastid";
    $conn->query($sql);

    foreach($_SESSION['koszyk'] as $id => $sztuki){
        $sql = "UPDATE produkty SET ilosc_magazyn = ilosc_magazyn-$sztuki where id=$id";
        $conn->query($sql);
        $sql = "INSERT into zamowienia_produkty (zamowienie_id, produkt_id, ilosc) values($lastid, $id, $sztuki)";
        $conn->query($sql);
        unset($_SESSION['koszyk'][$id]);
    }
    $sql = "UPDATE produkty SET widoczny=0 where ilosc_magazyn=0";
    $conn->query($sql);
    $conn->close();
    echo <<< OPOLE
    <div class=produkt>
        Dziękujemy za zamówienie! Numer Twojego zamówienia to $numer_wew
    </div>
OPOLE;
  }
}
else{
  if(!empty($_SESSION['koszyk'])){
  
    if(isset($_SESSION['username'])&&$_SESSION['username']!=""){
        $sql = "select u.id, kraj, miasto, kod_pocztowy, ulica, numer_domu, telefon from uzytkownicy u left join adresy a on u.id=a.id where email='$_SESSION[username]'";
        $uzytkownik = $conn->query($sql)->fetch_assoc();

        if(empty($uzytkownik['kraj']) || empty($uzytkownik['miasto']) || empty($uzytkownik['kod_pocztowy']) || empty($uzytkownik['ulica']) || empty($uzytkownik['numer_domu']) || empty($uzytkownik['telefon'])){
          echo <<< OPOLE
            <form id=address action=zamow.php?action=ok method=post>
              <h4>Podaj dane do wysyłki</h4>
              <input type=hidden name=id value=$uzytkownik[id]><br>
              <input type=text name=kraj placeholder=Kraj value='$uzytkownik[kraj]' autofocus><br>
              <input type=text name=miasto placeholder=Miasto value=$uzytkownik[miasto]><br>
              <input type=text name=kod_pocztowy placeholder='Kod pocztowy' value=$uzytkownik[kod_pocztowy]><br>
              <input type=text name=ulica placeholder=Ulica value=$uzytkownik[ulica]><br>
              <input type=text name=numer_domu placeholder='Numer domu/mieszkania' value=$uzytkownik[numer_domu]><br>
              <input type=text name=telefon placeholder=Telefon value=$uzytkownik[telefon]><br>
OPOLE;
        if(isset($_GET['info'])){
          echo "<span id=error>$_GET[info]</span><br>";
        }
        echo <<< OPOLE
                      
              <input type=reset value=Reset><br>
              <input type=submit value=Zapisz>
            </form>
OPOLE;
      }
      else{
        header("location: zamow.php?action=zamow&id=$uzytkownik[id]");
        exit();
      }
    }
    else{
      header('location: ../index.php?action=log&info=Aby zamówić, zaloguj się!');
      exit();
    }
  }
  else{
    header('location: ./koszyk.php');
    exit();
  }
  $conn->close();
}



?>  
    </div>
    <script type="text/javascript" src="../skrypt.js"></script>
    <footer>Bartosz Wolniewicz &copy; 2022</footer>
  </body>
</html>



?>