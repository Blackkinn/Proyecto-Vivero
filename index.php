<?php
// Inicia la sesión para manejar datos del usuario autenticado
session_start();
$usuario = $_SESSION['usuario_nombre'] ?? 'Invitado'; // Muestra el nombre del usuario o "Invitado"
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Metadatos esenciales -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yggdrasil Garden</title>

    <!-- Favicon e importación de estilos -->
    <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="./css/normalize.css">
    <link rel="stylesheet" href="./css/estilos.css">
    
</head>

<body>
    <!-- Header principal con navegación -->
    <header class="hero">
        <nav class="nav container">
            <!-- Logo del sitio -->
            <div class="nav__logo">
                <h2 class="nav__title">Yggdrasil Garden</h2>
            </div>

            <!-- Menú de navegación -->
            <ul class="nav__link nav__link--menu">
                <li class="nav__items"><a href="#" class="nav__links">Inicio</a></li>
                <li class="nav__items"><a href="#" class="nav__links">Blog</a></li>
                <li class="nav__items"><a href="./php/tienda.php" class="nav__links">Tienda</a></li>

                <!-- Enlace de ingreso visible solo para visitantes -->
                <li class="nav__items">
                    <?php if (!isset($_SESSION['usuario_id'])): ?>
                        <a id="btn-ingresar" href="./html/login.html" class="nav__links">Ingresar</a>
                    <?php endif; ?>
                </li>

                <!-- Mostrar perfil si el usuario está autenticado -->
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <li class="nav__items">
                        <a href="./php/perfil.php" class="nav__links">
                            👤 Bienvenido, <?php echo htmlspecialchars($usuario); ?>.
                        </a>
                    </li>
                <?php endif; ?>

                <!-- Ícono para cerrar menú móvil -->
                <img src="../images/close.svg" class="nav__close">
            </ul>

            <!-- Ícono para abrir menú móvil -->
            <div class="nav__menu">
                <img src="../images/menu.svg" class="nav__img">
            </div>
        </nav>

        <!-- Sección principal del encabezado -->
        <section class="hero__container container">
            <h1 class="hero__title">Raíces fuertes, hojas eternas.</h1>
            <p class="hero__paragraph">Yggdrasil Garden: Más que un vivero, un puente entre tú y la naturaleza.</p>
            <a href="/Proyecto-Vivero/html/Tienda.html" class="cta">Nuestros Productos</a>
        </section>
    </header>

    <main>
        <!-- Sección de productos destacados -->
        <section class="price container">
            <h2 class="subtitle">¿Otra más para la colección?</h2>

            <div class="price__table">
                <!-- Producto 1 -->
                <div class="price__element">
                    <h2 class="price__price">Orquídea Cattleya trianae</h2>
                    <p class="price__name">Flor de mayo</p>
                    <div class="price__items">
                        <img src="../images/f_mayo.jpg" class="colec__img">
                        <p class="price__features">Flor emblemática de Colombia.</p>
                        <p class="price__features">Símbolo nacional desde 1936.</p>
                    </div>
                    <a href="/Proyecto-Vivero/html/Tienda.html" class="price__cta">Llévatela.</a>
                </div>

                <!-- Producto 2 -->
                <div class="price__element">
                    <h2 class="price__price">Heliconia Rostrata</h2>
                    <p class="price__name">Platanillo</p>
                    <div class="price__items">
                        <img src="../images/heliconif.jpg" class="colec__img">
                        <p class="price__features">Exótica con brácteas rojas y amarillas.</p>
                        <p class="price__features">Ideal para jardines ornamentales.</p>
                    </div>
                    <a href="/Proyecto-Vivero/html/Tienda.html" class="price__cta">Llévatela.</a>
                </div>

                <!-- Producto 3 -->
                <div class="price__element">
                    <h2 class="price__price">Espeletia Grandiflora</h2>
                    <p class="price__name">Frailejón</p>
                    <div class="price__items">
                        <img src="../images/f_frailejon.jpg" class="colec__img">
                        <p class="price__features">Protegida legalmente.</p>
                        <p class="price__features">Flores amarillas como margaritas.</p>
                    </div>
                    <a href="/Proyecto-Vivero/html/Tienda.html" class="price__cta">Llévatela.</a>
                </div>
            </div>
        </section>

        <!-- Carrusel de testimonios o productos -->
        <section class="swaps">
            <div class="swaps__container container">
                <!-- Flechas de navegación -->
                <img src="../images/leftarrow.svg" class="swaps__arrow" id="before">

                <!-- Slide dinámico (repetido con PHP como ejemplo) -->
                <?php for ($i = 1; $i <= 4; $i++): ?>
                <section class="swaps__body <?= $i === 1 ? 'swaps__body--show' : '' ?>" data-id="<?= $i ?>">
                    <div class="swaps__text">
                        <h2 class="subtitle"><?= $i ?>. <span class="swaps__course">Planta <?= $i ?></span></h2>
                        <p class="swaps__review">Descripción de la planta <?= $i ?>.</p>
                    </div>
                    <figure class="swaps__picture">
                        <img src="../images/produc.jpg" class="swaps__img">
                    </figure>
                </section>
                <?php endfor; ?>

                <img src="../images/rightarrow.svg" class="swaps__arrow" id="next">
            </div>
        </section>
    </main>

    <!-- Pie de página -->
    <footer class="footer">
        <section class="footer__container container">
            <!-- Menú en el footer -->
            <nav class="nav nav--footer">
                <h2 class="footer__title">Yggdrasil Garden</h2>
                <ul class="nav__link nav__link--footer">
                    <li class="nav__items"><a href="#" class="nav__links">Inicio</a></li>
                    <li class="nav__items"><a href="views/Tienda.html" class="nav__links">Tienda</a></li>
                    <li class="nav__items"><a href="#" class="nav__links">Blog</a></li>
                </ul>
            </nav>

            <!-- Formulario de suscripción -->
            <form class="footer__form" action="https://formspree.io/f/mknkkrkj" method="POST">
                <h2 class="footer__newsletter">Suscríbete a nuestra comunidad.</h2>
                <div class="footer__inputs">
                    <input type="email" placeholder="Email:" class="footer__input" name="_replyto" required>
                    <input type="submit" value="Registrarse" class="footer__submit">
                </div>
            </form>
        </section>

        <!-- Red social y derechos -->
        <section class="footer__copy container">
            <div class="footer__social">
                <a href="#" class="footer__icons"><img src="../images/facebook.svg" class="footer__img"></a>
                <a href="#" class="footer__icons"><img src="../images/twitter.svg" class="footer__img"></a>
                <a href="#" class="footer__icons"><img src="../images/youtube.svg" class="footer__img"></a>
            </div>
        </section>
    </footer>

    <!-- Panel de administración solo visible si el usuario es administrador -->
    <section id="admin-panel" class="admin-panel" style="display: none;">
        <h2>Panel de Administración</h2>
        <div class="admin-actions">
            <button id="add-product">Agregar Producto</button>
            <button id="edit-product">Editar Producto</button>
            <button id="delete-product">Eliminar Producto</button>
            <button id="update-stock">Actualizar Stock</button>
        </div>
        <div id="admin-content"></div>
    </section>

    <!-- Script para mostrar menú dinámico si el usuario está logueado -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const adminPanel = document.getElementById("admin-panel");
            const userRole = localStorage.getItem("userRole");

            // Mostrar panel solo si es admin
            if (userRole === "admin") {
                adminPanel.style.display = "block";
            }

            // Modificar el menú si hay un usuario autenticado en localStorage
            const navLinks = document.querySelector(".nav__link");
            const user = JSON.parse(localStorage.getItem("user"));

            if (user) {
                // Elimina "Ingresar"
                const loginItem = document.querySelector('.nav__items a[href="views/login.html"]');
                if (loginItem) loginItem.parentElement.remove();

                // Agrega "Perfil"
                const profileItem = document.createElement("li");
                profileItem.classList.add("nav__items");
                profileItem.innerHTML = `<a href="views/perfil.html" class="nav__links">Perfil</a>`;
                navLinks.appendChild(profileItem);

                // Agrega "Cerrar sesión"
                const logoutItem = document.createElement("li");
                logoutItem.classList.add("nav__items");
                logoutItem.innerHTML = `<a href="#" class="nav__links" id="logout-link">Cerrar sesión</a>`;
                navLinks.appendChild(logoutItem);

                // Acción del botón de logout
                document.getElementById("logout-link").addEventListener("click", function (e) {
                    e.preventDefault();
                    localStorage.removeItem("user");
                    localStorage.removeItem("userRole");
                    window.location.href = "views/login.html";
                });
            }
        });
    </script>

    <!-- Scripts del slider y menú móvil -->
    <script src="../js/slider.js"></script>
    <script src="../js/menu.js"></script>
</body>
</html>
