document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('notification-btn').addEventListener('click', function() {
        document.getElementById('notification-modal').style.display = 'block';
    });

    document.getElementsByClassName('close-btn')[0].addEventListener('click', function() {
        document.getElementById('notification-modal').style.display = 'none';
    });

    window.onclick = function(event) {
        if (event.target == document.getElementById('notification-modal')) {
            document.getElementById('notification-modal').style.display = 'none';
        }
    }

    document.querySelector('.accept-btn').addEventListener('click', function() {
        alert('Contract Accepted');
        document.getElementById('notification-modal').style.display = 'none';
    });

    document.querySelector('.decline-btn').addEventListener('click', function() {
        alert('Contract Declined');
        document.getElementById('notification-modal').style.display = 'none';
    });

    document.getElementById('manage-appointments').addEventListener('click', function() {
        window.location.href = 'appointment.html';
    });

    document.getElementById('job-execution').addEventListener('click', function() {
        window.location.href = 'job.html';
    });

    document.getElementById('dashboard').addEventListener('click', function() {
        window.location.href = 'dashboard.php';
    });

    document.getElementById('profile-management').addEventListener('click', function() {
        window.location.href = 'profile.php';
    });

    document.getElementById('profile-circle').addEventListener('click', function() {
        document.getElementById('photo-input').click();
    });

    document.getElementById('photo-input').addEventListener('change', function() {
        var formData = new FormData();
        formData.append('photo', this.files[0]);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'updatephoto.php', true);
        xhr.onload = function () {
            console.log(xhr.responseText); // Log the response for debugging
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    console.log('Photo updated to:', response.photo);
                    var profileImg = document.querySelector('.profile-circle img');
                    profileImg.src = response.photo;
                    profileImg.style.display = 'block';
                    document.querySelector('.profile-circle .default-icon').style.display = 'none';
                } else {
                    alert(response.message);
                }
            } else {
                alert('An error occurred while uploading the file.');
            }
        };
        xhr.send(formData);
    });
});
