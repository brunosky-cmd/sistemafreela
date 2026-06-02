function toggleMenu(){

let menu = document.getElementById("perfilMenu");

if(menu.style.display === "block"){
menu.style.display = "none";
}else{
menu.style.display = "block";
}

}

window.onclick = function(event){

if(!event.target.matches('.dropbtn')){

let menu = document.getElementById("perfilMenu");

if(menu && menu.style.display === "block"){
menu.style.display = "none";
}

}

}

function limparBusca(){

let campo = document.getElementById("busca");

campo.value = "";
campo.focus();

}