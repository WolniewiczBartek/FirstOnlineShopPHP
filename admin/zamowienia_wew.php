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
            echo "<script>document.getElementById('nazwa').innerHTML = '<a class=button href=./uzytkownicy.php><div>Użytkownicy</div></a><a class=button href=./produkty.php?rola=admin><div>Produkty</div></a><a class=button href=./administrator.php><div>Wróć</div></a><a class=button href=../index.php?action=out><div>Wyloguj się</div></a>'</script>";
        }
        elseif($rola['rola']=="manager"){
            echo "<script>document.getElementById('nazwa').innerHTML = '<a class=button href=./produkty.php?rola=manager><div>Produkty</div></a><a class=button href=./manager.php><div>Wróć</div></a><a class=button href=../index.php?action=out><div>Wyloguj się</div></a>'</script>";
        }
        else{
          unset($_SESSION['username']);
          header("location: ../index.php?action=log");
        } 
        $conn->close();
    }
    else{
      header("location: ../index.php?action=log");
    }

    echo <<< OPOLE
      <table>
        <tr>
          <th>Id</th>
          <th>Numer wewnętrzny</th>
          <th>Użytkownik</th>
          <th>Data zamówienia</th>
          <th>Produkty</th>
          <th>Ilość</th>
          <th>Cena</th>
          <th>Suma</th>
        </tr>
OPOLE;
    $conn = new mysqli('localhost', 'root', '', 'passwd_hash');
    $sql = "SELECT max(id) id FROM zamowienia;";
    $res = $conn->query($sql);
    $id = $res->fetch_assoc()['id'];
    while($id>0){
        $sql = "SELECT u.id user_id, u.email, z.id zamowienie_id, z.data_zamowienia, z.cena kwota, z.numer_wew, zp.ilosc, p.nazwa, p.cena FROM uzytkownicy u JOIN zamowienia z ON u.id=z.uzytkownik_id JOIN zamowienia_produkty zp ON z.id=zp.zamowienie_id JOIN produkty p ON zp.produkt_id=p.id WHERE z.id=$id;";
        $res = $conn->query($sql);
        $row = $conn->affected_rows;
        if($row>0){
            $zam = $res->fetch_assoc();
            echo <<< OPOLE
            <tr>
                <td rowspan='$row'>$id</td>
                <td rowspan='$row'>$zam[numer_wew]</td>
                <td rowspan='$row'>$zam[email]</td>
                <td rowspan='$row'>$zam[data_zamowienia]</td>
                <td>$zam[nazwa]</td>
                <td>$zam[ilosc] szt.</td>
                <td>$zam[cena] zł</td>
                <td rowspan='$row'>$zam[kwota] zł</td>
            </tr>
OPOLE;
            while($zam = $res->fetch_assoc()){
                echo <<< OPOLE
                <tr>
                    <td>$zam[nazwa]</td>
                    <td>$zam[ilosc] szt.</td>
                    <td>$zam[cena] zł</td>
                </tr>
OPOLE;
            }
        }
        $id--;
    }
    $conn->close();    
     ?>
     </table>
     </div>
     <footer>Bartosz Wolniewicz &copy; 2022</footer>
  </body>
</html>








