<?php
$login = (isset($_GET['login'])) ? "value=$_GET[login]" : "placeholder=Login";

echo <<< OPOLE1
<div id=login>
  <h2>Login</h2>
  <form action=./scripts/login.php method=post>
    <input type=text name=mail $login><br>
    <input type=password name=haslo placeholder=Hasło><br>
OPOLE1;
if(isset($_GET['info'])){
  echo "<br><span id=error>$_GET[info]</span><br>";
}
echo <<< OPOLE1
  <input type=submit value="Zaloguj się!">
</form>
OPOLE1;
echo "</div>";
?>