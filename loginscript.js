document.getElementById("userType").addEventListener("change", function () {
    const usernamePasswordFields = document.getElementById("usernamePasswordFields");
    if (this.value) {
        usernamePasswordFields.style.display = "block";
    } else {
        usernamePasswordFields.style.display = "none";
    }
});

document.getElementById("loginForm").addEventListener("submit", function (event) {
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();

    if (!email || !password) {
        event.preventDefault();
        document.getElementById("error-message").textContent = "Please fill in all required fields.";
        document.getElementById("error-message").style.color = "red";
    }
});
