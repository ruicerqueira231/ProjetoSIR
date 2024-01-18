document.addEventListener('DOMContentLoaded', function () {
    console.log("DOM fully loaded and parsed");

    // Settings modal
    var settingsButton = document.getElementById('sidebarSettingsButton');
    var settingsModal = new bootstrap.Modal(document.getElementById('settingsModal'));

    settingsButton.addEventListener('click', function () {
        console.log("Settings button clicked");
        settingsModal.show();
    });

    // Prepare night mode toggle without immediate effect
    var nightModeCheckbox = document.getElementById('nightModeCheckbox');

    // Load saved mode and update checkbox accordingly
    if (localStorage.getItem('nightMode') === 'true') {
        document.body.classList.add('night-mode');
        nightModeCheckbox.checked = true;
    }

    // Save settings and apply night mode on clicking 'Save changes'
    var saveSettingsButton = document.getElementById('saveSettingsButton');
    saveSettingsButton.addEventListener('click', function () {
        var nightModeCheckbox = document.getElementById('nightModeCheckbox');
        document.body.classList.toggle('night-mode', nightModeCheckbox.checked);
        localStorage.setItem('nightMode', nightModeCheckbox.checked);

        // Optionally, hide the modal after saving
        settingsModal.hide();
    });

    var profilePictures = document.querySelectorAll('.profile-picture');
    var imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
    var modalImage = document.getElementById('modalImage');

    profilePictures.forEach(function(profilePicture) {
        profilePicture.addEventListener('click', function () {
            var imageUrl = this.getAttribute('src'); // Get the image URL from the clicked picture
            modalImage.src = imageUrl; // Set the src for the modal image
            imageModal.show(); // Show the modal
        });
    });
});

function confirmLogout() {
    if (confirm("Are you sure you want to logout?")) {
        window.location.href = "logout.php"; // Replace with your logout URL
    }
}

