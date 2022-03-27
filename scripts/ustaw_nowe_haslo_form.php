<?php
echo <<< OPOLE1
<div id=email>
  <h2>Zmiana hasła</h2>
  <form action=../scripts/ustaw_nowe_haslo.php method=post>
    <input type=hidden name=id value=$_GET[id]>
    <input type=number name=kod min=100000 max=999999 placeholder='Kod przywracania' autofocus><br>
    <input type=password name=haslo1 placeholder='Podaj hasło'><br>
    <input type=password name=haslo2 placeholder='Podaj ponownie hasło'><br>
OPOLE1;
if(isset($_GET['info'])){
  echo "<span id=error>$_GET[info]</span><br>";
}
echo <<< OPOLE1
    <input type=submit value="Zmień hasło!">
  </form>
</div>
OPOLE1;
?>