<?php
class Venta
{
    public $id;
    public $producto_id;
    public $cantidad;
    public $precio_venta;
    public $total;
    public $errores=[];

    public function __construct($producto_id,$cantidad)
    {
        $this->producto_id=trim($producto_id);
        $this->cantidad=trim($cantidad);
    }

    public function validar()
    {
        if(!ctype_digit($this->producto_id) || $this->producto_id<=0){
            $this->errores[]="Seleccione un producto";
        }

        if(!ctype_digit($this->cantidad) || $this->cantidad<=0){
            $this->errores[]="Cantidad debe ser mayor a cero";
        }

        return empty($this->errores);
    }

    public function registrar($conexion)
    {
        $sql="INSERT INTO ventas(producto_id,cantidad,precio_venta,total) VALUES(?,?,?,?)";
        $stmt=$conexion->prepare($sql);
        $stmt->bind_param("iidd",$this->producto_id,$this->cantidad,$this->precio_venta,$this->total);
        return $stmt->execute();
    }

    public static function listar($conexion)
    {
        $sql="SELECT v.*,p.nombre as producto
              FROM ventas v
              INNER JOIN productos p ON v.producto_id=p.id
              ORDER BY v.id DESC";
        $resultado=$conexion->query($sql);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
}
?>
