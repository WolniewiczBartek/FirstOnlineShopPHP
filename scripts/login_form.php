<?php
$login = (isset($_GET['login'])) ? "value=$_GET[login]" : "placeholder=Login";

echo <<< OPOLE1
<div id=login>
  <h2>Login</h2>
  <form action=./scripts/login.php method=post>
    <input type=text name=mail $login autofocus><br>
    <input type=password name=haslo placeholder=Hasło><br>
    
OPOLE1;
if(isset($_GET['info'])){
  echo "<br><span id=error>$_GET[info]</span><br>";
}
echo <<< OPOLE1
    <a id=forgot href=./index.php?action=forgot>Zapomniałeś hasła?</a><br>
    <input type=submit value="Zaloguj się!">
  </form>
</div>
OPOLE1;
?>