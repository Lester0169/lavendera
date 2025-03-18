document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.getElementById('sidebar');
    const rebookButtons = document.querySelectorAll('.rebook-button');
    const rebookModal = document.getElementById('rebook-modal');
    const contractModal = document.getElementById('contract-modal');
    const closeButtons = document.querySelectorAll('.close-button');
    const makeFavoriteButton = document.getElementById('make-favorite-button');
    const cancelRebookButton = document.getElementById('cancel-rebook-button');
    const saveContractButton = document.getElementById('save-contract-button');
    const cancelContractButton = document.getElementById('cancel-contract-button');

    rebookButtons.forEach(button => {
        button.addEventListener('click', () => {
            rebookModal.style.display = 'block';
        });
    });

    closeButtons.forEach(button => {
        button.addEventListener('click', () => {
            button.closest('.modal').style.display = 'none';
        });
    });

    window.addEventListener('click', (event) => {
        if (event.target === rebookModal) {
            rebookModal.style.display = 'none';
        }
        if (event.target === contractModal) {
            contractModal.style.display = 'none';
        }
    });

    makeFavoriteButton.addEventListener('click', () => {
        rebookModal.style.display = 'none';
        contractModal.style.display = 'block';
    });

    cancelRebookButton.addEventListener('click', () => {
        rebookModal.style.display = 'none';
        alert('Rebooked successfully!');
    });

    saveContractButton.addEventListener('click', () => {
        alert('Contract send successfully!');
        contractModal.style.display = 'none';
    });

    cancelContractButton.addEventListener('click', () => {
        contractModal.style.display = 'none';
    });

    // Add navigation functionality
    const sidebarItems = document.querySelectorAll('.sidebar-item');
    sidebarItems.forEach(item => {
        item.addEventListener('click', () => {
            const link = item.getAttribute('data-link');
            if (link) {
                window.location.href = link;
            }
        });
    });
});
