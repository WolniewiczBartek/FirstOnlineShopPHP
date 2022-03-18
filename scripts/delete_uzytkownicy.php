<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'passwd_hash');
$sql = "UPDATE uzytkownicy set stan_id=4 WHERE id=$_GET[id]";
$res = $conn->query($sql);
$conn->close();
header("location: ../admin/uzytkownicy.php");
exit();
?>