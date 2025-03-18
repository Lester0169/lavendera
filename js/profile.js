document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('add-service-btn').addEventListener('click', function() {
        document.getElementById('service-modal').style.display = 'block';
    });

    document.querySelectorAll('.edit-service-btn').forEach(button => {
        button.addEventListener('click', function() {
            const serviceRow = button.closest('tr');
            const serviceName = serviceRow.children[0].innerText;
            const servicePrice = serviceRow.children[1].innerText;
            document.getElementById('service-name').value = serviceName;
            document.getElementById('service-price').value = servicePrice;
            document.getElementById('service-modal').style.display = 'block';
        });
    });

    document.querySelectorAll('.remove-service-btn').forEach(button => {
        button.addEventListener('click', function() {
            button.closest('tr').remove();
        });
    });

    document.querySelectorAll('.close-btn').forEach(button => {
        button.addEventListener('click', function() {
            button.closest('.modal').style.display = 'none';
        });
    });

    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    };

    document.getElementById('add-service-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const serviceName = document.getElementById('service-name').value;
        const servicePrice = document.getElementById('service-price').value;
        const newServiceRow = `
            <tr>
                <td>${serviceName}</td>
                <td>${servicePrice}</td>
                <td class="actions">
                    <button class="edit-service-btn">Edit</button>
                    <button class="remove-service-btn">Remove</button>
                </td>
            </tr>
        `;
        document.getElementById('standard-services').insertAdjacentHTML('beforeend', newServiceRow);
        document.getElementById('service-modal').style.display = 'none';
        document.getElementById('add-service-form').reset();

        const newRow = document.getElementById('standard-services').lastElementChild;
        newRow.querySelector('.edit-service-btn').addEventListener('click', function() {
            const serviceRow = this.closest('tr');
            const serviceName = serviceRow.children[0].innerText;
            const servicePrice = serviceRow.children[1].innerText;
            document.getElementById('service-name').value = serviceName;
            document.getElementById('service-price').value = servicePrice;
            document.getElementById('service-modal').style.display = 'block';
        });

        newRow.querySelector('.remove-service-btn').addEventListener('click', function() {
            this.closest('tr').remove();
        });
    });

    document.getElementById('dashboard').addEventListener('click', function() {
        window.location.href = 'dashboard.php';
    });

    document.getElementById('profile-management').addEventListener('click', function() {
        window.location.href = 'profile.php';
    });

    document.getElementById('logout').addEventListener('click', function() {
        window.location.href = 'index.html';
    });

    document.getElementById('job-execution').addEventListener('click', function() {
        window.location.href = 'job.html';
    });

    document.getElementById('manage-appointments').addEventListener('click', function() {
        window.location.href = 'appointment.html';
    });
});
