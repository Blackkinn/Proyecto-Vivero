document.addEventListener("DOMContentLoaded", () => {
    const loginForm = document.getElementById("login-form");
    const registerForm = document.getElementById("register-form");
    const toggleRegister = document.getElementById("toggle-register");
    const toggleLogin = document.getElementById("toggle-login");
    const formTitle = document.getElementById("form-title");

    toggleRegister.addEventListener("click", (e) => {
        e.preventDefault();
        loginForm.style.display = "none";
        registerForm.style.display = "block";
        formTitle.textContent = "Regístrate";
    });

    toggleLogin.addEventListener("click", (e) => {
        e.preventDefault();
        loginForm.style.display = "block";
        registerForm.style.display = "none";
        formTitle.textContent = "Iniciar Sesión";
    });

    registerForm.addEventListener("submit", (e) => {
        e.preventDefault();
        const fullName = document.getElementById("register-fullname").value;
        const username = document.getElementById("register-username").value;
        const password = document.getElementById("register-password").value;

        let users = JSON.parse(localStorage.getItem("users")) || [];

        if (users.some(user => user.username === username)) {
            alert("Este usuario ya existe.");
            return;
        }

        users.push({ fullName, username, password });
        localStorage.setItem("users", JSON.stringify(users));
        alert("Registro exitoso. Ahora inicia sesión.");
        registerForm.reset();

        registerForm.style.display = "none";
        loginForm.style.display = "block";
        formTitle.textContent = "Iniciar Sesión";
    });

    loginForm.addEventListener("submit", (e) => {
        e.preventDefault();
        const username = document.getElementById("login-username").value;
        const password = document.getElementById("login-password").value;

        let users = JSON.parse(localStorage.getItem("users")) || [];
        const user = users.find(user => user.username === username && user.password === password);

        if (user) {
            sessionStorage.setItem("loggedUser", username);
            alert("Inicio de sesión exitoso.");
            window.location.href = "index.html";
        } else {
            alert("Usuario o contraseña incorrectos.");
        }
    });

    if (sessionStorage.getItem("loggedUser")) {
        window.location.href = "index.html";
    }

    document.getElementById("back-to-home").addEventListener("click", () => {
        window.location.href = "index.html";
    });
});