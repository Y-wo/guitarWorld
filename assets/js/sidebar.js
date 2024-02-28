import { isAdmin } from "./authentication-service";



document.addEventListener("DOMContentLoaded", async function(){
    let isAdminLoggedIn = isAdmin();
    let profileButton = document.querySelector('.js-profile');
    let shoppingCartButton = document.querySelector('.js-shopping-cart');
    let sidebar = document.querySelector('.js-sidebar');
    let isSidebarOpen = false;
    let cross = document.querySelector('.js-sidebar-cross');
    let loginForm = document.querySelector('.js-login-form');
    let shoppingForm = document.querySelector('.js-sidebar-shopping-form');



    // Handles Sidebar behavior
    function handleSidebarByClick(event){
        event.stopPropagation(); 

        // Checks, which part of the sidebar has to be displayed
        if (event.target.classList.contains('js-profile')) {

            if (isAdminLoggedIn !== "1") {
                loginForm.classList.add('login-form__container--active');
                shoppingCartButton.classList.remove('navbar__icon--active');
                shoppingForm.classList.remove('sidebar__shopping-form--active');
            }
                
                profileButton.classList.add('navbar__icon--active');
                
        } else {

            if (isAdminLoggedIn !== "1") {
                loginForm.classList.remove('login-form__container--active');
                shoppingCartButton.classList.add('navbar__icon--active');
                shoppingForm.classList.add('sidebar__shopping-form--active');
            }
                
                profileButton.classList.remove('navbar__icon--active');            
            
        }

        // Opens / Closes sidebar
        if(!isSidebarOpen){
            sidebar.classList.add("active");
            isSidebarOpen = true;
        } 
        else {
            sidebar.classList.remove("active");
            isSidebarOpen = false;
            profileButton.classList.remove('navbar__icon--active');
            shoppingCartButton.classList.remove('navbar__icon--active');
        }
    }

    profileButton.addEventListener('click', function(event){
        handleSidebarByClick(event);
    });

    if (isAdminLoggedIn !== "1") {
        shoppingCartButton.addEventListener('click', function(event){
            handleSidebarByClick(event);
        });
    }

    document.addEventListener('click', function(event){
        if(isSidebarOpen && (!sidebar.contains(event.target) || event.target == cross)){
            sidebar.classList.remove("active");
            isSidebarOpen = false;
        }
    });

});