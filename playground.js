var character = document.getElementById("character");
var block = document.getElementById("block");

document.addEventListener('keydown', function(event) {
    if(event.keyCode == 32) {
        if(character.classList != "animate"){
        character.classList.add("animate"); 
        }
            setTimeout(function(){
        character.classList.remove("animate");
        },500);     
    }
});

var deathCount = 1;
var loops = 1;
var checkDead = setInterval(function(){
    var characterTop = parseInt(window.getComputedStyle(character).getPropertyValue("top"));
    var blockLeft = parseInt(window.getComputedStyle(block).getPropertyValue("left"));
    if(blockLeft<20 && blockLeft>0 && characterTop>=130){
        block.classList.remove("start");
        document.getElementById("deaths").innerHTML = "Deaths " + deathCount++ ;
        alert("You Died ");
    }
},10);

document.getElementById("play").addEventListener("click", mplay);
function mplay(){
    block.classList.add("start");
    document.getElementById("loops").innerHTML = "Loop " + loops++ ;
}
