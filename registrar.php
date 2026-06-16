<?php

// Carga la clase Producto que maneja la conexión y operaciones
require_once "Modelo/Productos.php";

header('Content-Type: application/json');

// Lee la acción enviada desde JavaScript
$accion = $_POST['Accion'] ?? '';

$producto = new Producto();

function respuesta($success, $message, $data = null, $errors = null)
{
    $response = [
        'success' => $success,
        'message' => $message,
    ];

    if (!is_null($data)) {
        $response['data'] = $data;
    }

    if (!is_null($errors)) {
        $response['errors'] = $errors;
    }

    echo json_encode($response);
    exit;
}

try {
    switch ($accion) {
        case "Guardar":
        case "Modificar":
            $id = $_POST['id'] ?? '';
            $codigo = trim($_POST['codigo'] ?? '');
            $productoNombre = trim($_POST['producto'] ?? '');
            $precio = trim($_POST['precio'] ?? '');
            $cantidad = trim($_POST['cantidad'] ?? '');
            $departamento = trim($_POST['departamento'] ?? '');

            $errores = [];

            if ($codigo === '') {
                $errores['codigo'] = 'El código es obligatorio';
            }

            if ($productoNombre === '') {
                $errores['producto'] = 'El nombre del producto es obligatorio';
            }

            if ($precio === '') {
                $errores['precio'] = 'El precio es obligatorio';
            } elseif (!is_numeric($precio) || $precio < 0) {
                $errores['precio'] = 'Ingrese un precio válido';
            }

            if ($cantidad === '') {
                $errores['cantidad'] = 'La cantidad es obligatoria';
            } elseif (!is_numeric($cantidad) || $cantidad < 1) {
                $errores['cantidad'] = 'La cantidad debe ser mayor o igual a 1';
            }

            if ($departamento === '') {
                $errores['departamento'] = 'El departamento es obligatorio';
            }

            if (!empty($errores)) {
                respuesta(false, 'Error de validación', null, $errores);
            }

            $producto->setDatos(
                $codigo,
                $productoNombre,
                $precio,
                $cantidad,
                $departamento
            );

            if ($accion === "Guardar") {
                $resultado = $producto->guardar();
                respuesta($resultado, $resultado ? 'Producto guardado correctamente' : 'Error al guardar el producto');
            }

            if ($id === '') {
                respuesta(false, 'ID requerido para modificar');
            }

            $resultado = $producto->editar($id);
            respuesta($resultado, $resultado ? 'Producto actualizado correctamente' : 'Error al actualizar el producto');

        case "Buscar":
            $id = $_POST['id'] ?? '';

            if ($id === '') {
                respuesta(false, 'ID requerido para buscar');
            }

            $datos = $producto->buscar($id);

            if (!$datos) {
                respuesta(false, 'Producto no encontrado');
            }

            respuesta(true, 'Producto encontrado', $datos);

        case "Listar":
            $lista = $producto->listar();
            respuesta(true, 'Lista de productos obtenida', $lista);

        default:
            respuesta(false, 'Acción inválida');
    }
} catch (Exception $e) {
    respuesta(false, 'Error del servidor', null, ['exception' => $e->getMessage()]);
}