<?php
session_start();
foreach($_POST as $key => $x){
    if(empty($x)){
        header('location: ./userinfo.php?action=edit&error=Wypełnij wszystkie dane!');
        exit();
    }
}
if($_POST['haslo1']!=$_POST['haslo2']){
    header('location: ./userinfo.php?action=edit&error=Hasła różnią się!');
}
else{
    $haslo = password_hash($_POST['haslo1'], PASSWORD_DEFAULT);
    $conn = new mysqli('localhost', 'root', '', 'passwd_hash');
    $sql = "UPDATE uzytkownicy SET imie='$_POST[imie]', nazwisko='$_POST[nazwisko]', data_urodzenia='$_POST[data_urodzenia]', haslo='$haslo', email='$_POST[email]' where id='$_GET[id]'";
    $conn->query($sql);
    if($conn->affected_rows==1){
        $_SESSION['username']=$_POST['email'];
        header("location: ./userinfo.php");
    }
    else{
        header("location: ./userinfo.php?action=edit&error=Ten użytkownik już istnieje!");
    }
    $conn->close();
}


?>