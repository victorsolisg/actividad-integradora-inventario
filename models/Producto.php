<?php
class Producto
{
    public $id;
    public $nombre;
    public $descripcion;
    public $precio;
    public $stock;
    public $errores=[];

    public function __construct($nombre,$descripcion,$precio,$stock)
    {
        $this->nombre=trim($nombre);
        $this->descripcion=trim($descripcion);
        $this->precio=trim($precio);
        $this->stock=trim($stock);
    }

    public function validar()
    {
        if($this->nombre==='' || strlen($this->nombre)<2){
            $this->errores[]="Nombre es requerido (mínimo 2 caracteres)";
        }

        if(!is_numeric($this->precio) || $this->precio<=0){
            $this->errores[]="Precio debe ser mayor a cero";
        }

        if(!ctype_digit($this->stock) && $this->stock!=='0'){
            $this->errores[]="Stock debe ser número entero";
        }else{
            if((int)$this->stock<0){
                $this->errores[]="Stock no puede ser negativo";
            }
        }

        return empty($this->errores);
    }

    public function guardar($conexion)
    {
        $sql="INSERT INTO productos(nombre,descripcion,precio,stock) VALUES(?,?,?,?)";
        $stmt=$conexion->prepare($sql);
        $stmt->bind_param("ssdi",$this->nombre,$this->descripcion,$this->precio,$this->stock);
        return $stmt->execute();
    }

    public static function listar($conexion)
    {
        $sql="SELECT * FROM productos ORDER BY id DESC";
        $resultado=$conexion->query($sql);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public static function buscarPorId($conexion,$id)
    {
        $sql="SELECT * FROM productos WHERE id=?";
        $stmt=$conexion->prepare($sql);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function modificar($conexion,$id)
    {
        $sql="UPDATE productos SET nombre=?,descripcion=?,precio=?,stock=? WHERE id=?";
        $stmt=$conexion->prepare($sql);
        $stmt->bind_param("ssdii",$this->nombre,$this->descripcion,$this->precio,$this->stock,$id);
        return $stmt->execute();
    }

    public static function borrar($conexion,$id)
    {
        $sql="DELETE FROM productos WHERE id=?";
        $stmt=$conexion->prepare($sql);
        $stmt->bind_param("i",$id);
        return $stmt->execute();
    }
}
?>
