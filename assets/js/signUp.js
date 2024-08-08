// Username Validation
let usernameInput = document.getElementById("username");
let usernameInputMessage = document.getElementById("username-input-message");
let usernameRegex = /^[a-zA-Z0-9_]+$/;
let usernameValid = false;

usernameInput.addEventListener("input", () => {
    let username = usernameInput.value;
    if (usernameRegex.test(username)) {
        usernameInputMessage.className = "input-message";
        usernameInputMessage.innerText = "";
        usernameValid = true;
    } else {
        usernameInputMessage.className = "input-message-error";
        usernameInputMessage.innerText = "Invalid username. Only letters, numbers, and underscores are allowed.";
        usernameValid = false;
    }

})

usernameInput.addEventListener('blur', () => {
    let username = usernameInput.value;
    // Test Username not exist in database
    if (!usernameValid) {
        return;
    }
    let validateUsernameRequest = new XMLHttpRequest();
    validateUsernameRequest.onload = () => {
        if (validateUsernameRequest.status === 200) {
            let response = JSON.parse(validateUsernameRequest.responseText);
            if (response['valid'] === false) {
                usernameInputMessage.className = "input-message-error";
                usernameInputMessage.innerText = "This username is already taken";
                usernameValid = false;
            } else {
                usernameInputMessage.className = "input-message";
                usernameInputMessage.innerText = "";
                usernameValid = true;
            }
        }
    }
    // Important && TODO : Config this with actual url path.
    let url = "http://localhost/task-manager/api/usernameValidation.php";
    validateUsernameRequest.open("post", url, true);
    validateUsernameRequest.setRequestHeader("Content-Type", "application/json");
    validateUsernameRequest.send(JSON.stringify({username: username}));
})

// E-Mail Validation
let emailInput = document.getElementById('email');
let emailInputMessage = document.getElementById("email-input-message");
const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
let emailValid = false;
emailInput.addEventListener('input', () => {
    const emailValue = emailInput.value;

    // Test the email value against the regular expression
    if (emailRegex.test(emailValue)) {
        emailInputMessage.innerText = '';
        emailInputMessage.className = 'input-message';
        emailValid = true;
    } else {
        emailInputMessage.innerText = 'Invalid email address';
        emailInputMessage.className = 'input-message-error';
        emailValid = false;
    }
});

// Confirm Password Validation
let passwordInput = document.getElementById("password");
let confirmPasswordInput = document.getElementById("confirm-password");
let submitFormButton = document.getElementById("submit-form-button");
let passwordValid = false;
confirmPasswordInput.addEventListener("input", () => {
    if (usernameValid && emailValid && passwordInput.value === confirmPasswordInput.value) {
        submitFormButton.style.opacity = "100%";
        passwordValid = true;
    } else {
        submitFormButton.style.opacity = "50%";
        passwordValid = false;
    }
})


submitFormButton.addEventListener("click", (e) => {
    if (!(usernameValid && emailValid && passwordValid)) {
        alert("form is not valid");
        e.preventDefault();
    }
})