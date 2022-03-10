<?php
foreach ($_POST as $key => $value){
  if(empty($value)){
    header("location: index.php?action=log&info=Wypełnij wszystkie pola!");
    exit();
  }
}

$conn = new mysqli('localhost', 'root', '', 'passwd_hash');
$sql = "select imie, nazwisko, haslo, rola from uzytkownicy where email = '$_POST[mail]'";
$res = $conn->query($sql);
$dane = $res->fetch_assoc();
if(password_verify($_POST['haslo'], $dane['haslo'])){
  if($dane['rola']=="customer"){
    header("location: index.php?action=Zalogowano pomyślnie!&username=$_POST[mail]");
    exit();
  }
  elseif($dane['rola']=="admin"){
    header("location: administrator.php?action=Zalogowano pomyślnie!&username=$_POST[mail]");
    exit();
  }
  elseif($dane['rola']=="manager"){
    header("location: manager.php?action=Zalogowano pomyślnie!&username=$_POST[mail]");
    exit();
  }
}
else {
  header("location: index.php?action=log&login=$_POST[mail]&info=Błędne hasło!");
  exit();
}
$conn->close();

 ?>
