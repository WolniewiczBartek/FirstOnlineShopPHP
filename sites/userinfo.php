<?php
session_start();
function pokaz_userinfo(){
  $conn = new mysqli('localhost', 'root', '', 'passwd_hash');
    $sql = "SELECT u.id, u.imie, u.nazwisko, u.data_urodzenia, u.email, a.kraj, a.miasto, a.kod_pocztowy, a.ulica, a.numer_domu, a.telefon FROM uzytkownicy u left join adresy a on u.id=a.id WHERE u.email='$_SESSION[username]'";
    $res = $conn->query($sql);
    $dane = $res->fetch_assoc();
    $adres = empty($dane['ulica']) ? "<h4>Brak adresu</h4>" : <<< OPOLE
    <div>
      <h3>Dane do wysyłki</h3>
      <h4>Kraj: $dane[kraj]</h4>
      <h4>Adres: $dane[kod_pocztowy] $dane[miasto]</h4>
      <h4>ul. $dane[ulica] $dane[numer_domu]</h4>
      <h4>Telefon: $dane[telefon]</h4>
    </div>

  OPOLE;
    echo <<< OPOLE
    <div class=produkt>
      <div></div>
      <div>
        <h3>Witaj $dane[imie]! Oto twoje konto!</h3>
        <h4>Imię: $dane[imie]</h4>
        <h4>Nazwisko: $dane[nazwisko]</h4>
        <h4>Data urodzenia: $dane[data_urodzenia]</h4>
        <h4>Email: $dane[email]</h4>
      </div>
      $adres
      <div></div>
    </div>
    <div class=zwijaj_duzy>
      <a class=cart_button href=../scripts/delete_uzytkownicy.php?id=$dane[id]><div>Usuń</div></a>
      <a class=cart_button href=userinfo.php?action=edit><div>Edytuj</div></a>
    </div>
OPOLE;
    $conn->close();
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
        <a class="button" href="../index.php?action=reg"><div>Rejestracja</div></a>
        <a class="button" href="../index.php?action=log"><div>Zaloguj się</div></a>
      </div>
    </header>
    <div id="content" class="sameheight">
<?php
    if(isset($_SESSION['username'])){
        if($_SESSION['username']!=""){
          echo "<script>document.getElementById('nazwa').innerHTML = '<a class=button href=./zamowienia.php><div>Zamówienia</div></a><a class=button href=../index.php><div>Wróć</div></a><a class=button href=../index.php?action=out><div>Wyloguj się</div></a>'</script>";
        }
      }
      else{
        header('location: ../index.php?action=log');
      }
    if(isset($_GET['action'])){
      if($_GET['action']=="edit"){
        $conn = new mysqli('localhost', 'root', '', 'passwd_hash');
        $sql = "SELECT u.id, u.imie, u.nazwisko, u.data_urodzenia, u.email, a.kraj, a.miasto, a.kod_pocztowy, a.ulica, a.numer_domu, a.telefon FROM uzytkownicy u left join adresy a on u.id=a.id WHERE u.email='$_SESSION[username]'";
        $res = $conn->query($sql);
        $dane = $res->fetch_assoc();
        echo <<< OPOLE
        <div>
          <table id=userinfo>
            <tr>
              <th colspan=2><h4>Witaj $dane[imie]! Oto twoje konto!</h4></th>
            </tr>
            <form action=../scripts/update_uzytkownik.php?id=$dane[id] id=edituser method=POST></form>
            <tr>
              <td><h4>Email: </h4></td>
              <td><input type=text name=email form=edituser value=$dane[email] autofocus></td>
            </tr>
            <tr>
              <td><h4>Hasło: </h4></td>
              <td><input type=password name=haslo1 form=edituser class=haslo placeholder='Podaj nowe hasło'></td>
            </tr>
            <tr>
              <td><h4>Powtórz hasło: </h4></td>
              <td><input type=password name=haslo2 form=edituser placeholder='Podaj nowe hasło'></td>
            </tr>
            <tr>
              <td><h4>Imię: </h4></td>
              <td><input type=text name=imie form=edituser value=$dane[imie]></td>
            </tr>
            <tr>
              <td><h4>Nazwisko: </h4></td>
              <td><input type=text name=nazwisko form=edituser value=$dane[nazwisko]></td>
            </tr>
            <tr>
              <td><h4>Data urodzenia: </h4></td>
              <td><input type=date name=data_urodzenia form=edituser value=$dane[data_urodzenia]></td>
            </tr>
            <tr>
              <td><h4>Kraj: </h4></td>
              <td><input type=text name=kraj form=edituser value=$dane[kraj]></td>
            </tr>
            <tr>
              <td><h4>Miasto: </h4></td>
              <td><input type=text name=miasto form=edituser value=$dane[miasto]></td>
            </tr>
            <tr>
              <td><h4>Kod pocztowy: </h4></td>
              <td><input type=text name=kod_pocztowy form=edituser value=$dane[kod_pocztowy]></td>
            </tr>
            <tr>
              <td><h4>Ulica: </h4></td>
              <td><input type=text name=ulica form=edituser value=$dane[ulica]></td>
            </tr>
            <tr>
              <td><h4>Numer domu/mieszkania: </h4></td>
              <td><input type=text name=numer_domu form=edituser value=$dane[numer_domu]></td>
            </tr>
            <tr>
              <td><h4>Telefon: </h4></td>
              <td><input type=text name=telefon form=edituser value=$dane[telefon]></td>
            </tr>
            <tr>
              <td colspan=2 align=center>
                <span id=hasloinfo style=display:none;></span>
OPOLE;
        if(isset($_GET['info'])){
          echo "<span id=error>$_GET[info]</span>";
        }
        echo <<< OPOLE
              </td>
            </tr>
            <tr>
              <td><input type=reset form=edituser value=Reset></td>
              <td><input type=submit form=edituser value=Zapisz></td>
            </tr>
          </table>
        </div> 
OPOLE;
        $conn->close();
      }

      else{
        pokaz_userinfo();
      }
    }
    else{
      pokaz_userinfo();
    }
    
    
?>  
    </div>
    <footer>Bartosz Wolniewicz &copy; 2022</footer>
    <script type="text/javascript" src="../skrypt.js"></script>
  </body>
</html>


