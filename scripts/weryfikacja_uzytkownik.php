<?php

if(strlen($_POST['kod'])==6){
    $conn = new mysqli('localhost', 'root', '', 'passwd_hash');
    $sql = "SELECT w.kod from uzytkownicy u join weryfikacje w on u.id=w.id where email='$_POST[mail]'";
    $dane = $conn->query($sql)->fetch_assoc();
    if(strval($_POST['kod'])==strval($dane['kod'])){
        $sql = "UPDATE uzytkownicy set stan_id=2 where email='$_POST[mail]'";
        $conn->query($sql);
        header("location: ../index.php?action=log&login=$_POST[mail]&info=Zweryfikowano pomyślnie!");
        exit();
    }
    else{
        header("location: ../sites/weryfikacja.php?mail=$_POST[mail]&info=Nieprawidłowy kod!");
        exit();
    }
}
else{
    header("location: ../sites/weryfikacja.php?mail=$_POST[mail]&info=Nieprawidłowy kod!");
    exit();
}
$conn->close();
?>