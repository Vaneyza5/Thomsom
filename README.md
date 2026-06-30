# Embotelladora Thomsom

sistema web para registrar y controlar los llenados de botellones de agua de la embotelladora thomsom.

## requisitos

- php 7.4 o superior
- mysql 5.7 o superior
- servidor web (apache recomendado)
- extensiones php: mysqli, mbstring, gd

## estructura del proyecto

```
thomsom/
├── index.php          # formulario de registro de llenado
├── principal.php      # panel principal con menu de opciones
├── historial.php      # tabla con todos los llenados registrados
├── eliminar.php       # elimina un registro de llenado
├── reporte.php        # genera un pdf con el historial
├── conexion.php       # configuracion de conexion a la base de datos
├── estilosc/
│   └── estilos.css    # estilos de la pagina
├── imagenes/          # imagenes y recursos graficos
├── american_years/    # fuentes tipograficas
├── fpdf19/            # libreria fpdf para generar pdfs
├── dompdf/            # libreria dompdf (opcional)
├── schema.sql         # script para crear las tablas en mysql
├── .htaccess          # configuracion de seguridad y rendimiento
└── README.md          # este archivo
```

## base de datos

el sistema usa dos tablas:

### tabla clientes
| campo | tipo | descripcion |
|---|---|---|
| id_cliente | int (auto increment) | identificador unico del cliente |
| nombre | varchar(255) | nombre del cliente |
| cedula_rif | varchar(50) | cedula o rif del cliente |

### tabla llenados
| campo | tipo | descripcion |
|---|---|---|
| id_llenados | int (auto increment) | identificador unico del llenado |
| cliente_id | int | id del cliente (relacion con clientes) |
| cantidad_botellones | int | cantidad de botellones llenados |
| fecha_hora | timestamp | fecha y hora del registro |

## instalacion

### 1. crear la base de datos

ejecuta el archivo `schema.sql` en phpmyadmin o en tu cliente mysql:

```sql
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
```

### 2. configurar conexion

edita `conexion.php` con los datos de tu base de datos:

```php
$host = "localhost";           // servidor mysql
$user = "tu_usuario";          // usuario de mysql
$password = "tu_contrasena";   // contrasena de mysql
$database = "tu_base_de_datos"; // nombre de la base de datos
```

### 3. subir los archivos

sube todo el proyecto a la carpeta `htdocs` (o `public_html`) de tu servidor web.

## funciones del sistema

### registrar llenado
- ingresa el nombre del cliente y la cantidad de botellones
- si el cliente no existe, se crea automaticamente
- los datos se guardan en la base de datos

### ver historial
- muestra una tabla con todos los llenados registrados
- ordena del mas reciente al mas antiguo
- incluye buscador por nombre de cliente
- permite descargar el historial en pdf

### eliminar registro
- borra un llenado del historial
- pide confirmacion antes de eliminar

### descargar pdf
- genera un pdf con el historial completo o filtrado
- incluye el logo de la empresa y los datos en formato tabla

## hosting en infinityfree

si vas a subir el sistema a infinityfree:

1. crea una base de datos desde el panel de control
2. anota el host, usuario, contrasena y nombre de la base de datos
3. ejecuta `schema.sql` en phpmyadmin
4. actualiza `conexion.php` con los datos de infinityfree
5. sube todos los archivos via file manager o ftp a la carpeta `htdocs`

## tecnologias usadas

- php
- mysql
- html / css
- fpdf (generacion de pdfs)

## autor

vaneyza5
