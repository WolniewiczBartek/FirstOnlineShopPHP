<?php
if(isset($_SESSION['username'])&&!isset($_GET['action'])){
    $conn = new mysqli('localhost', 'root', '', 'passwd_hash');
    $sql = "SELECT rola FROM uzytkownicy u JOIN role r ON u.rola_id=r.id WHERE email='$_SESSION[username]'";
    $res = $conn->query($sql)->fetch_assoc();
    if($res['rola']=="admin"){
      header('location: ./admin/administrator.php');
      exit();
    }
    elseif($res['rola']=="manager"){
      header('location: ./admin/manager.php');
      exit();
    }
    elseif($res['rola']=="customer"){
    }
    else{
      header('location: ./index.php?action=out');
      exit();
    }
    $conn->close();
  }
?>