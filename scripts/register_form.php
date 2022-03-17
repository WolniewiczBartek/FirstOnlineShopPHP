<?php
echo <<< OPOLE
<div id="register">
  <h2>Rejestracja</h2>
  <form action="./scripts/register.php" method="post">
    <input type=text name=mail placeholder=Email><br>
    <input type=password name=haslo1 placeholder=Hasło><br>
    <input type=password name=haslo2 placeholder="Powtórz hasło"><br>
    <input type=text name=imie placeholder=Imię><br>
    <input type=text name=nazw placeholder=Nazwisko><br>
    <input type=date name=urod><br>
OPOLE;
if(isset($_GET['info'])){
  echo "<br><span id=error>$_GET[info]</span><br>";
}
echo <<< OPOLE
    <input type="submit" value="Zarejestruj się!">
  </form>
OPOLE;
echo "</div>";
?>