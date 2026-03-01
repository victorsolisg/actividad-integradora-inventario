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
('Laptop HP Pavilion', 'Laptop 15.6 pulgadas, 8GB RAM, 256GB SSD', 899.99, 15),
('Mouse Logitech MX', 'Mouse inalámbrico ergonómico', 79.50, 45),
('Teclado Mecánico RGB', 'Teclado gaming switches blue', 125.00, 30),
('Monitor Samsung 24"', 'Monitor Full HD IPS 75Hz', 249.99, 20),
('Auriculares Sony WH', 'Auriculares bluetooth con cancelación de ruido', 199.00, 25),
('Webcam Logitech C920', 'Cámara web Full HD 1080p', 89.99, 35),
('Disco SSD 500GB', 'Unidad de estado sólido NVMe', 65.00, 50),
('Cable HDMI 2m', 'Cable HDMI 2.0 4K', 12.99, 100);

-- Ventas de ejemplo
INSERT INTO ventas (producto_id, cantidad, precio_venta, total) VALUES
(1, 2, 899.99, 1799.98),
(2, 5, 79.50, 397.50),
(3, 3, 125.00, 375.00),
(5, 1, 199.00, 199.00);

-- Actualizar stock después de ventas de ejemplo
UPDATE productos SET stock = stock - 2 WHERE id = 1;
UPDATE productos SET stock = stock - 5 WHERE id = 2;
UPDATE productos SET stock = stock - 3 WHERE id = 3;
UPDATE productos SET stock = stock - 1 WHERE id = 5;
