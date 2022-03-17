

let sztuki = document.getElementsByClassName("sztuki");
let h5 = document.getElementsByTagName("h5");
for(var i=0; i<sztuki.length;i++){
    if(sztuki[i].innerHTML>=100){
        h5[i].style.display = "inline";
        h5[i].style.borderBottom = "2px solid lightgreen";
    }
    else if(sztuki[i].innerHTML>=10){
        h5[i].style.display = "inline";
        h5[i].style.borderBottom = "2px solid #ffef00";
    }
    else{
        h5[i].style.display = "inline";
        h5[i].style.borderBottom = "2px solid red";
    }
}