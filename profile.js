document.querySelectorAll('.down1').forEach(button =>{
    button.addEventListener('click', () => {
        button.classList.toggle('down1--active');
    })
    
})


// the main update form
const modal = document.querySelector('#modal')
var openModal = document.querySelector('#update-button');
var closeModal = document.querySelector('#close-button');


// from url vars
/*
const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);
const thing = urlParams.get('sub_action');

if (thing == 'pass'){
    modal.showModal();  
}
*/

openModal.addEventListener('click', () => {
    modal.showModal();    
})

closeModal.addEventListener('click', () => {
    modal.close();
})

const modal_2 = document.querySelector('#modal-2')
var openModal_2 = document.querySelector('#update-button-2');
var closeModal_2 = document.querySelector('#close-button-2');

openModal_2.addEventListener('click', () => {
    modal_2.showModal();
    const old_pass = document.getElementById('old_pass')
    const pass1 = document.getElementById('pass1')
    const pass2 = document.getElementById('pass2')
    const form = document.getElementById('form')
    const errorElement = document.getElementById('error')

    form.addEventListener('submit', (e) => {
        let message = []
        if (old_pass.value === '' || old_pass.value == null) {
        message.push('Old password is required')
        }

        if (pass2.value.length <= 6) {
        message.push('Password must be longer then 6 characters')
        }

        if (pass1.value  !== pass2.value) {
        message.push("Your new passwords don't match")
        }

        if (message.length > 0){
        e.preventDefault()
        errorElement.innerText = message.join(', ')
        }
    })
    
})


/*
    
closeModal_2.addEventListener('click', () => {
    modal_2.close();
})

*/




