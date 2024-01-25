const serverUrl = "http://localhost/guitarWorld"; 
const shoppingCartPageUrl = "/public/shopping-cart";
const guitarDetailPageUrl = '/public/guitar?guitarId='

document.addEventListener("DOMContentLoaded", async function() {
    let addToCartButtons = document.querySelectorAll('.js-add-to-cart-button');
    let storedGuitars = JSON.parse(localStorage.getItem('guitars') ?? '{}');
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
    }



    /*
    * refresh sidebar entries
    */
    function refreshSidebarEntries(storedGuitars) {
        let sidebarShoppingElements = document.querySelector(".js-sidebar-shopping-elements-container");
        appendShoppingItemsToTarget(sidebarShoppingElements, storedGuitars);
        console.log(storedGuitars)
    }



    /*
    * appends shopping items to view
    */ 
    function appendShoppingItemsToTarget(appendingTarget, storedGuitars) {
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
            shoppingItemContainer.style.paddingBottom = "1rem"

            let aTagToGuitar = document.createElement('a');
            aTagToGuitar.href = serverUrl + guitarDetailPageUrl + guitarValue.id;
            aTagToGuitar.className = 'image__frame'

            let imageElement = document.createElement('img');
            imageElement.src = guitarValue.imageSrc;

            aTagToGuitar.appendChild(imageElement);
            shoppingItemContainer.appendChild(aTagToGuitar);

            let nameElement = document.createElement('p');
            nameElement.className = "shopping-cart__name"
            nameElement.textContent = guitarValue.name;
            shoppingItemContainer.appendChild(nameElement);

            let priceElement = document.createElement('p');
            priceElement.className = "shopping-cart__price"
            priceElement.textContent = guitarValue.price + ',00 €';
            shoppingItemContainer.appendChild(priceElement);

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

        totalPriceElement = document.createElement('p');
        totalPriceElement.innerHTML = 'TOTALPREIS: ' + totalPrice + ',00 €';
        appendingTarget.appendChild(totalPriceElement);
        console.log(totalPrice);

    }



    /*
    * refreshs shopping cart counter in the navbar
    */
    function refreshShoppingCartCounter(number) {
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
            guitarInput.required = true
            guitarInput.hidden = true
            shoppingCartFormGuitars.append(guitarInput);

            let submitButton = document.createElement('input');
            submitButton.type = 'submit'
            submitButton.className = 'button'
            submitButton.value = "Jetzt kostenpflichtig bestellen"
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
   *
   */
  function refreshTotalPrice(storedGuitars){

  }



