<?php
require_once __DIR__.'/../config/database.php';
require_once __DIR__.'/../services/VentaService.php';

class VentaController
{
    private $servicio;

    public function __construct()
    {
        global $conexion;
        $this->servicio=new VentaService($conexion);
    }

    public function listar()
    {
        return $this->servicio->listarVentas();
    }

    public function registrar($datos)
    {
        $producto_id=$datos['producto_id'] ?? '';
        $cantidad=$datos['cantidad'] ?? '';
        return $this->servicio->procesarVenta($producto_id,$cantidad);
    }

    public function obtenerProductos()
    {
        global $conexion;
        return Producto::listar($conexion);
    }
}
?>
