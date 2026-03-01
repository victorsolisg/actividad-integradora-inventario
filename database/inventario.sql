CREATE DATABASE IF NOT EXISTS inventario_vs;
USE inventario_vs;

CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE ventas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    precio_venta DECIMAL(10,2) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    fecha_venta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (producto_id) REFERENCES productos(id)
);

-- Datos de ejemplo
INSERT INTO productos (nombre, descripcion, precio, stock) VALUES
('Laptop Dell Inspiron', 'Laptop 15.6", Intel i5, 8GB RAM, 512GB SSD', 750.00, 10),
('Monitor LG 27"', 'Monitor IPS Full HD 75Hz', 280.00, 15),
('Teclado Logitech K380', 'Teclado bluetooth multidispositivo', 45.00, 25),
('Mouse Inalámbrico HP', 'Mouse óptico 2.4GHz', 18.50, 40),
('Impresora Epson L3250', 'Impresora multifuncional WiFi', 220.00, 8);
