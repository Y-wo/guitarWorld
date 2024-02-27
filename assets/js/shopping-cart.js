const serverUrl = "http://localhost/guitarWorld/public/"; 
const shoppingCartPageUrl = "shopping-cart";
const guitarDetailPageUrl = 'guitar?guitarId='

document.addEventListener("DOMContentLoaded", async function() {
    let isAdminLoggedIn = isAdmin();
    let addToCartButtons = document.querySelectorAll('.js-add-to-cart-button');
    let storedGuitars = JSON.parse(localStorage.getItem('guitars') ?? '{}');
    
    refreshSidebarEntries(storedGuitars);
    refreshShoppingCartPageOverview(storedGuitars);
    refreshAddToCartButtons(storedGuitars);
    addToCartButtons.forEach((addToCartButton) => {
        addToCartButton.addEventListener('click', (event) => {
            addToShoppingCart(event.target);
        })
    })
});


    // checks if user is logged in as admin
    function isAdmin(){
        let isAdminDiv = document.querySelector('.js-is-admin');
        let isAdmin = isAdminDiv.getAttribute('data-is-admin');
        return isAdmin;
    }

    /*
    * adds target to shopping cart if not already in there
    */
    function addToShoppingCart(guitarTarget) {

        // gets stored stored guitars - converts string to object
        storedGuitars = JSON.parse(localStorage.getItem('guitars') ?? '{}');

        let guitarId = guitarTarget.getAttribute('data-guitar-id');

        if(isInShoppingCart(guitarId)) return;

        let guitarName = guitarTarget.getAttribute('data-name');
        let guitarImageSrc = guitarTarget.getAttribute('data-image-src');
        let guitarPrice = guitarTarget.getAttribute('data-price');

        storedGuitars[guitarId] = {
            'id': guitarId,
            'name': guitarName,
            'imageSrc': guitarImageSrc,
            'price' : guitarPrice
        }

        // sets changed guitars as new stored guitars - converts object to string
        localStorage.setItem("guitars", JSON.stringify(storedGuitars));

        refreshSidebarEntries(storedGuitars);
        refreshAddToCartButtons(storedGuitars);
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
        localStorage.setItem("guitars", JSON.stringify(storedGuitars));

        refreshSidebarEntries(storedGuitars); 
        refreshShoppingCartPageOverview(storedGuitars);
        refreshAddToCartButtons(storedGuitars);
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

        let isAdminLoggedIn = isAdmin();
        if (isAdminLoggedIn == "1") return;

        // Clears existing content in the sidebar
        appendingTarget.innerHTML = '';

        let length = Object.keys(storedGuitars).length;
        refreshShoppingCartCounter(length);

        let totalPrice = parseInt(0);

        // create elements and append them to the target
        for (let key in storedGuitars) {
            let guitarValue = storedGuitars[key];

            totalPrice += parseInt(guitarValue.price);

            let shoppingItemContainer = document.createElement('div');
            shoppingItemContainer.className = "shopping-cart__item-container";

            let shoppingItemContainerFirstRow = document.createElement('div');
            shoppingItemContainerFirstRow.className = "shopping-cart__item-container-first-row";

            let shoppingItemContainerSecondRow = document.createElement('div');
            shoppingItemContainerSecondRow.className = "shopping-cart__item-container-second-row";

            let shoppingItemContainerThirdRow = document.createElement('div');
            shoppingItemContainerThirdRow.className = "shopping-cart__item-container-third-row";

            let aTagToGuitar = document.createElement('a');
            aTagToGuitar.href = serverUrl + guitarDetailPageUrl + guitarValue.id;
            aTagToGuitar.className = 'image__frame shopping-cart__a-tag'

            let imageElement = document.createElement('img');
            imageElement.src = guitarValue.imageSrc;

            aTagToGuitar.appendChild(imageElement);
            shoppingItemContainerFirstRow.appendChild(aTagToGuitar);

            let nameElement = document.createElement('p');
            nameElement.className = "shopping-cart__name"
            nameElement.textContent = guitarValue.name;
            shoppingItemContainerSecondRow.appendChild(nameElement);

            let priceElement = document.createElement('p');
            priceElement.className = "shopping-cart__price"
            priceElement.textContent = guitarValue.price + ',00 €';
            shoppingItemContainerThirdRow.appendChild(priceElement);

            let removeButton = document.createElement('div');
            removeButton.setAttribute('data-guitar-id', guitarValue.id);
            removeButton.className = "button shopping-cart__remove-button";
            removeButton.innerHTML = "<img src='" + serverUrl + "/assets/icons/delete.svg' class='shopping-cart__icon' >" ;
            shoppingItemContainerThirdRow.appendChild(removeButton);

            removeButton.addEventListener('click', function(event) {
                event.stopPropagation();
                removeFromShoppingCart(event.target); 
            })

            shoppingItemContainer.append(shoppingItemContainerFirstRow);
            shoppingItemContainer.append(shoppingItemContainerSecondRow);
            shoppingItemContainer.append(shoppingItemContainerThirdRow);

            appendingTarget.appendChild(shoppingItemContainer);
        }

        totalPriceElement = document.createElement('p');
        totalPriceElement.className = 'shopping-cart__total-price';
        totalPriceElement.innerHTML = '<span class="bold">Totalpreis: </span>' + totalPrice + ',00 €';
        appendingTarget.appendChild(totalPriceElement);
    }



    /*
    * refreshs shopping cart counter in the navbar
    */
    function refreshShoppingCartCounter(number) {
        let isAdminLoggedIn = isAdmin();
        if (isAdminLoggedIn == "1") return;

        let shoppingCartCounter = document.querySelector('.js-shopping-cart-counter');
        shoppingCartCounter.style.visibility = (number == 0) ? 'hidden' : 'visible';
        shoppingCartCounter.innerHTML = number;
    }


    /*
    * refreshs shopping cart form for guitars
    */
    function refreshShoppingCartFormGuitars(storedGuitars) {
        
        let shoppingCartFormGuitars = document.querySelector('.js-shopping-cart-form-guitars');
        let guitarIds = [];
        let counter = 0;

        shoppingCartFormGuitars.innerHTML = '';

        for (let key in storedGuitars) {
            guitarIds.push(key);
            counter++;
        }

        if (counter > 0) {
            let guitarInput = document.createElement('input');
            guitarInput.name = "ids";
            guitarInput.value = guitarIds;
            guitarInput.required = true;
            guitarInput.hidden = true;
            shoppingCartFormGuitars.append(guitarInput);

            let submitButton = document.createElement('input');
            submitButton.type = 'submit';
            submitButton.className = 'button';
            submitButton.value = "Jetzt kostenpflichtig bestellen";
            submitButton.name = 'submit';
            shoppingCartFormGuitars.append(submitButton);
        }




    }



    /*
    * refreshs shopping cart if on page 'shopping-cart'
    */
   function refreshShoppingCartPageOverview(storedGuitars) {
        if(window.location.href == serverUrl + shoppingCartPageUrl){
            let overviewContainer = document.querySelector('.js-shopping-cart-overview-container');
            appendShoppingItemsToTarget(overviewContainer, storedGuitars);
            refreshShoppingCartFormGuitars(storedGuitars);
        }
   }


    /*
    * refreshs add-to-cart-Buttons
    */
    function refreshAddToCartButtons(storedGuitars) {

        let allButtons = document.querySelectorAll('.js-add-to-cart-button');
        allButtons.forEach((button) => {
            let buttonGuitarId = button.getAttribute('data-guitar-id');
            if (buttonGuitarId in storedGuitars) {
                button.disabled = true;
            } else {
                button.disabled = false;
            }
        });
    }



