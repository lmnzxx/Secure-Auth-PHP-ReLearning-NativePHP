document.addEventListener("DOMContentLoaded", function () {
    const registerContainer = document.getElementById("register");

    if (registerContainer) {
        const passwordInput = registerContainer.querySelector("#password");
        const submitButton = registerContainer.querySelector("button[type='submit']");
        const requirements = {
            length: registerContainer.querySelector("#length"),
            uppercase: registerContainer.querySelector("#uppercase"),
            lowercase: registerContainer.querySelector("#lowercase"),
            number: registerContainer.querySelector("#number"),
            special: registerContainer.querySelector("#special"),
        };

        function validatePassword() {
            const password = passwordInput.value;

            const validations = {
                length: password.length >= 8,
                uppercase: /[A-Z]/.test(password),
                lowercase: /[a-z]/.test(password),
                number: /\d/.test(password),
                special: /[\W_]/.test(password),
            };

            for (const [key, isValid] of Object.entries(validations)) {
                requirements[key].className = isValid ? "valid" : "invalid";
            }

            const allValid = Object.values(validations).every(Boolean);
            submitButton.disabled = !allValid;
        }

        passwordInput.addEventListener("keyup", validatePassword);

        validatePassword();
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.querySelector("form");

    if (loginForm) {
        loginForm.addEventListener("submit", function (event) {
            const username = document.getElementById("username").value;
            const password = document.getElementById("password").value;

            if (!username || !password) {
                event.preventDefault(); 
                alert("Please fill in both fields.");
            }
        });
    }
});
