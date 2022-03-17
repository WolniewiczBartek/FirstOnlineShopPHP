<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pl" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Gąbkomarzenie</title>
    <link rel="stylesheet" href="../styl.css">
  </head>
  <body>
    <header>
      <a href="../index.php"><img src="../images/logo.png" id="logo" alt="logo"></a>
      <h1>Gąbkomarzenie</h1>
      <div id="nazwa">
      </div>
    </header>
    <div id="content" class="sameheight">
    <?php
    if(isset($_SESSION['username'])){
        $conn = new mysqli('localhost', 'root', '', 'passwd_hash');
        $sql = "SELECT rola FROM uzytkownicy u JOIN role r ON u.rola_id=r.id WHERE email='$_SESSION[username]'";
        $res = $conn->query($sql);
        $rola = $res->fetch_assoc();
        if($rola['rola']=="admin"){
            echo "<script>document.getElementById('nazwa').innerHTML = '<a class=button href=./zamowienia_wew.php?rola=admin><div>Zamówienia</div></a><a class=button href=./produkty.php?rola=admin><div>Produkty</div></a><a class=button href=./administrator.php><div>Wróć</div></a><a class=button href=../index.php?action=out><div>Wyloguj się</div></a>'</script>";
        }
        else{
            unset($_SESSION['username']);
            header("location: ../index.php?action=log");
        } 
    }
    else{
      header("location: ../index.php?action=log");
    }
    echo <<< OPOLE
    <table>
      <tr>
          <th>Id</th>
          <th>Imie</th>
          <th>Nazwisko</th>
          <th>Data_urodzenia</th>
          <th>Haslo</th>
          <th>Email</th>
          <th>Rola</th>
          <th>Stan</th>
          <th>Edytuj</th>
          <th>Usuń</th>
      </tr>
      
      <tr>
        <form id=add action=../scripts/insert_uzytkownicy.php method=POST></form>
        <td>Nowy</td>
        <td><input name=imie form=add type=text placeholder=Imię></td>
        <td><input name=nazwisko form=add type=text placeholder=Nazwisko></td>
        <td><input name=data_urodzenia form=add type=date></td>
        <td><input name=haslo form=add type=text placeholder=Hasło></td>
        <td><input name=email form=add type=text placeholder=Email></td>
        <td><select name=rola_id form=add>
OPOLE;
    $conn = new mysqli('localhost', 'root', '', 'passwd_hash');
    $sql = "SELECT id, rola from role";
    $res = $conn->query($sql);
    while($rola = $res->fetch_assoc()){
      echo "<option value=$rola[id]>$rola[rola]</option>";
    }
    echo <<< OPOLE
          </select></td>
          <td><select name=stan_id form=add>
OPOLE;
    $sql = "SELECT id, stan from stany order by 2";
    $res = $conn->query($sql);
    while($stan = $res->fetch_assoc()){
      echo "<option value=$stan[id]>$stan[stan]</option>";
    }
    echo <<< OPOLE
          </select></td>
          <td><input type="reset" form=add value="Reset"></td>
          <td><input type="submit" form=add value="Dodaj"></td>
        </tr>
OPOLE;
    $sql = "SELECT u.id, u.imie, u.nazwisko, u.data_urodzenia, u.email, r.rola, s.stan FROM uzytkownicy u JOIN role r ON u.rola_id=r.id JOIN stany s on u.stan_id=s.id";
    $res = $conn->query($sql);
    while($uzytkownik = $res->fetch_assoc()){
      echo <<< OPOLE
      <tr id=uzyt$uzytkownik[id]>
        <td>$uzytkownik[id]</td>
        <td>$uzytkownik[imie]</td>
        <td>$uzytkownik[nazwisko]</td>
        <td>$uzytkownik[data_urodzenia]</td>
        <td>**********</td>
        <td>$uzytkownik[email]</td>
        <td>$uzytkownik[rola]</td>
        <td>$uzytkownik[stan]</td>
        <td><a class=button href=./uzytkownicy.php?action=edit&id=$uzytkownik[id]>Edytuj</a></td>
        <td><a class=button href=../scripts/delete_uzytkownicy.php?id=$uzytkownik[id]>Usuń</a></td>
      </tr>
OPOLE;
    }
    $conn->close();
    if(isset($_GET['action'])){
      if($_GET['action']=='edit'){
        $conn = new mysqli('localhost', 'root', '', 'passwd_hash');
        $sql = "SELECT u.id, u.imie, u.nazwisko, u.data_urodzenia, u.email, u.rola_id, r.rola, s.stan, u.stan_id FROM uzytkownicy u JOIN role r ON u.rola_id=r.id JOIN stany s on u.stan_id=s.id WHERE u.id='$_GET[id]'";
        $uzytkownik = $conn->query($sql)->fetch_assoc();
        $rola = array_diff(array(3 => "admin",1 => "customer",2 => "manager"), array($uzytkownik['rola_id'] => $uzytkownik['rola']));
        $role = "<option value=$uzytkownik[rola_id]>$uzytkownik[rola]</option>";
        foreach($rola as $x => $y){
            $role = $role."<option value=$x>$y</option>";
        }
        $stan = array_diff(array(1 => "nieaktywowany", 2 => "aktywowany", 3 => "zablokowany", 4 => "usunięty"), array($uzytkownik['stan_id'] => $uzytkownik['stan']));
        $stany = "<option value=$uzytkownik[stan_id]>$uzytkownik[stan]</option>";
        foreach($stan as $x => $y){
            $stany = $stany."<option value=$x>$y</option>";
        }
        $id= "uzyt".$_GET['id'];
        echo "<script>document.getElementById('$id').innerHTML=\"<form action=../scripts/update_uzytkownicy.php id=edit method=POST></form><td><input name=id type=hidden form=edit value=$uzytkownik[id]></td><td><input name=imie type=text form=edit value=$uzytkownik[imie]></td><td><input name=nazwisko type=text form=edit value=$uzytkownik[nazwisko]></td><td><input name=data_urodzenia type=date form=edit value=$uzytkownik[data_urodzenia]></td><td><input name=haslo type=text form=edit placeholder=Hasło></td><td><input name=email type=text form=edit value=$uzytkownik[email]></td><td><select name=rola_id form=edit>$role</select></td><td><select name=stan_id form=edit>$stany</select></td><td><input type=reset form=edit value='Reset do ostatnich'></td><td><input type=submit form=edit value=Zapisz></td>\"</script>";
        $conn->close();
      }
    }
     ?>
     </table>
     </div>
     <footer>Bartosz Wolniewicz &copy; 2022</footer>
  </body>
</html>










