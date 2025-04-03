document.addEventListener("DOMContentLoaded", function () {
    const user = JSON.parse(localStorage.getItem("user"));
    if (!user) {
        window.location.href = "login.html"; // Redirige si no está logueado
    }

    document.getElementById("nombre").value = user.nombre;
    document.getElementById("email").value = user.email;
    document.getElementById("direccion").value = user.direccion || "";
    document.getElementById("telefono").value = user.telefono || "";

    document.getElementById("perfil-form").addEventListener("submit", function (event) {
        event.preventDefault();

        let oldPass = document.getElementById("old-password").value;
        let newPass = document.getElementById("new-password").value;
        let confirmPass = document.getElementById("confirm-password").value;

        if (oldPass || newPass || confirmPass) {
            if (oldPass !== user.password) {
                alert("Contraseña actual incorrecta.");
                return;
            }

            if (newPass !== confirmPass) {
                alert("Las contraseñas no coinciden.");
                return;
            }

            user.password = newPass;
        }

        user.direccion = document.getElementById("direccion").value;
        user.telefono = document.getElementById("telefono").value;

        localStorage.setItem("user", JSON.stringify(user));
        alert("Datos actualizados correctamente.");
    });

    document.getElementById("cerrar-sesion").addEventListener("click", function () {
        localStorage.removeItem("user");
        window.location.href = "index.html"; // Redirige a la página principal
    });
});
