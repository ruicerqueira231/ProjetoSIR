// Function to open the settings pop-up
function openSettings() {
    document.getElementById("settings-overlay").style.display = "block";
}

// Function to close the settings pop-up
function closeSettings() {
    document.getElementById("settings-overlay").style.display = "none";
}

// Function to handle the image URL update option
function updateImageURL() {
    // Retrieve the URL from the user input (you'll need to create an input element for this)
    const newImageUrl = document.getElementById("image-url-input").value;

    // Send the newImageUrl to the server to update the user's image URL in the database
    // You can use an AJAX request or form submission here
    // After updating, close the pop-up
    closeSettings();
}

// Function to handle the night mode option
function toggleNightMode() {
    // Add code to toggle night mode here
    // You can update your CSS to change the color scheme
    // After toggling, close the pop-up
    closeSettings();
}
