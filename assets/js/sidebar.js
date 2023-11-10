document.addEventListener("DOMContentLoaded", async function(){
    let profileButton = document.querySelector('.js-profile');
    let sidebar = document.querySelector('.js-sidebar');
    let isSidebarOpen = false;

    profileButton.addEventListener('click', function(event){
        event.stopPropagation(); 
        if(!isSidebarOpen){
            sidebar.classList.add("active");
            isSidebarOpen = true;
        } else {
            sidebar.classList.remove("active");
            isSidebarOpen = false;
        }
    });

    document.addEventListener('click', function(event){
        if(isSidebarOpen && !sidebar.contains(event.target) && event.target !== profileButton){
            sidebar.classList.remove("active");
            isSidebarOpen = false;
        }
    });
});