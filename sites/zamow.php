<?php
session_start();
if(!empty($_SESSION['koszyk'])){
    $cena_all = 0.00;
    $lastid=null;
    $conn = new mysqli('localhost', 'root', '', 'passwd_hash');
    foreach($_SESSION['koszyk'] as $id => $sztuki){
        $sql = "select cena from produkty where id=$id";
        $produkt = $conn->query($sql)->fetch_assoc();
        $cena_all += ($sztuki*$produkt['cena']);
    }
    if(isset($_SESSION['username'])&&$_SESSION['username']!=""){
        $sql = "select id from uzytkownicy where email='$_SESSION[username]'";
        $uzytkownik = $conn->query($sql)->fetch_assoc();
       
        $sql = "INSERT into zamowienia (id, uzytkownik_id, data_zamowienia, cena) values(null, $uzytkownik[id], null, $cena_all)";
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
    }
    else{
        header('location: ../index.php?action=log&info=Aby zamówić, zaloguj się!');
    }
}
else{
    header('location: ./koszyk.php');
}
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
    echo <<< OPOLE
    <div class=produkt>
        <h4>Dziękujemy za zamówienie! Numer Twojego zamówienia to $numer_wew</h4>
    </div>
OPOLE;

?>  
    </div>
    <footer>Bartosz Wolniewicz &copy; 2022</footer>
  </body>
</html>



?>