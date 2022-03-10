<?php
foreach($_POST as $key => $x){
  if(empty($x)||strlen($x)==0){
    header("location: ./index.php?action=reg&info=Wypełnij wszystkie pola!");
    exit();
  }
}
if($_POST['haslo1']!=$_POST['haslo2']){
  header('location: ./index.php?action=reg&info=Hasła różnią się!');
  exit();
}
$hash_passwd = password_hash($_POST['haslo1'], PASSWORD_DEFAULT);

$conn = new mysqli('localhost', 'root', '', 'passwd_hash');
$sql = "insert into uzytkownicy(id, imie, nazwisko, data_urodzenia, haslo, email) values (null, '$_POST[imie]', '$_POST[nazw]', '$_POST[urod]', '$hash_passwd', '$_POST[mail]');";

$conn->query($sql);
if($conn->affected_rows==1){
  header("location: ./index.php?action=log&login=$_POST[mail]");
  exit();
}
else{
  header("location: ./index.php?action=reg&info=Ten użytkownik już istnieje!");
  exit();
}
$conn->close();



?>
