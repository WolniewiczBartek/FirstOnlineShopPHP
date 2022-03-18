<?php
$mail = isset($_GET['mail']) ? $_GET['mail'] : "";
$wyslany = isset($_GET['mail']) ? "<div>Podaj kod weryfikacji wysłany na<br>$mail</div>" : "";
echo <<< OPOLE1
<div id=verify>
  <h2>Weryfikacja</h2>
  $wyslany
  <form action=../scripts/weryfikacja_uzytkownik.php method=post>
    <input type=hidden name=mail value=$mail><br>
    <input type=text name=kod placeholder='Podaj kod weryfikacji' required><br>
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