document.getElementById('manage-appointments').addEventListener('click', function() {
    window.location.href = 'appointment.html';
});

document.getElementById('logout').addEventListener('click', function() {
    window.location.href = 'index.html';
});

document.getElementById('laundry-execution').addEventListener('click', function() {
    window.location.href = 'job.html';
});

document.getElementById('dashboard').addEventListener('click', function() {
    window.location.href = 'dashboard.html';
});

document.getElementById('profile-management').addEventListener('click', function() {
    window.location.href = 'profile.html';
});

document.querySelectorAll('.accept-btn').forEach(button => {
    button.addEventListener('click', function() {
        alert('Laundry accepted!');
    });
});

document.querySelectorAll('.decline-btn').forEach(button => {
    button.addEventListener('click', function() {
        alert('Laundry declined.');
    });
});

document.getElementById('availability-form').addEventListener('submit', function(event) {
    event.preventDefault();
    const days = Array.from(document.querySelectorAll('input[name="days"]:checked'))
                      .map(day => day.value);
    const times = days.map(day => {
        const start = document.getElementById(`${day.toLowerCase()}-start`).value;
        const end = document.getElementById(`${day.toLowerCase()}-end`).value;
        return `${day}: ${start} to ${end}`;
    });
    alert(`Availability saved: \n${times.join('\n')}`);
});
