<?php
session_start();

if(!isset($_SESSION['koszyk'])){
  $_SESSION['koszyk'] = array();
}

require_once('./scripts/welcome_role_check.php');

?>
<!DOCTYPE html>
<html lang="pl" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Gąbkomarzenie</title>
    <link rel="icon" type="image/x-icon" href="./images/favicon.ico">
    <link rel="stylesheet" href="./styl.css">
  </head>
  <body>
    <header>
      <a href="index.php"><img src="./images/logo.png" id="logo" alt="logo"></a>
      <h1>Gąbkomarzenie</h1>
      <div id="nazwa">
        <a class="button" href="./sites/koszyk.php"><div>Koszyk</div></a>
        <a class="button" href="index.php?action=reg"><div>Rejestracja</div></a>
        <a class="button" href="index.php?action=log"><div>Zaloguj się</div></a>
      </div>
    </header>
    <?php
    if(isset($_GET['action'])){
      if($_GET['action']=="reg"){
        require_once('./scripts/register_form.php');
      }
      elseif($_GET['action']=="log"){
        require_once('./scripts/login_form.php');
      }
      elseif($_GET['action']=="Zalogowano pomyślnie!"){
        $_SESSION['username'] = $_GET['username'];
        require_once('./scripts/show_produkty.php');
      }
      elseif($_GET['action']=="out"){
        unset($_SESSION['username']);
        unset($_SESSION['koszyk']);
        echo "<script>document.getElementById('nazwa').innerHTML = '<a class=button href=./sites/koszyk.php><div>Koszyk</div></a><a class=button href=./index.php?action=reg><div>Rejestracja</div></a><a class=button href=./index.php?action=log><div>Zaloguj się</div></a>'</script>";
        require_once('./scripts/show_produkty.php');
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
      require_once('./scripts/show_produkty.php');
    }
    if(isset($_SESSION['username'])){
      if($_SESSION['username']!=""){
        echo "<script>document.getElementById('nazwa').innerHTML = '<a class=button href=./sites/userinfo.php?login=$_SESSION[username]\"><div>$_SESSION[username]</div></a><a class=button href=./sites/koszyk.php><div>Koszyk</div></a><a class=button href=./index.php?action=out><div>Wyloguj się</div></a>'</script>";
      }
    }
     ?>
     </div>
     <footer>Bartosz Wolniewicz &copy; 2022</footer>
     <script type="text/javascript" src="./skrypt.js"></script>
  </body>
</html>
