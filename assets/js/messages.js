const showCustomAlert = (message) => {
    // Set the message in the popup
    document.getElementById('alertMessage').textContent = message;

    // Display the popup with animation
    const customAlert = document.getElementById('customAlert');
    customAlert.style.display = 'flex';

    // Allow time for animation to finish before allowing closure
    setTimeout(() => {
        customAlert.style.pointerEvents = 'auto';
    }, 500); // 500ms = the duration of the animation
}

const closeCustomAlert = () => {
    const customAlert = document.getElementById('customAlert');
    customAlert.style.animation = 'fadeOut 0.3s forwards';

    // After fade-out animation, hide the popup
    setTimeout(() => {
        customAlert.style.display = 'none';
        customAlert.style.animation = ''; // Reset animation
    }, 300); // Match the duration of fadeOut animation
}
