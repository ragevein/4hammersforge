// the form
const modal = document.querySelector('#modal');
var openModal = document.querySelector('#open-button');
var closeModal = document.querySelector('#close-button');

// from url vars
/*
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const thing = urlParams.get('edit');

if (thing == 'true'){
    modal.showModal();  
}
*/

openModal.addEventListener('click', () => {
    modal.showModal();    
})

closeModal.addEventListener('click', () => {
    modal.close();
})