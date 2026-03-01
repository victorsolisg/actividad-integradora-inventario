<?php
require_once __DIR__.'/../models/Venta.php';
require_once __DIR__.'/../models/Producto.php';

class VentaService
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion=$conexion;
    }

    public function procesarVenta($producto_id,$cantidad)
    {
        $venta=new Venta($producto_id,$cantidad);

        if(!$venta->validar()){
            return ['ok'=>false,'errores'=>$venta->errores];
        }

        $producto=Producto::buscarPorId($this->conexion,$producto_id);

        if(!$producto){
            return ['ok'=>false,'errores'=>['Producto no encontrado']];
        }

        if($producto['stock']<$cantidad){
            return ['ok'=>false,'errores'=>['Stock insuficiente. Disponible: '.$producto['stock']]];
        }

        $venta->precio_venta=$producto['precio'];
        $venta->total=$producto['precio']*$cantidad;

        $this->conexion->begin_transaction();

        try{
            if(!$venta->registrar($this->conexion)){
                throw new Exception('Error al registrar venta');
            }

            $nuevoStock=$producto['stock']-$cantidad;
            $sql="UPDATE productos SET stock=? WHERE id=?";
            $stmt=$this->conexion->prepare($sql);
            $stmt->bind_param("ii",$nuevoStock,$producto_id);

            if(!$stmt->execute()){
                throw new Exception('Error al actualizar stock');
            }

            $this->conexion->commit();
            return ['ok'=>true,'msg'=>'Venta registrada correctamente'];

        }catch(Exception $e){
            $this->conexion->rollback();
            return ['ok'=>false,'errores'=>[$e->getMessage()]];
        }
    }

    public function listarVentas()
    {
        return Venta::listar($this->conexion);
    }
}
?>
