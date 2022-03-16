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
            echo "<script>document.getElementById('nazwa').innerHTML = '<a class=button href=./zamowienia_wew.php?rola=admin><div>Zamówienia</div></a><a class=button href=./uzytkownicy.php><div>Użytkownicy</div></a><a class=button href=./administrator.php><div>Wróć</div></a><a class=button href=../index.php?action=out><div>Wyloguj się</div></a>'</script>";
        }
        elseif($rola['rola']=="manager"){
            echo "<script>document.getElementById('nazwa').innerHTML = '<a class=button href=./zamowienia_wew.php?rola=manager><div>Zamówienia</div></a><a class=button href=./manager.php><div>Wróć</div></a><a class=button href=../index.php?action=out><div>Wyloguj się</div></a>'</script>";
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
    if(isset($_GET['info'])){
      echo "<br><span id=error>$_GET[info]</span><br>";
    }
    echo <<< OPOLE
      <table>
        <tr>
          <th>Id</th>
          <th>Nazwa</th>
          <th>Zdjęcie</th>
          <th>Cena</th>
          <th>Ilość Na Magazynie</th>
          <th>Widoczny</th>
          <th></th>
          <th></th>
        </tr>
        <tr>
          <form id=add action=../scripts/insert_produkty.php method=POST enctype=multipart/form-data></form>
            <td>Nowy</td>
            <td><input name=nazwa type=text form=add placeholder=Nazwa></td>
            <td><input name=zdjecie type=file form=add placeholder=Zdjęcie></td>
            <td><input name=cena type=number form=add placeholder=Cena step=0.01 min=0></td>
            <td><input name=ilosc type=number form=add placeholder="Ilość Magazyn" min=0></td>
            <td><select name=widoczny form=add>
              <option value=0>niewidoczny</option>
              <option value=1>widoczny</option>
            </select></td>
            <td><input type="reset" form=add value="Reset"></td>
            <td><input type="submit" form=add value="Dodaj"></td>
        </tr>
OPOLE;
    $conn = new mysqli('localhost', 'root', '', 'passwd_hash');
    $sql = "SELECT id, nazwa, zdjecie, cena, ilosc_magazyn, widoczny FROM produkty";
    $res = $conn->query($sql);
    while($produkt = $res->fetch_assoc()){
      echo <<< OPOLE
      <tr id=prod$produkt[id]>
        <td>$produkt[id]</td>
        <td>$produkt[nazwa]</td>
        <td><img class=smallimg src=../images/$produkt[zdjecie] alt=$produkt[nazwa]></td>
        <td>$produkt[cena]</td>
        <td>$produkt[ilosc_magazyn]</td>
        <td>$produkt[widoczny]</td>
        <td><a class=button href=./produkty.php?action=edit&id=$produkt[id]>Edytuj</a></td>
        <td><a class=button href=../scripts/delete_produkty.php?id=$produkt[id]>Usuń</a></td>
      </tr>
OPOLE;
    }
    $conn->close();

    if(isset($_GET['action'])){
      if($_GET['action']=='edit'){
        $conn = new mysqli('localhost', 'root', '', 'passwd_hash');
        $sql = "SELECT * FROM produkty WHERE id=$_GET[id]";
        $res = $conn->query($sql);
        $produkt = $res->fetch_assoc();
        $widoczny = $produkt['widoczny']==1 ? 0 : 1;
        $id = "prod".$_GET['id'];
        echo "<script>document.getElementById('$id').innerHTML=\"<form action='../scripts/update_produkty.php' method=POST id=edit enctype=multipart/form-data></form><td><input name=id type=hidden form=edit value='$produkt[id]'></td><td><input name=nazwa type=text form=edit value='$produkt[nazwa]'></td><td><input name=zdjecie type=file form=edit></td><td><input name=cena type=number form=edit value='$produkt[cena]' step=0.01 min=0></td><td><input name=ilosc type=number form=edit value='$produkt[ilosc_magazyn]' min=0></td><td><select name=widoczny form=edit><option value=$produkt[widoczny]>$produkt[widoczny]</option><option value=$widoczny>$widoczny</option></select></td><td><input type=reset form=edit value='Reset'></td><td><input type=submit name=zapisz form=edit value='Zapisz'></td>\";</script>";
        $conn->close();        
      }
    }    
     ?>
     </table>
     </div>
     <footer>Bartosz Wolniewicz &copy; 2022</footer>
  </body>
</html>










