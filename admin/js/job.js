document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('start-pickup-btn').addEventListener('click', function() {
        document.getElementById('step1').style.display = 'none';
        document.getElementById('step2').style.display = 'flex';
        document.getElementById('step2').style.flexDirection = 'column';
        document.getElementById('step2').style.alignItems = 'center';
    });

    document.getElementById('done-washing-btn').addEventListener('click', function() {
        document.getElementById('step2').style.display = 'none';
        document.getElementById('step3').style.display = 'flex';
        document.getElementById('step3').style.flexDirection = 'column';
        document.getElementById('step3').style.alignItems = 'center';
    });

    document.getElementById('done-folding-btn').addEventListener('click', function() {
        document.getElementById('step3').style.display = 'none';
        document.getElementById('step4').style.display = 'flex';
        document.getElementById('step4').style.flexDirection = 'column';
        document.getElementById('step4').style.alignItems = 'center';
    });

    document.getElementById('complete-laundry-btn').addEventListener('click', function() {
        alert('Laundry completed!');
    });

    document.getElementById('job-execution').addEventListener('click', function() {
        window.location.href = 'job.html';
    });
    document.getElementById('dashboard').addEventListener('click', function() {
        window.location.href = 'dashboard.html';
    });
    document.getElementById('manage-appointments').addEventListener('click', function() {
        window.location.href = 'appointment.html';
    });
    document.getElementById('profile-management').addEventListener('click', function() {
        window.location.href = 'profile.html';
    });

    document.getElementById('logout').addEventListener('click', function() {
        window.location.href = 'index.html';
    });
});
