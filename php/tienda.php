<?php
require_once('conexion.php'); 
session_start();

$consulta = "SELECT * FROM productos WHERE stock > 0";
$stmt = $pdo->query($consulta);
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda - Yggdrasil Garden</title>
    <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="wrapper">
        
        <header class="header-mobile">
            <a href="../index.php" class="logo">
                <img src="../images/logo.jpg" alt="Yggdrasil Garden Logo">
            </a> 

        </header>

        
        <main>
            <h2 class="titulo-principal" id="titulo-principal">Todos los productos</h2>
            <div id="contenedor-productos" class="contenedor-productos">
                <?php
                if ($productos) {
                    foreach ($productos as $producto) {
                        echo '<div class="producto">';
                        echo '<img src="../' . htmlspecialchars($producto['imagen']) . '" alt="' . htmlspecialchars($producto['nombre']) . '">';
                        echo '<h3>' . htmlspecialchars($producto['nombre']) . '</h3>';
                        echo '<p class="descripcion">' . htmlspecialchars($producto['descripcion']) . '</p>';
                        echo '<p class="precio">$' . number_format($producto['precio'], 0, ',', '.') . '</p>';
                        echo '<button class="btn agregar-carrito">Agregar al carrito</button>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>No hay productos disponibles por el momento.</p>";
                }
                ?>
            </div>
        </main>
    </div>

    
    <script src="../js/menu.js"></script>
    <script src="../js/main.js"></script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    // Selecciona todos los botones de agregar al carrito
    const botones = document.querySelectorAll('.agregar-carrito');
    const productos = <?php echo json_encode($productos); ?>;

    botones.forEach((btn, idx) => {
        btn.addEventListener('click', function() {
            const producto = productos[idx];
            let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
            // Verifica si ya está en el carrito
            const existe = carrito.find(p => p.id == producto.id);
            if (existe) {
                existe.cantidad += 1;
            } else {
                producto.cantidad = 1;
                carrito.push(producto);
            }
            localStorage.setItem('carrito', JSON.stringify(carrito));
            alert('Producto agregado al carrito');
        });
    });
});
</script>
<button id="boton-carrito" style="
    position: fixed;
    left: 32px;
    bottom: 32px;
    background: #388e3c;
    color: #fff;
    border: none;
    border-radius: 50px;
    padding: 14px 28px;
    font-size: 1.1rem;
    font-weight: 600;
    box-shadow: 0 4px 16px rgba(44,62,80,0.15);
    cursor: pointer;
    z-index: 1000;
    display: flex;
    align-items: center;
    gap: 10px;
">
    <i class="bi bi-cart"></i>
    <span>Carrito (<span id="cantidad-carrito">0</span>)</span>
</button>

<script>
function actualizarCantidadCarrito() {
    let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    let cantidad = carrito.reduce((acc, prod) => acc + (prod.cantidad || 1), 0);
    document.getElementById('cantidad-carrito').textContent = cantidad;
}

document.getElementById('boton-carrito').addEventListener('click', function() {
    window.location.href = 'carrito.php';
});

// Actualiza cantidad al cargar y cada vez que se agrega un producto
document.addEventListener('DOMContentLoaded', function() {
    actualizarCantidadCarrito();

    const botones = document.querySelectorAll('.agregar-carrito');
    const productos = <?php echo json_encode($productos); ?>;

    botones.forEach((btn, idx) => {
        btn.addEventListener('click', function() {
            const producto = productos[idx];
            let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
            const existe = carrito.find(p => p.id == producto.id);
            if (existe) {
                existe.cantidad += 1;
            } else {
                producto.cantidad = 1;
                carrito.push(producto);
            }
            localStorage.setItem('carrito', JSON.stringify(carrito));
            actualizarCantidadCarrito();
            alert('Producto agregado al carrito');
        });
    });
});
</script>
</body>
</html>
