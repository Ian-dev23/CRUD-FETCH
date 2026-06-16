# CRUD de Productos con Fetch API, PHP OOP y MySQL

## Descripción

Aplicación web desarrollada bajo una arquitectura cliente-servidor que permite gestionar un catálogo de productos mediante operaciones CRUD (Crear, Buscar, Modificar y Listar).

El proyecto implementa comunicación asíncrona utilizando Fetch API, programación orientada a objetos en PHP, conexión segura a MySQL mediante PDO y respuestas en formato JSON.

## Tecnologías Utilizadas

* HTML5
* CSS3
* Bootstrap 5
* JavaScript ES6
* Fetch API
* SweetAlert2
* PHP Orientado a Objetos (OOP)
* MySQL
* PDO (PHP Data Objects)

## Funcionalidades

### Registro de Productos

Permite agregar nuevos productos al sistema mediante un formulario dinámico.

### Búsqueda de Productos

Recupera la información de un producto seleccionado para su edición.

### Modificación de Productos

Actualiza los datos de un producto existente.

### Listado de Productos

Muestra todos los productos registrados en una tabla dinámica.

### Validaciones

* Validación de campos obligatorios en el cliente (JavaScript).
* Validación de datos en el servidor (PHP).
* Restricción de cantidad mínima igual a 1.

### Manejo de Errores

* Alertas amigables mediante SweetAlert2.
* Captura de errores en Fetch usando catch().
* Respuestas estructuradas en formato JSON.

## Estructura del Proyecto

```text
ProyectoCRUD/
│
├── index.php
├── script.js
├── registrar.php
│
└── Modelo/
    ├── conexion.php
    └── Productos.php
```

## Base de Datos

### Crear la base de datos

```sql
CREATE DATABASE productosdb;
```

### Seleccionar la base de datos

```sql
USE productosdb;
```

### Crear la tabla productos

```sql
CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(20) NOT NULL,
    producto VARCHAR(100) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    cantidad INT NOT NULL,
    departamento VARCHAR(25) NOT NULL
);
```

## Configuración

Editar el archivo:

```text
Modelo/conexion.php
```

y configurar los parámetros de conexión:

```php
private $host = "localhost";
private $dbname = "productosdb";
private $user = "root";
private $pass = "";
```

## Ejecución

1. Iniciar Apache y MySQL desde XAMPP.
2. Copiar el proyecto dentro de la carpeta htdocs.
3. Importar la base de datos.
4. Abrir el navegador.
5. Acceder a:

```text
http://localhost/ProyectoCRUD/
```

## Arquitectura

### Frontend

* Captura eventos del formulario.
* Envía datos mediante Fetch API.
* Recibe respuestas JSON.
* Actualiza la interfaz dinámicamente.
* Muestra alertas con SweetAlert2.

### Backend

* Recibe peticiones POST.
* Utiliza switch para determinar la acción solicitada.
* Valida los datos recibidos.
* Ejecuta operaciones CRUD mediante clases PHP OOP.
* Devuelve respuestas JSON.

## Formato de Respuesta JSON

### Éxito

```json
{
  "success": true,
  "message": "Producto guardado correctamente",
  "errors": []
}
```

### Error

```json
{
  "success": false,
  "message": "Error de validación",
  "errors": [
    "Código requerido",
    "Precio requerido"
  ]
}
```

## Autor

Ian Torres

Proyecto académico desarrollado para la asignatura de Desarrollo Web utilizando Fetch API, PHP OOP y MySQL.
