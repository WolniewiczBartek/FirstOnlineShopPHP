

// var hasloinfo = document.getElementById("hasloinfo");
// document.getElementById("register").onload = () => {
//     console.log("dupa");
// }

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
function sprawdzHaslo(p){
    let hasloinfo = document.getElementById("hasloinfo");
    let mocnehaslo = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})");
    let sredniehaslo = new RegExp("^(((?=.*[a-z])(?=.*[A-Z]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[A-Z])(?=.*[0-9])))(?=.{6,})");
    if(mocnehaslo.test(p.value)){
        hasloinfo.style.display = "inline";
        hasloinfo.style.borderBottom = "2px solid green";
        hasloinfo.innerHTML = "Mocne hasło<br>";
    }
    else if(sredniehaslo.test(p.value)){
        hasloinfo.style.display = "inline";
        hasloinfo.style.borderBottom = "2px solid #ffef00";
        hasloinfo.innerHTML = "Średnie hasło<br>";
    }
    else{
        hasloinfo.style.display = "inline";
        hasloinfo.style.borderBottom = "2px solid red";
        hasloinfo.innerHTML = "Słabe hasło<br>";
    }
    hasloinfo.style.marginBottom = "5px";
}

if(document.getElementById("register")||document.getElementById("userinfo")){
    let haslo = document.getElementsByClassName("haslo");
    let hasloinfo = document.getElementById("hasloinfo");
    haslo[0].oninput = () => {
        clearTimeout();
        timeout = setTimeout(() => sprawdzHaslo(haslo[0]), 500);
        if(haslo[0].value.length == 0) {
            hasloinfo.style.display = 'none';
        }     
        
    } 
}