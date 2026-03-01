<?php
require_once __DIR__.'/../config/database.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .bg-teal{background-color:#20c997!important}
        .btn-teal{background-color:#20c997;border-color:#20c997;color:#fff}
        .btn-teal:hover{background-color:#1aa179;border-color:#1aa179;color:#fff}
        .card-hover:hover{transform:translateY(-5px);transition:0.3s}
        .icon-large{font-size:3rem}
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-teal">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-box-seam"></i> Inventario
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="productos.php">Productos</a>
                <a class="nav-link" href="ventas.php">Ventas</a>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold text-teal">Sistema de Inventario y Ventas</h1>
            <p class="lead text-muted">Gestiona tus productos y registra tus ventas de manera sencilla</p>
        </div>

        <div class="row g-4 justify-content-center">
            <div class="col-md-5">
                <div class="card border-0 shadow card-hover h-100">
                    <div class="card-body text-center p-5">
                        <i class="bi bi-boxes icon-large text-teal mb-3"></i>
                        <h3 class="card-title">Productos</h3>
                        <p class="card-text text-muted">Administra el catálogo de productos, controla precios y stock disponible.</p>
                        <a href="productos.php" class="btn btn-teal btn-lg mt-3">
                            <i class="bi bi-arrow-right-circle"></i> Gestionar
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card border-0 shadow card-hover h-100">
                    <div class="card-body text-center p-5">
                        <i class="bi bi-cart-check icon-large text-teal mb-3"></i>
                        <h3 class="card-title">Ventas</h3>
                        <p class="card-text text-muted">Registra ventas, el sistema actualiza el inventario automáticamente.</p>
                        <a href="ventas.php" class="btn btn-teal btn-lg mt-3">
                            <i class="bi bi-arrow-right-circle"></i> Registrar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-5">
        <small>Sistema de Inventario &copy; 2025</small>
    </footer>
</body>
</html>
