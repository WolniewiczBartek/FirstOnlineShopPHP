<?php
session_start();
$name = explode(".", $_FILES['zdjecie']['name']);
if(count($name)==2){
    if(file_exists("../images/".$name[0].".".$name[1])){
        $count=1;
        while(file_exists("../images/".$name[0].$count.".".$name[1])){
            $count++;
        }
        $name=$name[0].$count.".".$name[1];
    }
    else{
        $name = implode(".", $name);
    }
    if(move_uploaded_file($_FILES['zdjecie']['tmp_name'], ("../images/".$name))){
        $conn = new mysqli('localhost', 'root', '', 'passwd_hash');
        $sql = "INSERT INTO produkty (id, nazwa, zdjecie, cena, ilosc_magazyn, widoczny) VALUES (NULL, '$_POST[nazwa]', '$name', '$_POST[cena]', '$_POST[ilosc]', '$_POST[widoczny]');";
        $conn->query($sql);
        $conn->close();
        header("location: ../admin/produkty.php");
        exit();
    }
    else{
        header("location: ../admin/produkty.php?info=Błąd ładowania zdjęcia");
        exit();
    }
}
else{
    header("location: ../admin/produkty.php?info=Zły format zdjęcia");
    exit();
}



?>