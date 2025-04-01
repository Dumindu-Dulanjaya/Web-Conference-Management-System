// Array of background images
const bgImages = [
    './images/img30.jpg',
    './images/img28.jpg',
    './images/img25.jpg',
    './images/img31.jpg'
];

// Get the content container
const contentDiv = document.querySelector('.content');

// Initialize the current image index
let currentImageIndex = 0;

// Function to change the background image
function changeBackgroundImage() {
    contentDiv.style.backgroundImage = `url('${bgImages[currentImageIndex]}')`;
    currentImageIndex = (currentImageIndex + 1) % bgImages.length; // Loop through the array
}

// Change image every 5 seconds
setInterval(changeBackgroundImage, 5000);

// Set the initial background image
changeBackgroundImage();
