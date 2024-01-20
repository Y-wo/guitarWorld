document.addEventListener("DOMContentLoaded", async function() {
    let addToCartButtons = document.querySelectorAll('.js-add-to-cart-button');
    let storedGuitars = JSON.parse(localStorage.getItem('guitars') ?? '{}');

    refreshSidebarEntries(storedGuitars);

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
    }



    /*
    * checks if guitar is in shopping cart by id
    */
    function isInShoppingCart(id) {
        storedGuitars = JSON.parse(localStorage.getItem('guitars') ?? '{}');
        if(id in storedGuitars) return true;
        return false;
    }



    /*
    * remove from shopping cart in sidebar
    */
    function removeFromShoppingCart(target) {
        // gets stored stored guitars - converts string to object
        storedGuitars = JSON.parse(localStorage.getItem('guitars') ?? '{}');
        let guitarId = target.getAttribute('data-guitar-id')
        if(!isInShoppingCart(guitarId)) return;

        delete storedGuitars[guitarId];
        console.log(storedGuitars);
        localStorage.setItem("guitars", JSON.stringify(storedGuitars));

        refreshSidebarEntries(storedGuitars); 
    }



    /*
    * refresh sidebar entries
    */
    function refreshSidebarEntries(storedGuitars) {
        let sidebarShoppingElements = document.querySelector(".js-sidebar-shopping-elements-container");

        // debug
        console.log(storedGuitars);

        // Clear existing content in the sidebar
        sidebarShoppingElements.innerHTML = '';
        // let guitarIds = [];
        // let counter = 1;
        let length = Object.keys(storedGuitars).length;
        refreshShoppingCartCounter(length);

        // create elements and append them to the sidebar form
        for (let key in storedGuitars) {
            let guitarValue = storedGuitars[key];
    
            // guitarIds.push(guitarValue.id);

            let pElement = document.createElement('p');
            pElement.textContent = guitarValue.name;
            sidebarShoppingElements.appendChild(pElement);

            let imageElement = document.createElement('img');
            imageElement.src = guitarValue.imageSrc;
            sidebarShoppingElements.appendChild(imageElement);

            let removeButton = document.createElement('div');
            removeButton.setAttribute('data-guitar-id', guitarValue.id);
            removeButton.className = "button";
            removeButton.innerHTML = "Aus Warenkorb entfernen";
            sidebarShoppingElements.appendChild(removeButton);
            removeButton.addEventListener('click', function(event) {
                event.stopPropagation();
                removeFromShoppingCart(event.target); 
            })

            // hands over ids of guitars in the shopping cart
            // if (counter == length) {
            //     let inputElement = document.createElement('input');
            //     inputElement.type = 'text';
            //     inputElement.value = guitarIds;
            //     inputElement.hidden = true
            //     inputElement.name = 'ids'
            //     sidebarShoppingElements.appendChild(inputElement);  
            // }  
            // counter++;
        }
    }




    /*
    * refreshs shopping cart counter
    */
    function refreshShoppingCartCounter(number) {
        let shoppingCartCounter = document.querySelector('.js-shopping-cart-counter');
        shoppingCartCounter.style.visibility = (number == 0) ? 'hidden' : 'visible';
        shoppingCartCounter.innerHTML = number;
    }



    /*
    * refreshs shopping cart if on page 'shopping-cart'
    */
   function refreshShoppingCartPageOverview(storedGuitars) {
        let overviewContainer = document.querySelector('.js-shopping-cart-overview-container');
        
        for (let key in storedGuitars) {
            let guitarValue = storedGuitars[key];


        }
        

   }



});