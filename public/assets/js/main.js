document.addEventListener("DOMContentLoaded", function() {
    const loginForm = document.querySelector("form");
    
    // Optional: Add form validation on submit if needed
    loginForm.addEventListener("submit", function(event) {
        const username = document.getElementById("username").value;
        const password = document.getElementById("password").value;

        if (!username || !password) {
            event.preventDefault(); // Prevent form submission
            alert("Please fill in both fields.");
        }
    });
});
