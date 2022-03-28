<?php
if($_POST['haslo1']!=$_POST['haslo2']){
    header("location: ../sites/zmiana_hasla.php?id=$_POST[id]&info=Hasła różnią się!");
    exit();
}
else{
    $conn = new mysqli('localhost', 'root', '', 'passwd_hash');
    $sql = "SELECT w.id, w.kod, u.email FROM uzytkownicy u join weryfikacje w on u.id=w.id where w.id='$_POST[id]';";
    $res = $conn->query($sql);
    if($conn->affected_rows==1){
        $dane = $res->fetch_assoc();
        if(strval($dane['kod'])==strval($_POST['kod'])){
            $haslo = password_hash($_POST['haslo1'], PASSWORD_DEFAULT);
            $sql = "UPDATE uzytkownicy SET haslo='$haslo' where id='$_POST[id]'";
            $conn->query($sql);
            $conn->close();
            header("location: ../index.php?action=log&login=$dane[email]");
            exit();
        }
        else{
            header("location: ../sites/zmiana_hasla.php?id=$_POST[id]&info=Zły kod!");
            exit();
        } 
    }
    else{
        header("location: ../index.php");
        exit();
    } 
}

?>