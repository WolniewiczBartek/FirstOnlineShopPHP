<?php
session_start();
$sql;
if(strlen($_POST['haslo'])==0){
    $sql = "UPDATE uzytkownicy SET imie='$_POST[imie]', nazwisko='$_POST[nazwisko]', data_urodzenia='$_POST[data_urodzenia]', email='$_POST[email]', rola_id='$_POST[rola_id]', stan_id='$_POST[stan_id]' where id='$_POST[id]'";
}
else{
    $haslo = $_POST['haslo'][0] == "$" ? $_POST['haslo'] : password_hash($_POST['haslo'], PASSWORD_DEFAULT);
    $sql = "UPDATE uzytkownicy SET imie='$_POST[imie]', nazwisko='$_POST[nazwisko]', data_urodzenia='$_POST[data_urodzenia]', haslo='$haslo', email='$_POST[email]', rola_id='$_POST[rola_id]', stan_id='$_POST[stan_id]' where id='$_POST[id]'";

}
$conn = new mysqli('localhost', 'root', '', 'passwd_hash');
$conn->query($sql);
$conn->close();
header("location: ../admin/uzytkownicy.php");
exit();
?>