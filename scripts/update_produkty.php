<?php
session_start();
$name;
if($_FILES['zdjecie']['name']==""){
    $conn = new mysqli('localhost', 'root', '', 'passwd_hash');
    $sql = "UPDATE produkty SET nazwa='$_POST[nazwa]', cena='$_POST[cena]', ilosc_magazyn='$_POST[ilosc]', widoczny='$_POST[widoczny]' WHERE id='$_POST[id]'";
    $conn->query($sql);
    $conn->close();
    header("location: ../admin/produkty.php");
    exit();
}
else{
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
            $sql = "UPDATE produkty SET nazwa='$_POST[nazwa]', zdjecie='$name', cena='$_POST[cena]', ilosc_magazyn='$_POST[ilosc]', widoczny='$_POST[widoczny]' WHERE id='$_POST[id]'";
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
}


?>