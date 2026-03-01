<?php
require_once __DIR__.'/../controllers/VentaController.php';

$ctrl=new VentaController();
$msg='';
$errores=[];

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $datos=[
        'producto_id'=>$_POST['producto_id'] ?? '',
        'cantidad'=>$_POST['cantidad'] ?? ''
    ];

    $res=$ctrl->registrar($datos);

    if($res['ok']){
        $msg=$res['msg'];
    }else{
        $errores=$res['errores'];
    }
}

$productos=$ctrl->obtenerProductos();
$ventas=$ctrl->listar();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas - Inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .bg-teal{background-color:#20c997!important}
        .btn-teal{background-color:#20c997;border-color:#20c997;color:#fff}
        .btn-teal:hover{background-color:#1aa179;border-color:#1aa179;color:#fff}
        .text-teal{color:#20c997!important}
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
                <a class="nav-link active" href="ventas.php">Ventas</a>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow">
                    <div class="card-header bg-teal text-white">
                        <i class="bi bi-cart-plus"></i> Nueva Venta
                    </div>
                    <div class="card-body">
                        <?php if($msg): ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="bi bi-check-circle"></i> <?=htmlspecialchars($msg)?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php endif; ?>

                        <?php if(!empty($errores)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0 ps-3">
                                <?php foreach($errores as $e): ?>
                                <li><?=htmlspecialchars($e)?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>

                        <form method="post">
                            <div class="mb-3">
                                <label class="form-label">Producto *</label>
                                <select name="producto_id" class="form-select" required>
                                    <option value="">-- Seleccionar --</option>
                                    <?php foreach($productos as $p): ?>
                                    <option value="<?=$p['id']?>">
                                        <?=htmlspecialchars($p['nombre'])?> - $<?=number_format($p['precio'],2)?> (<?=$p['stock']?> disp.)
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Cantidad *</label>
                                <input type="number" name="cantidad" class="form-control" min="1" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-teal">
                                    <i class="bi bi-bag-check"></i> Registrar Venta
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card border-0 shadow">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-receipt"></i> Historial de Ventas</span>
                        <span class="badge bg-light text-dark"><?=count($ventas)?> ventas</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Producto</th>
                                        <th class="text-center">Cant.</th>
                                        <th class="text-end">P. Unit.</th>
                                        <th class="text-end">Total</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($ventas as $v): ?>
                                    <tr>
                                        <td><?=htmlspecialchars($v['id'])?></td>
                                        <td><?=htmlspecialchars($v['producto'])?></td>
                                        <td class="text-center"><?=htmlspecialchars($v['cantidad'])?></td>
                                        <td class="text-end">$<?=number_format($v['precio_venta'],2)?></td>
                                        <td class="text-end fw-bold">$<?=number_format($v['total'],2)?></td>
                                        <td><small><?=htmlspecialchars($v['fecha_venta'])?></small></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
