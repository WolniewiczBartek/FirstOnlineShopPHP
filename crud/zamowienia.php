<?php
session_start();
function pokaz_zamowienia(){
    $c=1;
    $conn = new mysqli('localhost', 'root', '', 'passwd_hash');
    $sql = "select * from uzytkownicy u join zamowienia z on u.id=z.uzytkownik_id where email='$_SESSION[username]'";
    $res = $conn->query($sql);
    if($conn->affected_rows==0){
        echo "<div>Brak zamówień!</div>";
    }
    else{   
        echo <<< OPOLE
        <h3>Oto twoje zamówienia!</h3>
        <table>
        <tr>
            <th>Lp.</th>
            <th>Data zamówienia</th>
            <th>Kwota zamówienia</th>
        </tr>
OPOLE;
        while($dane = $res->fetch_assoc()){
            echo <<< OPOLE
            <tr>
                <td>$c</td>
                <td>$dane[data_zamowienia]</td>
                <td>$dane[cena] zł</td>
            </tr>
OPOLE;
            $c++;
        }
        echo "</table>";
        $conn->close();
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
          echo "<script>document.getElementById('nazwa').innerHTML = '<a class=button href=./userinfo.php><div>$_SESSION[username]</div></a><a class=button href=../index.php><div>Wróć</div></a><a class=button href=\"../index.php?action=out\"><div>Wyloguj się</div></a>'</script>";
        }
      }
      else{
        header('location: ../index.php?action=log');
      }    
      pokaz_zamowienia();
?>  
    </div>
    <footer>Bartosz Wolniewicz &copy; 2022</footer>
  </body>
</html>


