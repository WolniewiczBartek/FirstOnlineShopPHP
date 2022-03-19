<?php
session_start();
foreach($_POST as $key => $x){
    if(empty($x) && $key!="haslo1" && $key!="haslo2"){
        header('location: ../sites/userinfo.php?action=edit&info=Wypełnij wszystkie dane!');
        exit();
    }
}
$email_regexp = "/^[a-z0-9]{3,20}\.{0,1}[a-z0-9]{3,20}@{1}[a-z.]{2,30}\.{1}[a-z]{1,5}$/i";
if(!preg_match($email_regexp, $_POST['email'])){
  header('location: ../sites/userinfo.php?action=edit&info=Nieprawidłowy email');
  exit();
}
$sql = "";
$haslo;
if(empty($_POST['haslo1']) && empty($_POST['haslo2'])){
    $sql = "UPDATE uzytkownicy SET imie='$_POST[imie]', nazwisko='$_POST[nazwisko]', data_urodzenia='$_POST[data_urodzenia]', email='$_POST[email]' where id='$_GET[id]'";
}

if($_POST['haslo1']!=$_POST['haslo2']){
    header('location: ../sites/userinfo.php?action=edit&info=Hasła różnią się!');
    exit();
}
else{
    $haslo = password_hash($_POST['haslo1'], PASSWORD_DEFAULT);
    $sql = "UPDATE uzytkownicy SET imie='$_POST[imie]', nazwisko='$_POST[nazwisko]', data_urodzenia='$_POST[data_urodzenia]', haslo='$haslo', email='$_POST[email]' where id='$_GET[id]'";
}

$conn = new mysqli('localhost', 'root', '', 'passwd_hash');
$conn->query($sql);
if($conn->affected_rows==1){
    $_SESSION['username']=$_POST['email'];
    header("location: ../sites/userinfo.php");
    exit();
}
else{
    header("location: ../sites/userinfo.php?action=edit&info=Ten użytkownik już istnieje!");
    exit();
}
$conn->close();

?>