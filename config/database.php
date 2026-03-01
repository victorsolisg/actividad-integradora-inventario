<?php
$servidor="localhost";
$usuario="root";
$clave="";
$basedatos="inventario_vs";

$conexion = new mysqli($servidor,$usuario,$clave,$basedatos);

if($conexion->connect_error){
    die("Error de conexión: ".$conexion->connect_error);
}
?>
