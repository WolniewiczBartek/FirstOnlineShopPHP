<?php
session_start();
$haslo = $_POST['haslo'][0] == "$" ? $_POST['haslo'] : password_hash($_POST['haslo'], PASSWORD_DEFAULT);
$conn = new mysqli('localhost', 'root', '', 'passwd_hash');
$sql = "INSERT INTO uzytkownicy (id, imie, nazwisko, data_urodzenia, haslo, email, rola_id, stan_id) VALUES (NULL, '$_POST[imie]', '$_POST[nazwisko]', '$_POST[data_urodzenia]', '$haslo', '$_POST[email]', '$_POST[rola_id]', '$_POST[stan_id]');";
$conn->query($sql);
$conn->close();
header("location: ../admin/uzytkownicy.php");
exit();
?>