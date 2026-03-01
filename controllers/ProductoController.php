<?php
require_once __DIR__.'/../config/database.php';
require_once __DIR__.'/../models/Producto.php';

class ProductoController
{
    public function listarTodos()
    {
        global $conexion;
        return Producto::listar($conexion);
    }

    public function agregar($datos)
    {
        global $conexion;
        $producto=new Producto(
            $datos['nombre'] ?? '',
            $datos['descripcion'] ?? '',
            $datos['precio'] ?? '',
            $datos['stock'] ?? ''
        );

        if($producto->validar()){
            if($producto->guardar($conexion)){
                return ['ok'=>true,'msg'=>'Producto agregado exitosamente'];
            }
            return ['ok'=>false,'errores'=>['Error al guardar en base de datos']];
        }
        return ['ok'=>false,'errores'=>$producto->errores];
    }

    public function buscar($id)
    {
        global $conexion;
        return Producto::buscarPorId($conexion,$id);
    }

    public function modificar($id,$datos)
    {
        global $conexion;
        $producto=new Producto(
            $datos['nombre'] ?? '',
            $datos['descripcion'] ?? '',
            $datos['precio'] ?? '',
            $datos['stock'] ?? ''
        );

        if($producto->validar()){
            if($producto->modificar($conexion,$id)){
                return ['ok'=>true,'msg'=>'Producto modificado exitosamente'];
            }
            return ['ok'=>false,'errores'=>['Error al modificar en base de datos']];
        }
        return ['ok'=>false,'errores'=>$producto->errores];
    }

    public function borrar($id)
    {
        global $conexion;
        if(Producto::borrar($conexion,$id)){
            return ['ok'=>true,'msg'=>'Producto eliminado exitosamente'];
        }
        return ['ok'=>false,'errores'=>['Error al eliminar producto']];
    }
}
?>
