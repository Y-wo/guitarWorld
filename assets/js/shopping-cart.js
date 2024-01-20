const serverUrl = "http://localhost/guitarWorld"; 
const shoppingCartPageUrl = "/public/shopping-cart";
const guitarDetailPageUrl = '/public/guitar?guitarId='

document.addEventListener("DOMContentLoaded", async function() {
    let addToCartButtons = document.querySelectorAll('.js-add-to-cart-button');
    let storedGuitars = JSON.parse(localStorage.getItem('guitars') ?? '{}');

    console.log(window.location.href);

    refreshSidebarEntries(storedGuitars);

    
    refreshShoppingCartPageOverview(storedGuitars);
    


    addToCartButtons.forEach((addToCartButton) => {
        addToCartButton.addEventListener('click', (event) => {
            addToShoppingCart(event.target);
        })
    })
});

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
        refreshShoppingCartPageOverview(storedGuitars);
    }



    /*
    * refresh sidebar entries
    */
    function refreshSidebarEntries(storedGuitars) {
        let sidebarShoppingElements = document.querySelector(".js-sidebar-shopping-elements-container");
        appendShoppingItemsToTarget(sidebarShoppingElements, storedGuitars);
    }



    /*
    * appends shopping items to view
    */ 
    function appendShoppingItemsToTarget(appendingTarget, storedGuitars) {
        // Clears existing content in the sidebar
        appendingTarget.innerHTML = '';

        let length = Object.keys(storedGuitars).length;
        refreshShoppingCartCounter(length);


        // create elements and append them to the target
        for (let key in storedGuitars) {
            let guitarValue = storedGuitars[key];

            let shoppingItemContainer = document.createElement('div');
            shoppingItemContainer.className = "shopping-cart__item-container";
            shoppingItemContainer.style.paddingBottom = "1rem"

            let aTagToGuitar = document.createElement('a');
            aTagToGuitar.href = serverUrl + guitarDetailPageUrl + guitarValue.id;

            let imageElement = document.createElement('img');
            imageElement.src = guitarValue.imageSrc;
            imageElement.className = 'image__frame'

            aTagToGuitar.appendChild(imageElement);
            shoppingItemContainer.appendChild(aTagToGuitar);

            let pElement = document.createElement('p');
            pElement.textContent = guitarValue.name;
            shoppingItemContainer.appendChild(pElement);

            let removeButton = document.createElement('div');
            removeButton.setAttribute('data-guitar-id', guitarValue.id);
            removeButton.className = "button";
            removeButton.innerHTML = "Aus Warenkorb entfernen";
            shoppingItemContainer.appendChild(removeButton);

            removeButton.addEventListener('click', function(event) {
                event.stopPropagation();
                removeFromShoppingCart(event.target); 
            })

            appendingTarget.appendChild(shoppingItemContainer);
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
        if(window.location.href == serverUrl + shoppingCartPageUrl){
            let overviewContainer = document.querySelector('.js-shopping-cart-overview-container');
            appendShoppingItemsToTarget(overviewContainer, storedGuitars);
        }
   }



