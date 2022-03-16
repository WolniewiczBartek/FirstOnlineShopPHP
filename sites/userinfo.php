<?php
session_start();
function pokaz_userinfo(){
  $conn = new mysqli('localhost', 'root', '', 'passwd_hash');
    $sql = "SELECT * FROM uzytkownicy WHERE email='$_SESSION[username]'";
    $res = $conn->query($sql);
    $dane = $res->fetch_assoc();
    echo <<< OPOLE
    <div class=produkt>
      <div></div>
      <div>
        <h3>Witaj $dane[imie]! Oto twoje konto!</h3>
        <h4>Imię: $dane[imie]</h4>
        <h4>Nazwisko: $dane[nazwisko]</h4>
        <h4>Data urodzenia: $dane[data_urodzenia]</h4>
        <h4>Email: $dane[email]</h4>
        <div class=zwijaj>
          <a class=button href=./delete_uzytkownicy.php?id=$dane[id]><div>Usuń</div></a>
          <a class=button href=userinfo.php?action=edit><div>Edytuj</div></a>
        </div>
      </div>
      <div></div>
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
        $sql = "SELECT * FROM uzytkownicy WHERE email='$_SESSION[username]'";
        $res = $conn->query($sql);
        $dane = $res->fetch_assoc();
        echo <<< OPOLE
        <div>
          <table id=userinfo>
            <tr>
              <th colspan=2><h4>Witaj $dane[imie]! Oto twoje konto!</h4></th>
            </tr>
            <form action=./update_uzytkownik.php?id=$dane[id] id=edituser method=POST></form>
            <tr>
              <td><h4>Email: </h4></td>
              <td><input type=text name=email form=edituser value=$dane[email]></td>
            </tr>
            <tr>
              <td><h4>Hasło: </h4></td>
              <td><input type=password name=haslo1 form=edituser placeholder='Podaj nowe hasło'></td>
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
            
            
            
            
            
OPOLE;
        if(isset($_GET['error'])){
          echo "<tr><td colspan=2 align=center><span id=error>$_GET[error]</span></td></tr>";
        }
        echo <<< OPOLE
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
  </body>
</html>


