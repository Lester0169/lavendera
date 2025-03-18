document.addEventListener('DOMContentLoaded', () => {
    // Handle price range input display
    document.getElementById('price-range').addEventListener('input', function() {
        document.getElementById('price-range-value').textContent = '₱' + this.value;
    });

    // Handle filter modal
    const filterButton = document.getElementById('filter-button');
    const filterModal = document.getElementById('filter-modal');
    const filterCloseButton = filterModal.querySelector('.close-button');

    filterButton.addEventListener('click', () => {
        filterModal.style.display = 'block';
    });

    filterCloseButton.addEventListener('click', () => {
        filterModal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target == filterModal) {
            filterModal.style.display = 'none';
        }
    });

    // Handle favorite button toggle
    const favoriteButtons = document.querySelectorAll('.favorite-button');
    favoriteButtons.forEach(button => {
        button.addEventListener('click', function() {
            this.classList.toggle('favorite');
            this.textContent = this.classList.contains('favorite') ? 'Favorited' : 'Mark as Favorite';
        });
    });

    // Handle price list modal
    const priceListButtons = document.querySelectorAll('.price-list-button');
    const priceListModal = document.getElementById('price-list-modal');
    const priceListCloseButton = priceListModal.querySelector('.close-button');

    priceListButtons.forEach(button => {
        button.addEventListener('click', () => {
            priceListModal.style.display = 'block';
        });
    });

    priceListCloseButton.addEventListener('click', () => {
        priceListModal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target == priceListModal) {
            priceListModal.style.display = 'none';
        }
    });

    // Handle select button navigation
    const selectButtons = document.querySelectorAll('.select-button');
    selectButtons.forEach(button => {
        button.addEventListener('click', function() {
            const name = this.getAttribute('data-name');
            window.location.href = `order.html?name=${encodeURIComponent(name)}`;
        });
    });
});
