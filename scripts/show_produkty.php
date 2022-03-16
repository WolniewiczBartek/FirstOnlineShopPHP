<?php
echo "<div id=content>";
    $conn = new mysqli('localhost', 'root', '', 'passwd_hash');
    $sql = "SELECT count(*) ile FROM produkty WHERE widoczny=1";
    $productcount = $conn->query($sql)->fetch_assoc()['ile'];
    $prod_per_page = 2;
    $pagecount=ceil($productcount/$prod_per_page);
    $p= (isset($_GET['p'])) ? $_GET['p'] : 1;
    $pom=($p-1)*$prod_per_page;
    $sql = "SELECT id, nazwa, zdjecie, cena, ilosc_magazyn FROM produkty WHERE widoczny=1 ORDER BY 1 LIMIT $prod_per_page OFFSET $pom";
    $res = $conn->query($sql);
    while($produkt = $res->fetch_assoc()){
    echo <<< OPOLE
    <div class=produkt>
        <div class=zwijaj>
        <a href=./sites/produkt.php?id=$produkt[id]><img class=midimg src=./images/$produkt[zdjecie] alt=$produkt[nazwa]></a>
        <div>
        <a href=./sites/produkt.php?id=$produkt[id]><h3>$produkt[nazwa]</h3></a>
            <h4>$produkt[cena] zł</h4>
            <h5>Dostępność: <span class=sztuki>$produkt[ilosc_magazyn]</span> szt.</h5>
        </div>
        </div>
        <div>
        <a class=button href=./index.php?action=koszyk&id=$produkt[id]&p=$p><div>Do koszyka</div></a>
        <a class=button href=./sites/produkt.php?id=$produkt[id]&p=$p><div>Zobacz</div></a>
        </div>
    </div>
OPOLE;
    }
if($p==1&&$pagecount>1){
    echo "<div id=lower_butt><div class=szer></div><div>$p</div><a href=./index.php?p=2 class=button><div>Następna</div></a></div>";
}
elseif($p==1&&$pagecount==1){
    
}
elseif($p<$pagecount){
    $pp=$p-1;
    $nn=$p+1;
    echo "<div id=lower_butt><a href=./index.php?p=$pp class=button><div>Poprzednia</div></a><div>$p</div><a href=./index.php?p=$nn class=button><div>Następna</div></a></div>";

}else{
    $pp=$p-1;
    echo "<div id=lower_butt><a href=./index.php?p=$pp class=button><div>Poprzednia</div></a><div>$p</div><div class=szer></div></div>";
}
?>