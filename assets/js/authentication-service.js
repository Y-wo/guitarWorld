export function isAdmin(){
    let isAdminDiv = document.querySelector('.js-is-admin');
    let isAdmin = isAdminDiv.getAttribute('data-is-admin');
    return isAdmin;
}

