<?php
require_once __DIR__.'/../controllers/ProductoController.php';

$ctrl=new ProductoController();
$msg='';
$errores=[];
$editar=null;

if(isset($_GET['borrar'])){
    $res=$ctrl->borrar((int)$_GET['borrar']);
    if($res['ok']) $msg=$res['msg'];
    else $errores=$res['errores'];
}

if(isset($_GET['editar'])){
    $editar=$ctrl->buscar((int)$_GET['editar']);
}

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $datos=[
        'nombre'=>$_POST['nombre'] ?? '',
        'descripcion'=>$_POST['descripcion'] ?? '',
        'precio'=>$_POST['precio'] ?? '',
        'stock'=>$_POST['stock'] ?? ''
    ];

    if(isset($_POST['id']) && $_POST['id']!==''){
        $res=$ctrl->modificar((int)$_POST['id'],$datos);
    }else{
        $res=$ctrl->agregar($datos);
    }

    if($res['ok']){
        $msg=$res['msg'];
        $editar=null;
    }else{
        $errores=$res['errores'];
        $editar=$datos;
        if(isset($_POST['id'])) $editar['id']=$_POST['id'];
    }
}

$lista=$ctrl->listarTodos();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - Inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .bg-teal{background-color:#20c997!important}
        .btn-teal{background-color:#20c997;border-color:#20c997;color:#fff}
        .btn-teal:hover{background-color:#1aa179;border-color:#1aa179;color:#fff}
        .text-teal{color:#20c997!important}
        .table-hover tbody tr:hover{background-color:rgba(32,201,151,0.1)}
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-teal">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-box-seam"></i> Inventario
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link active" href="productos.php">Productos</a>
                <a class="nav-link" href="ventas.php">Ventas</a>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow">
                    <div class="card-header bg-teal text-white">
                        <i class="bi bi-<?=$editar?'pencil':'plus-circle'?>"></i>
                        <?=$editar?'Modificar Producto':'Nuevo Producto'?>
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
                            <input type="hidden" name="id" value="<?=htmlspecialchars($editar['id'] ?? '')?>">

                            <div class="mb-3">
                                <label class="form-label">Nombre *</label>
                                <input type="text" name="nombre" class="form-control"
                                       value="<?=htmlspecialchars($editar['nombre'] ?? '')?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Descripción</label>
                                <textarea name="descripcion" class="form-control" rows="2"><?=htmlspecialchars($editar['descripcion'] ?? '')?></textarea>
                            </div>

                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label">Precio *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" name="precio" class="form-control"
                                               value="<?=htmlspecialchars($editar['precio'] ?? '')?>" required>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Stock *</label>
                                    <input type="number" name="stock" class="form-control"
                                           value="<?=htmlspecialchars($editar['stock'] ?? '')?>" required>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-teal">
                                    <i class="bi bi-save"></i> <?=$editar?'Actualizar':'Guardar'?>
                                </button>
                                <?php if($editar): ?>
                                <a href="productos.php" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle"></i> Cancelar
                                </a>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card border-0 shadow">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-list-ul"></i> Catálogo de Productos</span>
                        <span class="badge bg-light text-dark"><?=count($lista)?> productos</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Producto</th>
                                        <th class="text-end">Precio</th>
                                        <th class="text-center">Stock</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($lista as $p): ?>
                                    <tr>
                                        <td><?=htmlspecialchars($p['id'])?></td>
                                        <td>
                                            <strong><?=htmlspecialchars($p['nombre'])?></strong>
                                            <?php if($p['descripcion']): ?>
                                            <br><small class="text-muted"><?=htmlspecialchars(substr($p['descripcion'],0,50))?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end">$<?=number_format($p['precio'],2)?></td>
                                        <td class="text-center">
                                            <?php if($p['stock']<=5): ?>
                                            <span class="badge bg-danger"><?=$p['stock']?></span>
                                            <?php elseif($p['stock']<=15): ?>
                                            <span class="badge bg-warning text-dark"><?=$p['stock']?></span>
                                            <?php else: ?>
                                            <span class="badge bg-success"><?=$p['stock']?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="?editar=<?=$p['id']?>" class="btn btn-sm btn-outline-primary" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="?borrar=<?=$p['id']?>" class="btn btn-sm btn-outline-danger"
                                               onclick="return confirm('¿Eliminar este producto?')" title="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
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
