<?php
echo <<< OPOLE1
<div id=email>
  <h2>Mail do zmiany hasła</h2>
  <form action=./config/mail_config_forgot.php method=post>
    <input type=text name=mail placeholder=Email autofocus><br>
OPOLE1;
if(isset($_GET['info'])){
  echo "<span id=error>$_GET[info]</span><br>";
}
echo <<< OPOLE1
    <input type=submit value="Wyślij maila!">
  </form>
</div>
OPOLE1;
?>