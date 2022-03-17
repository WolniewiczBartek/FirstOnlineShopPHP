<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'passwd_hash');
$sql = "DELETE FROM produkty WHERE id=$_GET[id]";
$res = $conn->query($sql);
$conn->close();
header("location: ../admin/produkty.php");
exit();
?>