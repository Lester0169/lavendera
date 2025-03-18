document.addEventListener('DOMContentLoaded', function() {
    const howToBookBtn = document.getElementById('how-to-book-btn');
    const modal = document.getElementById('how-to-book-modal');
    const closeBtn = document.querySelector('.close-btn');

    howToBookBtn.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default anchor behavior
        modal.style.display = 'block';
    });

    closeBtn.addEventListener('click', function() {
        modal.style.display = 'none';
    });

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    };
});
