<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'passwd_hash');
$sql = "DELETE FROM uzytkownicy WHERE id=$_GET[id]";
$res = $conn->query($sql);
$conn->close();
header("location: ../admin/uzytkownicy.php");
exit();
?>