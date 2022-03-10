<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'passwd_hash');
$sql = "update produkty set nazwa='$_POST[nazwa]', zdjecie='$_POST[zdjecie]', cena='$_POST[cena]', ilosc_magazyn='$_POST[ilosc]', widoczny='$_POST[widoczny]' where id='$_POST[id]'";
$conn->query($sql);
$conn->close();
header("location: ../produkty.php");
?>