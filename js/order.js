document.addEventListener('DOMContentLoaded', () => {
    const addToCartButton = document.querySelector('.add-to-cart');
    const cartItemCount = document.querySelector('.basket-icon span');
    const cartItemList = document.querySelector('.basket-items');
    const cartTotal = document.querySelector('.basket-total');
    const cartIcon = document.querySelector('.basket-icon');
    const sidebar = document.querySelector('.sidebar-cart');
    const serviceTypeSelect = document.querySelector('.service-type');
    const bookButton = document.querySelector('.book-btn');

    let cartItems = [];
    let totalAmount = 0;

    addToCartButton.addEventListener('click', () => {
        const serviceType = serviceTypeSelect.selectedOptions[0].textContent;
        const unitPrice = parseFloat(serviceTypeSelect.selectedOptions[0].dataset.price);

        const item = {
            serviceType: serviceType,
            unitPrice: unitPrice
        };

        cartItems.push(item);
        totalAmount += item.unitPrice;
        updateCartUI();
    });

    function updateCartUI() {
        updateCartItemCount(cartItems.length);
        updateCartItemList();
        updateCartTotal();
    }

    function updateCartItemCount(count) {
        cartItemCount.textContent = count;
    }

    function updateCartItemList() {
        cartItemList.innerHTML = '';
        cartItems.forEach((item, index) => {
            const cartItem = document.createElement('div');
            cartItem.classList.add('cart-item', 'individual-cart-item');
            cartItem.innerHTML = `
                <span>${item.serviceType}</span>
                <span class="basket-item-price">₱${item.unitPrice.toFixed(2)}
                    <button class="remove-item" data-index="${index}"><i class="fa-solid fa-times"></i></button>
                </span>
            `;
            cartItemList.append(cartItem);
        });

        const removeButtons = document.querySelectorAll('.remove-item');
        removeButtons.forEach((button) => {
            button.addEventListener('click', (event) => {
                const index = event.currentTarget.dataset.index;
                removeItemsFromCart(index);
            });
        });
    }

    function removeItemsFromCart(index) {
        const removedItem = cartItems.splice(index, 1)[0];
        totalAmount -= removedItem.unitPrice;
        updateCartUI();
    }

    function updateCartTotal() {
        cartTotal.textContent = `₱${totalAmount.toFixed(2)}`;
    }

    cartIcon.addEventListener('click', () => {
        sidebar.classList.toggle('open');
    });

    const closeSidebarButton = document.querySelector('.sidebar-close');
    closeSidebarButton.addEventListener('click', () => {
        sidebar.classList.remove('open');
    });

    bookButton.addEventListener('click', () => {
        cartItems = [];
        totalAmount = 0;
        updateCartUI();
        window.location.href = 'tracker.html';
    });
});
