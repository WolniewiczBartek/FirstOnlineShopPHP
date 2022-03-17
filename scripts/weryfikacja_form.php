<?php
$mail = $_GET['mail'];
echo <<< OPOLE1
<div id=verify>
  <h2>Weryfikacja</h2>
  <form action=../scripts/weryfikacja_uzytkownik.php method=post>
    <input type=hidden name=mail value=$mail><br>
    <input type=text name=kod placeholder='Podaj kod weryfikacji'><br>
OPOLE1;
if(isset($_GET['info'])){
  echo "<br><span id=error>$_GET[info]</span><br>";
}
echo <<< OPOLE1
    <input type=submit value="Zweryfikuj!">
</form>
OPOLE1;
echo "</div>";

?>