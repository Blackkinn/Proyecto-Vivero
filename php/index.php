<?php session_start(); ?>
<nav class="nav container">
    <ul class="nav__link nav__link--menu">
        <li class="nav__items">
            <a href="index.php" class="nav__links">Inicio</a>
        </li>
        <li class="nav__items">
            <a href="blog.php" class="nav__links">Blog</a>
        </li>
        <li class="nav__items">
            <a href="Tienda.php" class="nav__links">Tienda</a>
        </li>

        <?php if (isset($_SESSION['usuario'])): ?>
            <li class="nav__items">
                <a href="perfil.php" class="nav__links">Perfil</a>
            </li>
        <?php else: ?>
    </ul>
</nav>
