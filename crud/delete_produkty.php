<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'passwd_hash');
$sql = "delete from produkty where id=$_GET[id]";
$res = $conn->query($sql);
$conn->close();
header("location: ../produkty.php");
?>