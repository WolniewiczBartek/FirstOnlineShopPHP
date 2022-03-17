<?php
foreach ($_POST as $key => $value){
  if(empty($value)){
    header("location: ../index.php?action=log&info=Wypełnij wszystkie pola!");
    exit();
  }
} 
$conn = new mysqli('localhost', 'root', '', 'passwd_hash');
$sql = "SELECT haslo, rola, stan_id FROM uzytkownicy u JOIN role r ON u.rola_id=r.id WHERE email = '$_POST[mail]'";
$dane = $conn->query($sql)->fetch_assoc();

if($dane['stan_id']==1){
  header("location: ../index.php?action=log&info=Potwierdź założenie konta!");
  exit();
}
elseif($dane['stan_id']==3){
  header("location: ../index.php?action=log&info=Twoje konto jest zablokowane!");
  exit();
}
elseif($dane['stan_id']==4){
  header("location: ../index.php?action=log&info=Twoje konto jest usunięte!");
  exit();
}
else{
  if(password_verify($_POST['haslo'], $dane['haslo'])){
    if($dane['rola']=="customer"){
      header("location: ../index.php?action=Zalogowano pomyślnie!&username=$_POST[mail]");
      exit();
    }
    elseif($dane['rola']=="admin"){
      header("location: ../admin/administrator.php?action=Zalogowano pomyślnie!&username=$_POST[mail]");
      exit();
    }
    elseif($dane['rola']=="manager"){
      header("location: ../admin/manager.php?action=Zalogowano pomyślnie!&username=$_POST[mail]");
      exit();
    }
  }
  else {
    header("location: ../index.php?action=log&login=$_POST[mail]&info=Błędne hasło!");
    exit();
  }
}
$conn->close();
 ?>
