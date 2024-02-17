// To use this: 
// - add 'data-confirmation-text'-attribute with confirmation-question to the a-tag
// - add class 'js-confirm-link' to a-tag

let confirmation = document.querySelector('.js-confirmation');
let confirmButtonClose = document.querySelector('.js-confirmation-button-close');
let confirmButtonYes = document.querySelector('.js-confirmation-button-yes');
let confirmButtonNo = document.querySelector('.js-confirmation-button-no');
let confirmText = document.querySelector('.js-confirmation-text');


document.addEventListener('DOMContentLoaded', function() {
    let confirmLinks = document.querySelectorAll('.js-confirm-link');

    // gives each confirmation-link an eventListener and its confirmation-modal the necessary text
    confirmLinks.forEach(function(link){
        let confirmationText = link.getAttribute('data-confirmation-text')
        link.addEventListener('click', function(event){
            event.preventDefault();
            localStorage.setItem('linkToConfirm', link.href);
            confirmation.style.display = 'block';
            confirmText.innerHTML = confirmationText
        })
    })
    
    confirmButtonClose.addEventListener('click', function() {
        confirmation.style.display = 'none';
    });

    confirmButtonYes.addEventListener('click', function() {
        // forwards page after confirmation
        window.location.href = localStorage.getItem('linkToConfirm'); 
        confirmation.style.display = 'none';
    });

    confirmButtonNo.addEventListener('click', function() {
        confirmation.style.display = 'none';
    });
})
