var coin = document.getElementById("coin");
var cart = document.getElementById("cart");
var left_1 = Math.floor(Math.random() * 586);
var fall_1 = document.getElementsByClassName("fall");
var modal = document.getElementById('modal');
var openModal = document.getElementById('High-Score');
coin.style.setProperty('--left-1', left_1 +'px');



document.addEventListener('keydown', function(event) {
    if(event.keyCode == 32) {
        if (cart.style.animationPlayState === 'paused'){
            cart.style.animationPlayState = 'running';
        }
        else {
            cart.style.animationPlayState = 'paused';
        }
        
    }
});

let fn = 'coin-drop-5';
let src = 'media/' + fn + '.wav';

var missed = 1;
var gold = 1;
var checkDead = setInterval(function(){
    var coinTop = parseInt(window.getComputedStyle(coin).getPropertyValue("top"));
    var coinLeft = parseInt(window.getComputedStyle(coin).getPropertyValue("left"));
    var coinRight = parseInt(window.getComputedStyle(coin).getPropertyValue("right"));
    var cartLeft = parseInt(window.getComputedStyle(cart).getPropertyValue("left"));
    var cartRight = parseInt(window.getComputedStyle(cart).getPropertyValue("right"));
    if(coinTop>450 && (cartLeft<coinLeft || cartLeft<coinLeft+15) && coinTop>450 && (cartLeft+25>coinLeft || cartLeft+25>coinLeft+15)){
        coin.classList.remove("fall");
        document.getElementById("gold").innerHTML = "Gold " + gold++ ;
        var left_1 = Math.floor(Math.random() * 586);
        let audio = document.createElement('audio');
        audio.src = src;
        audio.volume = 0.5;
        audio.play();
        coin.style.setProperty('--left-1', left_1 +'px');
    }
    if(coinTop>475){
        coin.classList.remove("fall");
        document.getElementById("missed").innerHTML = "Missed " + missed++ ;
        var left_1 = Math.floor(Math.random() * 586);
        coin.style.setProperty('--left-1', left_1 +'px');
    }
    document.getElementById("ctop").innerHTML = "var coin top " + coinTop ;
    document.getElementById("cleft").innerHTML = "var coin left " + coinLeft ;
    document.getElementById("cartleft").innerHTML = "var cart left " + cartLeft ;
    
},10);

document.getElementById("play").addEventListener("click", mplay);
function mplay(){
    cart.classList.add("start");
    coin.classList.add("fall");
    coin.style.setProperty('--vis-1', 'block');
    console.log(coin);
    console.log(cart);

}

document.getElementById("stop").addEventListener("click", stop);
function stop(){
    cart.classList.remove("start");
    coin.classList.remove("fall");
}

openModal.addEventListener('click', () => {
    document.getElementById("g-score").value = (gold-1);
    document.getElementById("m-score").value = (missed-1);
    coin.style.animationPlayState = 'paused';
    cart.style.animationPlayState = 'paused';
    modal.showModal();  
})
/* 
closeModal.addEventListener('click', () => {
    modal.close();
})

 
    coin:nth-of-type(2).style.setProperty('--vis-1', 'block');
    coin:nth-of-type(2).classList.add("fall");

var fall_1 = Math.floor(Math.random() * 5);
fall.style.setProperty('--fall-speed', fall_1 +'s');
    coin.style.setProperty('--fall-speed', fall_1 +'s');

document.getElementById("deaths").innerHTML = "missed " + missed++ ;       alert("Spacebar Pressed"); */