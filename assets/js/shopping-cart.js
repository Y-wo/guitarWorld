document.addEventListener("DOMContentLoaded", async function() {
    let addToCartButtons = document.querySelectorAll('.js-add-to-cart-button');

    let storedGuitars = JSON.parse(localStorage.getItem('guitars') ?? '{}');

    addToCartButtons.forEach((addToCartButton) => {
        addToCartButton.addEventListener('click', (event) => {
            addToShoppingCart(event.target);
        })
    })


    /*
    * adds target to shopping cart if not already in there
    */
    function addToShoppingCart(guitarTarget) {

        // gets stored stored guitars - converts string to object
        storedGuitars = JSON.parse(localStorage.getItem('guitars') ?? '{}');

        let guitarId = guitarTarget.getAttribute('data-guitar-id')

        if(isInShoppingCart(guitarId)) return;

        let guitarName = guitarTarget.getAttribute('data-name')
        let guitarImageSrc = guitarTarget.getAttribute('data-image-src')

        storedGuitars[guitarId] = {
            'id': guitarId,
            'name': guitarName,
            'imageSrc': guitarImageSrc
        }

        // sets changed guitars as new stored guitars - converts object to string
        localStorage.setItem("guitars", JSON.stringify(storedGuitars));

        refreshSidebarEntries(storedGuitars);

        // debug
        // console.log(storedGuitars);
    }

    /*
    * checks if guitar is in shopping cart by id
    */
    function isInShoppingCart(id) {
        storedGuitars = JSON.parse(localStorage.getItem('guitars') ?? '{}');
        if(id in storedGuitars) return true;
        return false;
    }


    // ÜBERDENKEN !
    /*
    * clears shopping cart
    */
   function clearShoppingCart() {
        localStorage.clear()
   }


    // refresh sidebar entrys
    // function refreshSidebarEntries(storedGuitars) {
    //     let sidebarCartForm = document.querySelector('.js-sidebar-shopping-cart');
    //     storedGuitars.forEach((guitar) => {
            
    //     })
    // }

    // refresh sidebar entries
    function refreshSidebarEntries(storedGuitars) {
        let sidebarCartForm = document.querySelector('.js-sidebar-shopping-form');

        console.log(storedGuitars);

        // Clear existing content in the sidebar
        sidebarCartForm.innerHTML = '';

        for(const guitar in storedGuitars) {


            // WEITER Gibt irgendein Probelm hier mit guitar 

            // console.log(guitar)

            // Create input element
            let inputElement = document.createElement('input');
            inputElement.type = 'text';
            inputElement.value = guitar.id;
            // // Append input to the sidebar form
            sidebarCartForm.appendChild(inputElement);
        
            // // Create image element
            // let imageElement = document.createElement('img');
            // imageElement.src = guitar.src;
            // // Append image to the sidebar form
            // sidebarCartForm.appendChild(imageElement);
        
            // // Create p element
            // let pElement = document.createElement('p');
            // pElement.textContent = guitar.name;
            // // Append p to the sidebar form
            // sidebarCartForm.appendChild(pElement);
        }

    }

});