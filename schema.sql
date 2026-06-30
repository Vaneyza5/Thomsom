-- =============================================
--  SCRIPT PARA CREAR LAS TABLAS EN INFINITYFREE
-- =============================================
-- 1. Entra a phpMyAdmin de InfinityFree
-- 2. Selecciona tu base de datos
-- 3. Ve a la pestana "SQL"
-- 4. Pega y ejecuta este script
-- =============================================

CREATE TABLE IF NOT EXISTS clientes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    cedula_rif VARCHAR(50) DEFAULT 'N/A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS llenados (
    id_llenados INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    cantidad_botellones INT NOT NULL,
    fecha_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id_cliente)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
