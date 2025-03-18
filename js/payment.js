document.addEventListener('DOMContentLoaded', () => {
    const subtotalElement = document.getElementById('subtotal');
    const totalCostElement = document.getElementById('total-cost');
    const payButton = document.querySelector('.pay-btn');
    const burgerIcon = document.getElementById('burger-icon');
    const sidebar = document.getElementById('sidebar');
    const modal = document.getElementById('rating-modal');
    const span = document.getElementsByClassName('close')[0];
    const stars = document.querySelectorAll('.stars .fa');
    let rating = 0;

    burgerIcon.addEventListener('click', () => {
        sidebar.classList.toggle('open');
    });

    payButton.addEventListener('click', () => {
        alert('Payment successful!');
        modal.style.display = "block";
    });

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    stars.forEach(star => {
        star.addEventListener('click', (e) => {
            rating = e.target.getAttribute('data-value');
            stars.forEach(s => s.classList.remove('selected'));
            for (let i = 0; i < rating; i++) {
                stars[i].classList.add('selected');
            }
        });
    });

    document.querySelector('.submit-rating').addEventListener('click', () => {
        const comments = document.getElementById('comments').value;
        alert(`Rating: ${rating}\nComments: ${comments}`);
        modal.style.display = "none";
    });
});
