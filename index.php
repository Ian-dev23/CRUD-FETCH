<!DOCTYPE html>
<html>
<head>
    <!-- Estilos de Bootstrap para el diseño de la página -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Productos</title>
</head>
<body>

<div class="container py-4">
    <!-- Encabezado del formulario de registro -->
    <h2>Registro de Productos</h2>

    <!-- Alertas usando Bootstrap -->
    <div id="alertPlaceholder" class="alert d-none mt-3" role="alert"></div>

    <!-- Campo oculto para guardar el id cuando se edita -->
    <input type="hidden" id="id">

    <!-- Campos del formulario -->
    <label>Código</label>
    <input type="text" id="codigo">

    <br><br>

    <label>Producto</label>
    <input type="text" id="producto" class="form-control">

    <br><br>

    <label>Precio</label>
    <input type="number" id="precio" class="form-control">

    <br><br>

    <label>Cantidad</label>
    <input type="number" id="cantidad" min="1" class="form-control">

    <br><br>
    <label>Departamento</label>
    <input type="text" id="departamento" class="form-control">
    <br><br>

    <!-- Botón para guardar o actualizar el producto -->
    <button id="btnGuardar" class="btn btn-primary">
        Registrar
    </button>

    <hr>

    <!-- Tabla que muestra los productos existentes -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Departamento</th>
                    <th>Editar</th>
                </tr>
            </thead>
            <tbody id="tablaProductos"></tbody>
        </table>
    </div>

    <!-- Scripts para la lógica de la aplicación -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script.js"></script>
</div>
</body>
</html>