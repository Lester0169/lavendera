document.addEventListener('DOMContentLoaded', () => {
    const statusIndicators = document.querySelectorAll('.status-indicator');
    const statusText = document.getElementById('status-text');
    const realTime = document.getElementById('real-time');
    const statusIcon = document.querySelector('.status-icon img');
    const payButton = document.getElementById('pay-button');
    const cancelButton = document.getElementById('cancel-button');
    const statuses = [
        'The laundrywoman just picked up your laundry.',
        'Your laundry is being washed.',
        'Your laundry is being folded.',
        'Your order is complete.'
    ];
    const statusImages = [
        'images/pickup.png',
        'images/washing.jpeg',
        'images/folding.jpeg',
        'images/comp.png'
    ];
    const times = ['9:50 AM', '10:30 AM', '12:00 PM', '12:15 PM'];

    let currentStatusIndex = 0;

    const updateStatus = () => {
        if (currentStatusIndex < statuses.length) {
            statusIndicators.forEach((indicator, index) => {
                if (index <= currentStatusIndex) {
                    indicator.classList.add('active');
                } else {
                    indicator.classList.remove('active');
                }
            });
            statusIcon.src = statusImages[currentStatusIndex];
            statusText.textContent = statuses[currentStatusIndex];
            realTime.textContent = times[currentStatusIndex];

            if (currentStatusIndex === statuses.length - 1) {
                payButton.style.display = 'block'; 
                cancelButton.style.display = 'none'; 
            }
            currentStatusIndex++;
        }
    };

    const scheduleTimes = [
        new Date().setHours(9, 50),
        new Date().setHours(10, 30),
        new Date().setHours(12, 0),
        new Date().setHours(12, 15)
    ];

    const checkAndUpdateStatus = () => {
        const now = new Date().getTime();
        if (now >= scheduleTimes[currentStatusIndex]) {
            updateStatus();
        }
    };

    setInterval(checkAndUpdateStatus, 3000);

    cancelButton.addEventListener('click', () => {
        alert('Order has been canceled.');
    });

    payButton.addEventListener('click', () => {
        window.location.href = 'payment.html';
    });
});
