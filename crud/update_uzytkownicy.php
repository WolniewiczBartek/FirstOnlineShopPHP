<?php
session_start();

$haslo = $_POST['haslo'][0] == "$" ? $_POST['haslo'] : password_hash($_POST['haslo'], PASSWORD_DEFAULT);
$conn = new mysqli('localhost', 'root', '', 'passwd_hash');
$sql = "UPDATE uzytkownicy SET imie='$_POST[imie]', nazwisko='$_POST[nazwisko]', data_urodzenia='$_POST[data_urodzenia]', haslo='$haslo', email='$_POST[email]', rola='$_POST[rola]' where id='$_POST[id]'";
$conn->query($sql);
$conn->close();
header("location: ../uzytkownicy.php");
?>