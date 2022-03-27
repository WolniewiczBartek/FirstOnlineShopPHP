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
if($_POST['haslo1']=="" && $_POST['haslo2']==""){
    $sql = "UPDATE uzytkownicy SET imie='$_POST[imie]', nazwisko='$_POST[nazwisko]', data_urodzenia='$_POST[data_urodzenia]', email='$_POST[email]' where id='$_GET[id]'";
}
else{
    if($_POST['haslo1']!=$_POST['haslo2']){
        header('location: ../sites/userinfo.php?action=edit&info=Hasła różnią się!');
        exit();
    }
    else{
        $haslo = password_hash($_POST['haslo1'], PASSWORD_DEFAULT);
        $sql = "UPDATE uzytkownicy SET imie='$_POST[imie]', nazwisko='$_POST[nazwisko]', data_urodzenia='$_POST[data_urodzenia]', haslo='$haslo', email='$_POST[email]' where id='$_GET[id]'";
    }
}



$conn = new mysqli('localhost', 'root', '', 'passwd_hash');
$conn->query($sql);
if($conn->error){
    header("location: ../sites/userinfo.php?action=edit&info=Ten użytkownik już istnieje!");
    exit();
}
else if($conn->affected_rows==1){
    $_SESSION['username']=$_POST['email'];
}


$sql = "SELECT * FROM adresy where id='$_GET[id]'";
$conn->query($sql);
if($conn->affected_rows==1){
    $sql = "UPDATE adresy SET kraj='$_POST[kraj]', miasto='$_POST[miasto]', kod_pocztowy='$_POST[kod_pocztowy]', ulica='$_POST[ulica]', numer_domu='$_POST[numer_domu]', telefon='$_POST[telefon]' where id='$_GET[id]'";
}
else{
    $sql = "INSERT into adresy values ('$_GET[id]', '$_POST[kraj]', '$_POST[miasto]', '$_POST[kod_pocztowy]', '$_POST[ulica]', '$_POST[numer_domu]', '$_POST[telefon]') ";
} 
$conn->query($sql);
$conn->close();
header("location: ../sites/userinfo.php");
exit();

?>