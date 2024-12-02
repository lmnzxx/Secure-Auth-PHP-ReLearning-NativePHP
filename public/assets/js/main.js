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

        // Fungsi untuk memeriksa validasi password
        function validatePassword() {
            const password = passwordInput.value;

            // Validasi menggunakan regex
            const validations = {
                length: password.length >= 8,
                uppercase: /[A-Z]/.test(password),
                lowercase: /[a-z]/.test(password),
                number: /\d/.test(password),
                special: /[\W_]/.test(password),
            };

            // Update status validasi di UI
            for (const [key, isValid] of Object.entries(validations)) {
                requirements[key].className = isValid ? "valid" : "invalid";
            }

            // Aktifkan tombol submit jika semua validasi terpenuhi
            const allValid = Object.values(validations).every(Boolean);
            submitButton.disabled = !allValid;
        }

        // Event listener untuk validasi real-time menggunakan 'keyup'
        passwordInput.addEventListener("keyup", validatePassword);

        // Inisialisasi validasi saat pertama kali form dimuat
        validatePassword();
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.querySelector("form");

    if (loginForm) {
        // Optional: Tambahkan validasi form saat submit
        loginForm.addEventListener("submit", function (event) {
            const username = document.getElementById("username").value;
            const password = document.getElementById("password").value;

            if (!username || !password) {
                event.preventDefault(); // Batalkan pengiriman form
                alert("Please fill in both fields.");
            }
        });
    }
});
