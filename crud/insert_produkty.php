<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'passwd_hash');
$sql = "INSERT INTO produkty (id, nazwa, zdjecie, cena, ilosc_magazyn, widoczny) VALUES (NULL, '$_POST[nazwa]', '$_POST[zdjecie]', '$_POST[cena]', '$_POST[ilosc]', '$_POST[widoczny]');";
$conn->query($sql);
$conn->close();
header("location: ../produkty.php");
?>